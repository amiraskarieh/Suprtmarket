<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'email',
        'phone',
    ];


    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function suplieds(): HasMany
    {
        return $this->hasMany(Supplied::class);
    }
}
