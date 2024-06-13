<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaritalStatusLog extends Model
{
    protected $table = 'marital_status_logs'; 

    protected $fillable = [
        'marital_status_id',
        'operation_type',
        'old_value',
        'new_value',
        'user_id',
        'timestamp',
    ];
}