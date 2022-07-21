<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
                'customer_id' => ['required'],
                'delivery' => ['required'],
                'delivery_service_id' => ['nullable'],
                'delivery_men_id' => ['nullable'],
                'note' => ['nullable'],
                'delivery_note' => ['nullable'],
        ];
    }
}
