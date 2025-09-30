<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'room', 'transactionDetails.menu'])->orderBy('created_at', 'desc')->get();
        return view('pages.backend.transactions.index', compact('transactions'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,process,completed,cancel',
            'responsible_person' => 'required_if:status,process|exists:users,id'
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
