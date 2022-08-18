<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionProducts;
use App\Models\Tva;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $this->authorize('transaction-index');

        $limit = request('limit') ? request('limit') : 10;

        $transactions = Transaction::select('id', 'created_at', 'first_name', 'last_name', 'total')
                                    ->with('transactionProducts:quantity,product,subtotal,transaction_id')
                                    ->paginate($limit);

        return response($transactions, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('transaction-store');

        $request->validate([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'phone' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email'],
            'address' => ['nullable'],
            'tva_id' => ['required'],
            'note' => ['nullable'],
            'products' => ['required'],
        ]);

        $subTotal = 0;
        $total = 0;

        foreach($request->products as $product){
            $productTran = Product::where('id', $product['product_id'])->first();

            $subTotal = $subTotal + $productTran->cost_price * $product['quantity'];
        }

        $tva = Tva::where('id', $request->tva_id)->first();

        $total = $subTotal + ($tva->tva * $subTotal / 100);

        $transaction = Transaction::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'tva_id' => $request->tva_id,
            'note' => $request->note,
            'subTotal' => $subTotal,
            'total' => $total,
        ]);

        foreach($request->products as $product){
            $productTran = Product::where('id', $product['product_id'])->first();

            TransactionProducts::create([
                'transaction_id' => $transaction->id,
                'product_id' => $productTran->id,
                'quantity' => $product['quantity'],
                'subtotal' => $productTran->cost_price * $product['quantity'],
                'product' => $productTran->name
            ]);
        }

        return response(['message' => 'Transaction created successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OwnTransaction  $ownTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $this->authorize('transaction-show');

        $transaction->load('tva:id,tva', 'transactionPayment.paymentMethod', 'transactionProducts');

        return response(['transaction' => $transaction], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OwnTransaction  $ownTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('transaction-update');

        $request->validate([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'phone' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email'],
            'address' => ['nullable'],
            'note' => ['nullable'],
            'products' => ['required'],
        ]);

        $subTotal = 0;
        $total = 0;

        foreach($request->products as $product){
            $productTran = Product::where('id', $product['product_id'])->first();

            $subTotal = $subTotal + $productTran->cost_price * $product['quantity'];
        }

        $tva = Tva::where('id', $transaction->tva_id)->first();

        $total = $subTotal + ($tva->tva * $subTotal / 100);

        $transaction->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'note' => $request->note,
            'subTotal' => $subTotal,
            'total' => $total,
        ]);

        foreach($request->products as $product){
            $productTran = Product::where('id', $product['product_id'])->first();

            $transactionProducts = TransactionProducts::where('transaction_id', $transaction->id)
                                                      ->where('product_id', $productTran->id)
                                                      ->first();

            if(!$transactionProducts){
                TransactionProducts::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $productTran->id,
                    'quantity' => $product['quantity'],
                    'subtotal' => $productTran->cost_price * $product['quantity'],
                    'product' => $productTran->name
                ]);
            }

            return response(['message' => 'Transaction updated successfully'], 200);
        }
    }
}
