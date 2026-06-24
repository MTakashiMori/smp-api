<?php

namespace App\Support;

use App\Constants\Acl;
use App\Models\Party;
use App\Models\User;
use Illuminate\Http\Request;

class TenantContext
{
    private ?User $user = null;

    private ?string $partyId = null;

    private ?Party $party = null;

    public function initialize(Request $request): void
    {
        /** @var User|null $user */
        $user = $request->user() ?: auth()->user();

        $this->user = $user;
        $this->partyId = null;
        $this->party = null;

        if (!$user) {
            return;
        }

        $partyId = $this->resolvePartyId($request);

        if (!$partyId) {
            return;
        }

        $party = Party::query()->find($partyId);

        if (!$party) {
            abort(response()->json(['message' => 'Party not found'], 404));
        }

        if (!$this->isSuperAdmin() && !$user->parties()->where('parties.id', $party->id)->exists()) {
            abort(response()->json(['message' => 'Not authorized for this party'], 403));
        }

        $this->partyId = $party->id;
        $this->party = $party;
    }

    public function user(): ?User
    {
        return $this->user;
    }

    public function partyId(): ?string
    {
        return $this->partyId;
    }

    public function party(): ?Party
    {
        return $this->party;
    }

    public function isSuperAdmin(): bool
    {
        return $this->user?->hasRole(Acl::ROLE_SUPER_ADMIN) ?? false;
    }

    public function accessiblePartyIds(): array
    {
        if (!$this->user) {
            return [];
        }

        if ($this->isSuperAdmin()) {
            return Party::query()->pluck('id')->toArray();
        }

        return $this->user->parties()->pluck('parties.id')->toArray();
    }

    public function resolvePartyId(Request $request): ?string
    {
        $routeParty = $request->route('party');

        if (is_object($routeParty) && isset($routeParty->id)) {
            return $routeParty->id;
        }

        return $request->header('X-Party-Id')
            ?: (is_string($routeParty) ? $routeParty : null);
    }
}
