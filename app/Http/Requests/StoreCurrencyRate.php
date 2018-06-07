<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class StoreCurrencyRate extends FormRequest
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
            'currency_code' => 'required|alpha|min:3|max:3|unique:currency_usd_rate,currency_code,NULL,id,date,'
                .request()->get('date', ''),
            'rate' => 'required|regex:/^\d*(\.\d{1,2})?$/',
            'date' => 'required|date_format:"Y-m-d'
        ];
    }
}
