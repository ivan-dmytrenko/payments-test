<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $primaryKey = 'name';

    protected $keyType = 'string';

    protected $table = 'city';

    protected $fillable = [
        'name'
    ];

    public function userWallets()
    {
        return $this->hasMany('App\Models\UserWallet', 'city_name', 'name');
    }
}
