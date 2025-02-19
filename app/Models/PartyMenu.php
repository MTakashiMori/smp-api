<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PartyMenu extends MainModel
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected $appends = ['products'];

    public function party(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(PartyMenuProducts::class)->with('product');
    }

    public function getProductsAttribute()
    {
        return $this->products()->get()->map(function ($item) {
            $item->product->price = number_format($item->price, 2, '.', '');
            return $item->product;
        });
    }

}
