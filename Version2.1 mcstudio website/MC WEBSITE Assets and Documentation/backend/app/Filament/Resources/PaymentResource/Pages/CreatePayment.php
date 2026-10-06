<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Models\Transaction;
use Filament\Pages\Actions;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PaymentResource;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    public function afterCreate(): void
    {
        $payment = $this->record;
        $transaction = DB::table('transactions')->whereNotNull('created_at')->latest('created_at')->first();
        if($transaction){
        $newTransaction= ($transaction->id) +1;
        }
        else{
            $newTransaction= 1;
        }
        // create a transaction
        Transaction::create([
            'number'  => $newTransaction,
            'payment_reference'  => $payment->reference,
            'type'    => 'income',
            'method'  => 'bank',
            'order_id'  => $payment->order_id,
            'amount'  => $payment->amount,
            'currency'  => $payment->currency
        ]);
    }
}
