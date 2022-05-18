<?php

namespace App\Http\Requests\Coustomer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequset extends FormRequest
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
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'phone' => ['required'],
            'email' => ['email'],
            'city_id' => ['required'],
            'country_id' => ['required'],
        ];
    }
}
