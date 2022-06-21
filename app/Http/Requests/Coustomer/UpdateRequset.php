<?php

namespace App\Http\Requests\Coustomer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateRequset extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::authorize('customer-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $customer = $this->route('customer');

        return [
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'phone' => ['required', Rule::unique('customers', 'phone')->ignore($customer->id)],
            'email' => ['email', Rule::unique('customers', 'email')->ignore($customer->id)],
            'city_id' => ['required'],
            'country_id' => ['required'],
            'whatsapp' => ['nullable'],
        ];
    }
}
