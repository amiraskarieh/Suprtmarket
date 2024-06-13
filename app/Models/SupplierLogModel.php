<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierLog extends Model
{
    protected $table = 'supplier_logs'; 

    protected $fillable = [
        'supplier_id',
        'operation_type',
        'old_value',
        'new_value',
        'user_id',
        'timestamp',
    ];
}