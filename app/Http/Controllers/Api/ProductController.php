<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('product-index');

        $products = Product::select(
                        'id',
                        'name',
                        'label',
                        'code',
                        'cost_price',
                        'selling_price',
                        'color',
                        'description',
                        'available'
                    )
                    ->paginate(10);

        return response(['products' => $products], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('product-store');

        $data = $request->validated();

        Product::create($data);

        return response(['message' => 'Product created successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $this->authorize('product-show');

        $product = $product->select(
                        'name',
                        'label',
                        'code',
                        'cost_price',
                        'selling_price',
                        'color',
                        'description',
                    );

        return response(['product' => $product], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Product $product)
    {
        $this->authorize('product-update');

        $data = $request->validated();

        $product->update($data);

        return response(['message' => 'Product updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('product-destroy');


    }
}
