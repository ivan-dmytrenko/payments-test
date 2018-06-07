<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $primaryKey = 'name';

    protected $keyType = 'string';

    protected $table = 'country';

    protected $fillable = [
        'name'
    ];

    public function userWallets()
    {
        return $this->hasMany('App\Models\UserWallet', 'country_name', 'name');
    }
}
