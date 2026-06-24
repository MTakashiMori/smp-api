<?php

namespace App\Models;

use App\Support\TenantContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends MainModel
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    public $guarded = [];

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_roles', 'role_id', 'permission_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users', 'role_id', 'user_id')->withPivot('party_id');
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

        return $query->where(function (Builder $query) use ($partyIds) {
            $query->whereIn('party_id', $partyIds)
                ->orWhereNull('party_id');
        });
    }
}
