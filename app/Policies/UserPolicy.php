<?php

namespace App\Policies;

use App\Models\User;
use App\Support\TenantContext;

class UserPolicy
{
    public function before(User $user): ?bool
    {
        return app(TenantContext::class)->isSuperAdmin() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return count(app(TenantContext::class)->accessiblePartyIds()) > 0;
    }

    public function view(User $user, User $targetUser): bool
    {
        return $targetUser->parties()
            ->whereIn('parties.id', app(TenantContext::class)->accessiblePartyIds())
            ->exists();
    }

    public function update(User $user, User $targetUser): bool
    {
        return $this->view($user, $targetUser);
    }

    public function delete(User $user, User $targetUser): bool
    {
        return $this->view($user, $targetUser);
    }
}
