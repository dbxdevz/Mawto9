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

        $limit        = request('limit') ? request('limit') : 10;
        $searchString = $request->country;
        $name         = strtolower($request->name);


        $customers = Customer::whereRaw('LOWER(first_name) LIKE', '%' . $name . '%')
                             ->orWhereRaw('LOWER(last_name) LIKE', '%' . $name . '%')
                             ->orWhere('phone', 'LIKE', '%' . $request->phone . '%')
                             ->whereHas('Country', function ($query) use ($searchString) {
                                 return $query->where('name', 'LIKE', '%' . $searchString . '%');
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
                             ->with(['Country' => function ($query) use ($searchString) {
                                 $query
                                     ->where('name', 'like', '%' . $searchString . '%')
                                     ->select('id', 'name')
                                 ;
                             }, 'City:id,name'])
                             ->paginate($limit)
        ;

        return response($customers, 200);
    }

    public function products(Request $request)
    {
        $name = strtolower($request->name);

        $products = Product::whereRaw('LOWER(name) LIKE', '%' . $name . '%')
                           ->where('available', false)
                           ->select('id', 'name', 'selling_price', 'color')
                           ->get()
        ;

        return response($products, 200);
    }

    public function users(Request $request)
    {
        $this->authorize('user-index');

        $limit = request('limit') ? request('limit') : 10;

        $role_id = $request->role;
        $name    = strtolower($request->name);
        $email   = strtolower($request->email);

        $users = User::whereRaw('LOWER(name) LIKE (?)', ["%{$name}%"])
                     ->whereRaw('LOWER(email) LIKE', ["%{$email}%"])
                     ->whereHas('roles', function ($query) use ($role_id) {
                         return $query->where('roles.id', $role_id);
                     })
                     ->select('id', 'name', 'email', 'created_at', 'active', 'role_id')
                     ->with('roles')
                     ->paginate($limit)
        ;

        return response($users, 200);
    }

    public function orderCustomer(Request $request)
    {
        $this->authorize('customer-index');

        $customers = Customer::where('LOWER(first_name)', 'LIKE', '%' . strtolower($request->search) . '%')
                             ->orWhere('LOWER(last_name)', 'LIKE', '%' . strtolower($request->search) . '%')
                             ->orWhere('LOWER(phone)', 'LIKE', '%' . ($request->search) . '%')
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
                             ->get()
        ;

        return response($customers, 200);
    }

    public function messages(Request $request)
    {
        $this->authorize('messaging-index');

        $messages = MessageTemplate::where('LOWER(message)', 'LIKE', '%' . strtolower($request->message) . '%')
                                   ->orWhere('LOWER(name)', 'LIKE', '%' . strtolower($request->message) . '%')
                                   ->get()
        ;

        return response($messages, 200);
    }
}
