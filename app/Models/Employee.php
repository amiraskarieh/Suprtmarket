<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'age',
        'phone',
        'salary',
        'employment_date',
        'address',
        'marital_status',
        'job_type',
    ];


    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
