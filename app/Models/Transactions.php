<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transactions extends MainModel
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;


    protected $guarded = [];

    public function financial(): BelongsTo
    {
        return $this->belongsTo(Financial::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(TransactionsType::class);
    }

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function categories():BelongsTo
    {
        return $this->belongsTo(FinancialCategories::class, 'financial_categories_id');
    }
}
