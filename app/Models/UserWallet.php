<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    protected $primaryKey = 'name';

    protected $keyType = 'string';

    protected $table = 'user_wallet';

    protected $fillable = ['name'];

    protected $appends = ['totalTransactionsAmount', 'totalUsdTransactionsAmount'];

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_name');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_name');
    }

    public function currencyCode()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_code');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction', 'owner', 'name');
    }
}
