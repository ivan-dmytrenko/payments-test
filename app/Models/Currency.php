<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $primaryKey = 'code';

    protected $keyType = 'string';

    protected $table = 'currency';

    protected $fillable = ['code'];

    public function currencyUsdRate()
    {
        return $this->hasMany('App\Models\CurrencyUsdRate', 'currency_code', 'code');
    }
}
