<?php

namespace App\Http\Requests;

use App\Models\DeliveryMan;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDeliveryManRequest extends FormRequest
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
        $user = User::find($this->route('deliveryMan')->user_id);

        return [
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'name' => ['required'],
            'code' => ['required'],
            'shipping_cost' => ['required', 'numeric'],
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'User or Delivery Man with this email already exists',
        ];
    }
}
