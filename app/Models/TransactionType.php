<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    protected $primaryKey = 'code';

    protected $keyType = 'string';

    protected $table = 'transaction_type';

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction', 'type_code', 'code');
    }
}
