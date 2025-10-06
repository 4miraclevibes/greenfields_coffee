<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Room;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function transaction($roomId)
    {
        $room = Room::findOrFail($roomId);
        $menus = Menu::where('is_available', true)->get();

        return view('pages.frontend.transaction', compact('room', 'menus'));
    }

    public function storeTransaction(Request $request)
    {
        // Debug request data
        \Log::info('Transaction request data:', $request->all());

        try {
            $request->validate([
                'room_id' => 'required|exists:rooms,id',
                'location' => 'required|string|max:255',
                'items' => 'required|array|min:1',
                'items.*.menu_id' => 'required|exists:menus,id',
                'items.*.employee' => 'required|string|max:255',
                'items.*.variant' => 'required|in:less_sugar,normal,no_sugar'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        }

        DB::beginTransaction();

        try {
            // Create transaction
            $transaction = Transaction::create([
                'user_id' => 1, // Default user for now
                'room_id' => $request->room_id,
                'location' => $request->location,
                'status' => 'pending'
            ]);

            \Log::info('Transaction created:', $transaction->toArray());

            // Create transaction details - each item is separate (no quantity field)
            foreach ($request->items as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'menu_id' => $item['menu_id'],
                    'quantity' => 1, // Always 1 since each item is separate
                    'employee' => $item['employee'],
                    'variant' => $item['variant']
                ]);
            }

            DB::commit();

            \Log::info('Transaction completed successfully');
            $this->sendWhatsappNotification($transaction);
            return redirect()->route('transaction.result', $transaction->id)
                           ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Transaction failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Terjadi kesalahan saat membuat pesanan: ' . $e->getMessage());
        }
    }

    public function transactionResult($transactionId)
    {
        $transaction = Transaction::with(['room', 'transactionDetails.menu'])
                                ->findOrFail($transactionId);

        return view('pages.frontend.transaction-result', compact('transaction'));
    }

    public function queue()
    {
        // 1. Get today's transactions ordered by created_at to establish initial queue numbers
        $initialOrderedTransactions = Transaction::with(['room', 'transactionDetails.menu', 'user'])
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->get();

        // 2. Assign a static queue number based on their creation order for the day
        $initialOrderedTransactions->each(function ($transaction, $index) {
            $transaction->queue_number = $index + 1;
        });

        // 3. Now, re-sort the collection for display purposes (pending first, then process, then completed, then canceled)
        $transactions = $initialOrderedTransactions->sortBy(function ($transaction) {
            switch ($transaction->status) {
                case 'pending': return 0;
                case 'process': return 1;
                case 'completed': return 2;
                case 'canceled': return 3;
                default: return 4;
            }
        })->values(); // Re-index the collection after sorting

        return view('pages.frontend.queue', compact('transactions'));
    }

    public function bartenderPickOrder()
    {
        // Get pending transactions only
        $transactions = Transaction::with(['room', 'transactionDetails.menu'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('pages.frontend.bartender-pick', compact('transactions'));
    }

    public function bartenderPickOrderStore(Request $request, Transaction $transaction)
    {
        // Validate that transaction is still pending
        if ($transaction->status !== 'pending') {
            return redirect()->route('bartender.pick.order')
                           ->with('error', 'Pesanan ini sudah diambil oleh bartender lain.');
        }

        // Update transaction status to process and assign to current user
        $transaction->update([
            'status' => 'process',
            'user_id' => Auth::id()
        ]);

        return redirect()->route('bartender.pick.order')
                       ->with('success', 'Pesanan berhasil diambil! Silakan proses pesanan.');
    }

    private function sendWhatsappNotification($transaction)
    {
        // Kata-kata intro
        $intro = [
            "Ada pesanan kopi baru nih",
            "Order kopi masuk",
            "Ada order baru",
            "Pesanan kopi nih",
            "Ada pesanan masuk"
        ];

        // Pilih secara random
        $selectedIntro = $intro[array_rand($intro)];

        // Load transaction dengan relasi yang diperlukan
        $transaction = $transaction->load(['room', 'transactionDetails.menu']);

        // Variant labels
        $variantLabels = [
            'less_sugar' => 'Kurang Manis',
            'normal' => 'Normal',
            'no_sugar' => 'Tanpa Gula'
        ];

        // Format pesan WhatsApp
        $message = "☕ *PESANAN KOPI BARU!*\n\n"
            . "*{$selectedIntro}!*\n\n"
            . "ID Pesanan: *#{$transaction->id}*\n"
            . "Ruangan: *{$transaction->room->name}*\n"
            . "Lokasi Kirim: *{$transaction->location}*\n"
            . "Waktu Pesan: *{$transaction->created_at->format('d/m/Y H:i')}*\n"
            . "Status: *" . ucfirst($transaction->status) . "*\n\n"
            . "*Detail Pesanan ({$transaction->transactionDetails->count()} Item):*\n";

        // Tambahkan detail menu
        $itemNumber = 1;
        foreach ($transaction->transactionDetails as $detail) {
            $variantText = $variantLabels[$detail->variant] ?? $detail->variant;
            $message .= "{$itemNumber}. {$detail->menu->name}\n"
                . "   👤 Untuk: {$detail->employee}\n"
                . "   🎚️ Varian: {$variantText}\n"
                . "   📦 Qty: {$detail->quantity}x\n\n";
            $itemNumber++;
        }

        $message .= "⏰ *Segera proses pesanan ini!*\n"
            . "📍 Kirim ke: *{$transaction->location}*\n\n"
            . "👉 *Ambil pesanan:*\n"
            . url('/bartender/pick-order');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => '6281261686210', // Nomor admin/bartender
                'message' => $message
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: BehwfEMKPuLsQByWe138' // Ganti dengan token Fonnte Anda
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
