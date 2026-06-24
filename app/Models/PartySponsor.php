<?php

namespace App\Models;

use App\Support\TenantContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartySponsor extends MainModel
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;


    protected $guarded = [];

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

        return $query->whereIn('party_id', $partyIds);
    }
}
