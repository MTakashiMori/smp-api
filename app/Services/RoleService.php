<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\Role;
use App\Repositories\RoleRepository;
use App\Repositories\RoleUserRepository;
use Illuminate\Database\Eloquent\Collection;

class RoleService extends MainService
{
    private RoleUserRepository $roleUsersRepository;
    public function __construct(RoleRepository $repository, RoleUserRepository $roleUserRepository)
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

        $role = Role::findOrFail($id);
        $role->update($data);

        if (is_array($permissions)) {
            $this->syncPermissions($role, $permissions);
        }

        return $role->load(['permissions', 'party']);
    }

    public function getUsersWithRole($request)
    {
        $role = Role::with(['permissions'])->findOrFail($request['role_id']);

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
        $role = Role::findOrFail($request['role_id']);
        $partyId = $request['party_id'] ?? $role->party_id;

        foreach ($request['users'] as $user) {
            $userId = is_array($user) ? $user['id'] : $user;
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
}
