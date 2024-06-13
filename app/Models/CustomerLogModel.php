<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerLog extends Model
{
    protected $table = 'customer_logs'; 

    protected $fillable = [
        'customer_id',
        'operation_type',
        'old_value',
        'new_value',
        'user_id',
        'timestamp',
    ];


}