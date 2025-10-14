<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        // 1. Get today's transactions ordered by created_at to establish initial queue numbers
        $initialOrderedTransactions = Transaction::with(['user', 'room', 'transactionDetails.menu'])
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->get();

        // 2. Assign a static queue number based on their creation order for the day
        $initialOrderedTransactions->each(function ($transaction, $index) {
            $transaction->queue_number = $index + 1;
        });

        // 3. Now, re-sort the collection for display purposes
        // Sort by: status priority first (pending, process, completed, canceled)
        // Then by: queue_number (earliest antrian first within same status)
        $transactions = $initialOrderedTransactions->sort(function ($a, $b) {
            $statusPriority = [
                'pending' => 0,
                'process' => 1,
                'completed' => 2,
                'cancel' => 3
            ];

            $aPriority = $statusPriority[$a->status] ?? 4;
            $bPriority = $statusPriority[$b->status] ?? 4;

            // First, sort by status priority
            if ($aPriority !== $bPriority) {
                return $aPriority - $bPriority;
            }

            // If same status, sort by queue_number (earlier queue first)
            return $a->queue_number - $b->queue_number;
        })->values(); // Re-index the collection after sorting

        return view('pages.backend.transactions.index', compact('transactions'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,process,completed,cancel',
            'responsible_person' => 'nullable|required_if:status,process|exists:users,id'
        ]);

        $updateData = ['status' => $request->status];

        // If status is process, update user_id to responsible person
        if ($request->status === 'process' && $request->responsible_person) {
            $updateData['user_id'] = $request->responsible_person;
        }

        $transaction->update($updateData);

        return redirect()->route('transactions.index')->with('success', 'Transaction status updated successfully.');
    }
}
