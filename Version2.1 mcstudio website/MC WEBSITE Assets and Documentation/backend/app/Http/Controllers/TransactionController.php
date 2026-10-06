<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    /**
     * Get all transactions.
     */
    public function index(): JsonResponse
    {
        $transactions = Transaction::query()->latest()->get();

        return response()->json($transactions);
    }

    /**
     * Get a single transaction by id.
     */
    public function show(int $id): JsonResponse
    {
        $transaction = Transaction::query()->findOrFail($id);

        return response()->json($transaction);
    }

    /**
     * Get transactions by user id.
     *
     * Note: A transaction links to an order or purchase order, each of which belongs to a user.
     */
    public function byUser(int $userId): JsonResponse
    {
        $transactions = Transaction::query()
            ->whereHas('order', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->orWhereHas('purchase_order', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->latest()
            ->get();

        return response()->json($transactions);
    }
}


