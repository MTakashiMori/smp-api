<?php

namespace App\Models;

use App\Support\TenantContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserParty extends MainModel
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    public $appends = [
        'party_name',
        'current_menu'
    ];

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function party(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }

    public function getPartyNameAttribute(): string
    {
        return $this->party()->first()->name;
    }

    public function getCurrentMenuAttribute()
    {
        return $this->party()->with('currentPartyMenu')->first()->currentPartyMenu?->id;
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

        return $query->whereIn('party_id', $partyIds);
    }

}
