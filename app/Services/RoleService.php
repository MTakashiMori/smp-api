<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\Role;
use App\Models\UserParty;
use App\Repositories\RoleRepository;
use App\Repositories\RoleUserRepository;
use App\Support\TenantContext;
use Illuminate\Database\Eloquent\Collection;

class RoleService extends MainService
{
    private RoleUserRepository $roleUsersRepository;
    public function __construct(
        RoleRepository $repository,
        RoleUserRepository $roleUserRepository,
        private TenantContext $tenantContext
    )
    {
        $this->repository = $repository;
        $this->roleUsersRepository = $roleUserRepository;
    }

    public function index($data = null): Collection
    {
        return $this->repository->index($data, ['permissions', 'party']);
    }

    public function store($data)
    {
        $data['party_id'] = $this->validatedPartyId($data['party_id'] ?? null);
        $permissions = $data['permissions'] ?? $data['permission_ids'] ?? [];
        unset($data['permissions'], $data['permission_ids']);

        $role = $this->repository->store($data);
        $this->syncPermissions($role, $permissions);

        return $role->load(['permissions', 'party']);
    }

    public function update($data, $id)
    {
        $permissions = $data['permissions'] ?? $data['permission_ids'] ?? null;
        unset($data['permissions'], $data['permission_ids']);

        $role = Role::query()->forTenant($this->tenantContext)->findOrFail($id);
        $data['party_id'] = $this->validatedPartyId($data['party_id'] ?? $role->party_id);
        $role->update($data);

        if (is_array($permissions)) {
            $this->syncPermissions($role, $permissions);
        }

        return $role->load(['permissions', 'party']);
    }

    public function getUsersWithRole($request)
    {
        $role = Role::query()->forTenant($this->tenantContext)->with(['permissions'])->findOrFail($request['role_id']);

        $role->load(['users' => function ($query) use ($request, $role) {
            $partyId = $request['party_id'] ?? $role->party_id;

            if ($partyId) {
                $query->where('role_users.party_id', $partyId);
            }
        }]);

        return $role;
    }

    public function attachUsersToRole($request): void
    {
        $role = Role::query()->forTenant($this->tenantContext)->findOrFail($request['role_id']);
        $partyId = $this->validatedPartyId($request['party_id'] ?? $role->party_id);

        if ($role->party_id && $role->party_id !== $partyId) {
            throw new \Exception('Role does not belong to the selected party', 403);
        }

        foreach ($request['users'] as $user) {
            $userId = is_array($user) ? $user['id'] : $user;
            $this->ensureUserBelongsToParty($userId, $partyId);
            $existingRoleUser = $this->roleUsersRepository->index([
                'role_id' => $role->id,
                'user_id' => $userId,
                'party_id' => $partyId,
            ]);

            if ($existingRoleUser->isNotEmpty()) {
                continue;
            }

            $this->roleUsersRepository->store([
                'role_id' => $role->id,
                'user_id' => $userId,
                'party_id' => $partyId,
            ]);
        }
    }

    private function syncPermissions(Role $role, array $permissions): void
    {
        $values = collect($permissions)->map(function ($permission) {
            return is_array($permission) ? ($permission['id'] ?? $permission['name'] ?? null) : $permission;
        })->filter()->values();

        $permissionIds = Permission::whereIn('id', $values)
            ->orWhereIn('name', $values)
            ->pluck('id')
            ->toArray();

        $role->permissions()->sync($permissionIds);
    }

    private function validatedPartyId(?string $partyId): string
    {
        $currentPartyId = $this->tenantContext->partyId();

        if (!$this->tenantContext->isSuperAdmin() && !$currentPartyId) {
            throw new \Exception('A selected party is required', 403);
        }

        $partyId = $partyId ?: $currentPartyId;

        if (!$partyId) {
            throw new \Exception('A selected party is required', 422);
        }

        if (!$this->tenantContext->isSuperAdmin() && $partyId !== $currentPartyId) {
            throw new \Exception('Role must belong to the selected party', 403);
        }

        return $partyId;
    }

    private function ensureUserBelongsToParty(string $userId, string $partyId): void
    {
        if (!UserParty::query()
            ->forTenant($this->tenantContext)
            ->where('user_id', $userId)
            ->where('party_id', $partyId)
            ->exists()
        ) {
            throw new \Exception('User must be associated with the selected party before receiving a role', 422);
        }
    }
}
