<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';

    protected $fillable = [
        'amount',
        'amount_usd',
        'type_code',
        'owner'
    ];

    public function typeCode()
    {
        return $this->belongsTo('App\Models\TransactionType', 'type_code');
    }

    public function ownerName()
    {
        return $this->belongsTo('App\Models\UserWallet', 'owner');
    }
}