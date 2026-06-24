<?php

namespace App\Models;

use App\Support\TenantContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        return $this->belongsTo(Products::class);
    }

    public function categories():BelongsTo
    {
        return $this->belongsTo(FinancialCategories::class, 'financial_categories_id');
    }

    public function scopeForTenant(Builder $query, TenantContext $tenantContext): Builder
    {
        if (!$tenantContext->user()) {
            return $query;
        }

        if ($tenantContext->isSuperAdmin()) {
            return $query;
        }

        $partyIds = $tenantContext->partyId()
            ? [$tenantContext->partyId()]
            : $tenantContext->accessiblePartyIds();

        return $query->whereHas('financial', function (Builder $query) use ($partyIds) {
            $query->whereIn('party_id', $partyIds);
        });
    }
}
