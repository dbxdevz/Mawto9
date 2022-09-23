<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeliveryManRequest;
use App\Http\Requests\ToggleDefaultDeliveryManRequest;
use App\Http\Requests\UpdateDeliveryManRequest;
use App\Models\DeliveryMan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DeliveryManController extends Controller
{
    public function index()
    {
        $deliveryMen = User::whereHas('deliveryInfo')
                           ->get()
        ;

        return response([
                            'message' => 'List of Delivery Men',
                            'data'    => $deliveryMen->load('deliveryInfo'),
                        ], 200);
    }

    public function store(StoreDeliveryManRequest $request)
    {
        $user = User::create([
                                 'name'     => $request->get('name'),
                                 'email'    => $request->get('email'),
                                 'password' => Hash::make($request->get('password')),
                             ]);

        $user->roles()
             ->attach(
                 Role::where('name', '=', 'Courier')
                     ->first()
             )
        ;

        DeliveryMan::create([
                                'user_id'       => $user->id,
                                'code'          => $request->get('code'),
                                'shipping_cost' => $request->get('shipping_cost'),
                                'default'       => false,
                            ]);

        return response([
                            'message' => 'Delivery Man created successfully',
                            'data'    => $user->load('deliveryInfo'),
                        ], 200);
    }

    public function show(DeliveryMan $deliveryMan)
    {
        $deliveryMan = User::find($deliveryMan->user_id)
                           ->load('deliveryInfo')
        ;

        return response([
                            'message' => 'Delivery Man info',
                            'data'    => $deliveryMan,
                        ], 200);
    }

    public function update(UpdateDeliveryManRequest $request, DeliveryMan $deliveryMan)
    {
        $deliveryMan->update([
                                 'code'          => $request->get('code'),
                                 'shipping_cost' => $request->get('shipping_cost'),
                             ]);

        $user = User::find($deliveryMan->user_id);

        $user->update([
                          'email'  => $request->get('email'),
                          'name'   => $request->get('name'),
                          'active' => $request->get('active'),
                      ]);

        return response([
                            'message' => 'Delivery Man updated successfully',
                            'data'    => $user->load('deliveryInfo'),
                        ], 200);
    }

    public function toggleDefault(ToggleDefaultDeliveryManRequest $request, $id)
    {
        if ($request->get('default')) {
            DB::table('delivery_men')
              ->update(['default' => false])
            ;
        }

        $deliveryMan = DeliveryMan::where('user_id', $id)
                                  ->first()
        ;

        $deliveryMan->update(['default' => $request->get('default')]);

        return response([
                            'message' => 'Default toggled successfully',
                        ], 200);
    }
}
