<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::authorize('order-store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'order_status_id' => ['required'],
            'package_status_id' => ['required'],
            'delivery_service_id' => ['nullable'],
            'delivery_men_id' => ['nullable'],
            'customer_id' => ['required'],
            'note' => ['nullable'],
            'delivery_note' => ['nullable'],
            'products' => ['required'],
            'subtotal' => ['nullable'],
            'shipping_cost' => ['nullable'],
            'total' => ['required'],
            'service' => ['required', 'boolean'], // 0 -> delivery men, 1 -> delivery service
        ];
    }
}
