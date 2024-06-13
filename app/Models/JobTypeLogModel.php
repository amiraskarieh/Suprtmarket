<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobTypeLog extends Model
{
    protected $table = 'job_type_logs'; 

    protected $fillable = [
        'job_type_id',
        'operation_type',
        'old_value',
        'new_value',
        'user_id',
        'timestamp',
    ];
}