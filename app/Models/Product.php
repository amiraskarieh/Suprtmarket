<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'perishable_data',
        'is_perishable',
        'production_date',
        'sell_number',
        'buy_price',
        'supplier_id',
        'image',
    ];

    public function product_transactions(): HasMany
    {
        return $this->hasMany(ProductTransactions::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
