<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageTemplateRequest;
use App\Http\Requests\UpdateMessageTemplateRequest;
use App\Models\MessageTemplate;
use Illuminate\Http\Request;

class MessageTemplateController extends Controller
{
    public function index()
    {
        $messageTemplates = MessageTemplate::all();

        return response([
            'message' => 'List of Message Templates',
            'data' => $messageTemplates,
        ], 200);
    }

    public function store(StoreMessageTemplateRequest $request)
    {
        $messageTemplate = MessageTemplate::create([
            'type' => $request->get('type'),
            'name' => $request->get('name'),
            'message' => $request->get('message'),
        ]);

        $messageTemplate->orderStatuses()->attach($request->get('order_statuses'));
        $messageTemplate->deliveryServices()->attach($request->get('delivery_services'));

        return response([
            'message' => 'Message Template created successfully',
            'data' => $messageTemplate,
        ]);
    }

    public function update(UpdateMessageTemplateRequest $request, MessageTemplate $messageTemplate)
    {
        $messageTemplate->update([
            'type' => $request->get('type'),
            'name' => $request->get('name'),
            'message' => $request->get('message'),
        ]);

        $messageTemplate->orderStatuses()->detach();
        $messageTemplate->orderStatuses()->attach($request->get('order_statuses'));

        $messageTemplate->deliveryServices()->detach();
        $messageTemplate->deliveryServices()->attach($request->get('delivery_services'));

        return response([
            'message' => 'Message Template updated successfully',
            'data' => $messageTemplate,
        ]);
    }

    public function destroy(MessageTemplate $messageTemplate)
    {
        $messageTemplate->delete();

        return response([
            'message' => 'Message Template deleted successfully',
        ]);
    }
}
