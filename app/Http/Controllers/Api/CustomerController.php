<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coustomer\StoreRequset;
use App\Http\Requests\Coustomer\UpdateRequset;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize(('customer-index'));

        $customers = Customer
            ::select(
                'first_name',
                'last_name',
                'address',
                'phone',
                'email',
                'country_id',
                'city_id'
            )
            ->with(['Country:id,name', 'City:id,name'])
            ->paginate(10);

            return response($customers, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequset $request)
    {
        $this->authorize(('customer-store'));

        $data = $request->validated();

        Customer::create($data);

        return response(['message' => 'Customer created successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $this->authorize(('customer-show'));

        $customer = Customer::where('id', $request->customer)->select(
            'first_name',
            'last_name',
            'address',
            'phone',
            'email',
            'country_id',
            'city_id'
        )
        ->with(['Country:id,name', 'City:id,name'])
        ->first()
        ;

        return response(['customer' => $customer], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequset $request, Customer $customer)
    {
        $this->authorize(('customer-update'));

        $data = $request->validated();

        $customer->update($data);

        return response(['message' => 'Customer updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $this->authorize(('customer-destroy'));

        $customer->delete();

        return response(['message' => 'Customer deleted successfully'], 200);
    }
}
