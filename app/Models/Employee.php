<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'marital_status_id',
        'job_type_id',

    ];


    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function job_type(): HasOne
    {
        return $this->hasOne(JobType::class);
    }

    public function marital_status(): HasOne
    {
        return $this->hasOne(MaritalStatus::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
