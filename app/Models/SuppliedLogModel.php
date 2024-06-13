<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuppliedLog extends Model
{
    protected $table = 'supplied_logs'; 

    protected $fillable = [
        'supplied_id',
        'operation_type',
        'old_value',
        'new_value',
        'user_id',
        'timestamp',
    ];
}