<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Room;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request headers:', $request->headers->all());

        // Parse items from JSON string if it's a string
        $items = $request->items;
        if (is_string($items)) {
            $items = json_decode($items, true);
        }

        \Log::info('Parsed items:', $items);

        $request->merge(['items' => $items]);

        try {
            $request->validate([
                'room_id' => 'required|exists:rooms,id',
                'items' => 'required|array|min:1',
                'items.*.menu_id' => 'required|exists:menus,id',
                'items.*.quantity' => 'required|integer|min:1',
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
                'status' => 'pending'
            ]);

            \Log::info('Transaction created:', $transaction->toArray());

            // Create transaction details
            foreach ($request->items as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'menu_id' => $item['menu_id'],
                    'quantity' => $item['quantity'],
                    'variant' => $item['variant']
                ]);
            }

            DB::commit();

            \Log::info('Transaction completed successfully');

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
}
