<?php

namespace App\Policies\Concerns;

use App\Models\FinancialCategories;
use App\Models\Party;
use App\Models\PartyMenuGroup;
use App\Models\Products;
use App\Models\Transactions;
use App\Models\User;
use App\Support\TenantContext;
use Illuminate\Database\Eloquent\Model;

trait AuthorizesTenantResources
{
    public function before(User $user): ?bool
    {
        return app(TenantContext::class)->isSuperAdmin() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $this->hasTenantAccess();
    }

    public function view(User $user, Model $model): bool
    {
        return $this->resourceBelongsToAllowedParty($model);
    }

    public function create(User $user): bool
    {
        return $this->hasTenantAccess();
    }

    public function update(User $user, Model $model): bool
    {
        return $this->resourceBelongsToAllowedParty($model);
    }

    public function delete(User $user, Model $model): bool
    {
        return $this->resourceBelongsToAllowedParty($model);
    }

    private function hasTenantAccess(): bool
    {
        $tenantContext = app(TenantContext::class);

        return (bool) ($tenantContext->partyId() || count($tenantContext->accessiblePartyIds()));
    }

    private function resourceBelongsToAllowedParty(Model $model): bool
    {
        $tenantContext = app(TenantContext::class);
        $partyId = $this->resourcePartyId($model);

        if (!$partyId) {
            return false;
        }

        if ($tenantContext->partyId()) {
            return $tenantContext->partyId() === $partyId;
        }

        return in_array($partyId, $tenantContext->accessiblePartyIds(), true);
    }

    private function resourcePartyId(Model $model): ?string
    {
        if ($model instanceof Party) {
            return $model->id;
        }

        if ($model->getAttribute('party_id')) {
            return $model->getAttribute('party_id');
        }

        if ($model instanceof Transactions || $model instanceof FinancialCategories) {
            return $model->financial?->party_id;
        }

        if ($model instanceof Products || $model instanceof PartyMenuGroup) {
            return $model->menu?->party_id;
        }

        return null;
    }
}
