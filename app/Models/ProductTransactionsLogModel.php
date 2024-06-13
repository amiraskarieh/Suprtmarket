<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTransactionLog extends Model
{
    protected $table = 'product_transaction_logs'; 

    protected $fillable = [
        'product_transaction_id',
        'operation_type',
        'old_value',
        'new_value',
        'user_id',
        'timestamp',
    ];
}