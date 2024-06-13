<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLog extends Model
{
    protected $table = 'product_logs'; 

    protected $fillable = [
        'product_id',
        'operation_type',
        'old_value',
        'new_value',
        'user_id',
        'timestamp',
    ];
}