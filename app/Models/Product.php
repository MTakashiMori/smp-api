<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends MainModel
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;


    protected $guarded = [];

    public function type(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }
}
