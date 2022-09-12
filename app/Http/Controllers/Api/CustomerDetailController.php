<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerDetailController extends Controller
{
    public function crud(Request $request)
    {
        $this->authorize('customer-store');

        $request->validate([
                               'id'         => ['nullable'],
                               'first_name' => ['required', 'max:255'],
                               'last_name'  => ['required', 'max:255'],
                               'address'    => ['required', 'max:255'],
                               'phone'      => ['required', Rule::unique('customers', 'phone')
                                                                ->ignore($request->id)],
                               'city_id'    => ['required'],
                               'country_id' => ['required'],
                               'whatsapp'   => ['nullable'],
                           ]);

        $customer = Customer::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'phone'      => $request->phone,
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'address'    => $request->address,
                'city_id'    => $request->city_id,
                'country_id' => $request->country_id,
                'whatsapp'   => $request->whatsap,
            ]
        );

        return response(['message' => 'Success', 'customer_id' => $customer->id], 200);
    }

    // public function search(Request $request)
    // {
    //     $customer = Customer::where(['phone', 'LIKE', $request->search])->orWhere('last_name')
    // }
}
