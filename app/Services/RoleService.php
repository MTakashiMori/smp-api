<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use App\Repositories\RoleUserRepository;

class RoleService extends MainService
{
    private RoleUserRepository $roleUsersRepository;
    public function __construct(RoleRepository $repository, RoleUserRepository $roleUserRepository)
    {
        $this->repository = $repository;
        $this->roleUsersRepository = $roleUserRepository;
    }

    public function getUsersWithRole($request)
    {
        return $this->repository->findById(
            ['id' => $request['role_id']],
            ['users']
        );
    }

    public function attachUsersToRole($request): void
    {
        foreach ($request['users'] as $user) {
            $this->roleUsersRepository->store([
                'role_id' => $request['role_id'],
                'user_id' => $user['id']
            ]);
        }
    }
}
