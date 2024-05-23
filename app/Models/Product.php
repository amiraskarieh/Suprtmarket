<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sell_price',
        'discount',
        'available',
        'description',
        'production_date',
        'is_perishable',
        'perishable_data',
        'sell_number',
        'buy_price',
    ];

    public function suplieds(): HasMany
    {
        return $this->hasMany(Supplied::class);
    }

    public function product_transactions(): HasMany
    {
        return $this->hasMany(ProductTransactions::class);
    }
}
