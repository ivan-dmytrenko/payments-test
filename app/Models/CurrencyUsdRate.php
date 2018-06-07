<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyUsdRate extends Model
{
    protected $table = 'currency_usd_rate';

    protected $fillable = ['rate', 'date'];

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_code');
    }
}
