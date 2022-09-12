<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateDeliveryServiceRequest;
use App\Models\DeliveryService;

class DeliveryServiceController extends Controller
{
    public function index()
    {
        $limit           = request('limit') ? request('limit') : 10;
        $deliveryService = DeliveryService::paginate($limit);

        return response([
                            'message' => 'List of Delivery Services',
                            'data'    => $deliveryService,
                        ], 200);
    }

    public function show(DeliveryService $deliveryService)
    {
        return response([
                            'message' => 'Delivery Service',
                            'data'    => $deliveryService,
                        ], 200);
    }

    public function update(UpdateDeliveryServiceRequest $request, DeliveryService $deliveryService)
    {
        $deliveryService->update($request->validated());

        return response([
                            'message' => 'Delivery Service updated successfully',
                            'data'    => $deliveryService,
                        ], 200);
    }

    public function destroy(DeliveryService $deliveryService)
    {
        $deliveryService->delete();

        return response([
                            'message' => 'Delivery Service deleted successfully',
                        ], 200);
    }
}
