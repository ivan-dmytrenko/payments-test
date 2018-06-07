<?php

namespace App\Http\Requests;

class UpdateUserWallet extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|alpha|exists:user_wallet,name',
            'amount' => 'required|min:1|numeric'
        ];
    }
}
