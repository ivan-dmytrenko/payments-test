<?php

namespace App\Http\Requests;

class TransactionStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_from' => 'required|alpha|exists:user_wallet,name',
            'name_to' => 'required|alpha|exists:user_wallet,name|receiverIsNotSender',
            'amount' => 'required|numeric',
            'currency_code' => 'required|min:3|max:3|availableCurrencyCodeToSend'
        ];
    }
}
