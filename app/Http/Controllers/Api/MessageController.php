<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexMessageRequest;
use App\Http\Requests\SendMessageRequest;
use App\Models\MessageTemplate;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MessageController extends Controller
{
    public function index(IndexMessageRequest $request, Order $order)
    {
        $messageTemplates = MessageTemplate::where('type', $request->get('type'))
            ->without(['orderStatuses', 'deliveryServices'])
            ->get();

        $messageTemplates->each(function ($messageTemplate) use ($order) {
            $messageTemplate->message = str($messageTemplate->message)->replace('$id', $order->id);
            $messageTemplate->message = str($messageTemplate->message)->replace('$name', $order->customer->full_name);
            $messageTemplate->message = str($messageTemplate->message)->replace('$product', 'Some product');
            $messageTemplate->message = str($messageTemplate->message)->replace('$total', 'Some total');
            $messageTemplate->message = str($messageTemplate->message)->replace('$code', 'Some tracker code');
        });

        return response([
            'message' => "List of {$request->get('type')} Messages",
            'data' => $messageTemplates,
        ]);
    }

    public function send(SendMessageRequest $request)
    {
        if ($request->get('type') == 'SMS') {
            $response = Http::get('https://api.smsglobal.com/http-api.php', [
                'action' => 'sendsms',
                'user' => config('services.smsglobal.user'),
                'password' => config('services.smsglobal.password'),
                'from' => config('services.smsglobal.from'),
                'to' => $request->get('to'),
                'text' => $request->get('text'),
            ]);

            if ($response->status() != 200) {
                return response([
                    'message' => 'Something went wrong',
                ], 500);
            }

            return response([
                'message' => 'Sms sent successfully',
            ], 200);
        }
    }
}
