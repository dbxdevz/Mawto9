<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function customer(Request $request)
    {

        $this->authorize('customer-index');

        $limit = request('limit') ? request('limit') : 10;
        $searchString = $request->country;
        $customers = Customer
                        ::where('first_name', 'LIKE', '%'.$request->name.'%')
                        ->where('last_name', 'LIKE', '%'.$request->name.'%')
                        ->where('phone', 'LIKE', '%'.$request->phone.'%')
                        ->whereHas('Country', function ($query) use ($searchString){
                            $query->where('name', 'like', '%'.$searchString.'%');
                        })
                        ->select(
                            'id',
                            'first_name',
                            'last_name',
                            'address',
                            'phone',
                            'email',
                            'country_id',
                            'city_id',
                            'whatsapp'
                        )
                        ->with(['Country' => function($query) use ($searchString){
                            $query
                                ->where('name', 'like', '%'.$searchString.'%')
                                ->select('id', 'name');
                        }, 'City:id,name'])->paginate($limit);

        return response($customers);
    }
}
