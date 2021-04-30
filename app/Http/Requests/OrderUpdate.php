<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdate extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'client_email'  => 'required|email',
            'status'        => 'required|numeric|min:0',
            'partner_id'    => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Поле :attribute необходимо обязательно заполнить'
        ];
    }

    public function attributes()
    {
        return [
            'client_email' => 'Почту клиента'
        ];
    }
}
