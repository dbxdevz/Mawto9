<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MessageTemplate;
use App\Models\Product;
use App\Models\User;
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
                        ->orWhere('last_name', 'LIKE', '%'.$request->name.'%')
                        ->orWhere('phone', 'LIKE', '%'.$request->phone.'%')
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

        return response($customers, 200);
    }

    public function products(Request $request)
    {
        $products = Product::where('name', 'LIKE', '%'.$request->name.'%')
                        ->where('available', false)
                        ->select('id', 'name', 'selling_price', 'color')
                        ->get();

        return response($products, 200);
    }

    public function users(Request $request)
    {

        $this->authorize('user-index');

        $limit = request('limit') ? request('limit') : 10;
        $searchString = $request->role;
        $users = User
                        ::where('name', 'LIKE', '%'.$request->name.'%')
                        ->orWhere('email', 'LIKE', '%'.$request->email.'%')
                        ->whereHas('roles', function ($query) use ($searchString){
                            $query->where('name', 'like', '%'.$searchString.'%');
                        })
                        ->select('id', 'name', 'email', 'created_at', 'active')
                        ->with('roles')
                        ->paginate($limit);

        return response($users, 200);
    }

    public function orderCustomer(Request $request)
    {
        $this->authorize('customer-index');

        $customers = Customer
                        ::where('first_name', 'LIKE', '%'.$request->search.'%')
                        ->orWhere('last_name', 'LIKE', '%'.$request->search.'%')
                        ->orWhere('phone', 'LIKE', '%'.$request->search.'%')
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
                        ->with(['Country:id,name', 'City:id,name'])
                        ->get();

        return response($customers, 200);
    }

    public function messages(Request $request)
    {
        $this->authorize('messaging-index');

        $messages = MessageTemplate::where('message', 'LIKE', '%'.$request->message.'%')
                                    ->orWhere('name', 'LIKE', '%'.$request->message.'%')
                                    ->get();

        return response($messages, 200);
    }
}
