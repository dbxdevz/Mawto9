<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OwnTransaction;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\TransactionPayment;
use Illuminate\Http\Request;

class TransactionPayController extends Controller
{

    public function index()
    {
        $this->authorize('transaction-index');

        $payMethods = PaymentMethod::select('id', 'method')
                                   ->get()
        ;

        return response(['payMethods' => $payMethods], 200);
    }

    public function store(Request $request)
    {
        $this->authorize('transaction-store');

        $request->validate([
                               'amount'            => ['required'],
                               'payment_method_id' => ['required'],
                               'pay_note'          => ['nullable'],
                           ]);

        $transaction         = OwnTransaction::where('id', $request->transactionId)
                                             ->first()
        ;
        $transactionPayments = TransactionPayment::where('own_transaction_id', $request->transactionId)
                                                 ->get()
                                                 ->sum('amount')
        ;

        if ($transaction->total < $request->amount or $transactionPayments + $request->amount > $transaction->total) {
            return response(['message' => 'Total paid must not be greater than the total amount'], 418);
        }

        TransactionPayment::create([
                                       'own_transaction_id' => $request->transactionId,
                                       'amount'             => $request->amount,
                                       'payment_method_id'  => $request->payment_method_id,
                                       'pay_note'           => $request->pay_note,
                                   ]);

        return response(['message' => 'Transaction pay created successfully'], 200);
    }

    public function destroy(Request $request)
    {
        $this->authorize('transaction-destroy');

        $transactionPayment = TransactionPayment::where('id', $request->TransactionPaymentId)
                                                ->first()
        ;
        $transactionPayment->delete();

        return response(['message' => 'Deleted successfully'], 200);
    }

    public function storeT(Request $request)
    {
        $this->authorize('transaction-store');

        $request->validate([
                               'amount'            => ['required'],
                               'payment_method_id' => ['required'],
                               'pay_note'          => ['nullable'],
                           ]);

        $transaction         = Transaction::where('id', $request->transactionId)
                                          ->first()
        ;
        $transactionPayments = TransactionPayment::where('transaction_id', $request->transactionId)
                                                 ->get()
                                                 ->sum('amount')
        ;

        if ($transaction->total < $request->amount or $transactionPayments + $request->amount > $transaction->total) {
            return response(['message' => 'Total paid must not be greater than the total amount'], 418);
        }

        TransactionPayment::create([
                                       'transaction_id'    => $request->transactionId,
                                       'amount'            => $request->amount,
                                       'payment_method_id' => $request->payment_method_id,
                                       'pay_note'          => $request->pay_note,
                                   ]);

        return response(['message' => 'Transaction pay created successfully'], 200);
    }

    public function destroyT(Request $request)
    {
        $this->authorize('transaction-destroy');

        $transactionPayment = TransactionPayment::where('id', $request->TransactionPaymentId)
                                                ->first()
        ;
        $transactionPayment->delete();

        return response(['message' => 'Deleted successfully'], 200);
    }
}
