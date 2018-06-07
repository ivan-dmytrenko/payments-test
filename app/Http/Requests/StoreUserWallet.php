<?php

namespace App\Http\Requests;

class StoreUserWallet extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|alpha|unique:user_wallet,name',
            'currency_code' => 'required|exists:currency,code',
            'country' => 'required|alpha',
            'city' => 'required|alpha'
        ];
    }
}
