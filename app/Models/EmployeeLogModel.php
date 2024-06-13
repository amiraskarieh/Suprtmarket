<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeLog extends Model
{
    protected $table = 'employee_logs'; 

    protected $fillable = [
        'employee_id',
        'operation_type',
        'old_value',
        'new_value',
        'user_id',
        'timestamp',
    ];

}