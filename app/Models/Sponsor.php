<?php

namespace App\Models;

use App\Support\TenantContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Sponsor extends MainModel
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    public function sponsoredParties(): HasManyThrough
    {
        return $this->hasManyThrough(Party::class, PartySponsor::class, 'sponsor_id', 'id', 'id', 'party_id');
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

        return $query->whereHas('sponsoredParties', function (Builder $query) use ($partyIds) {
            $query->whereIn('parties.id', $partyIds);
        });
    }
}
