<?php

namespace App\Services;

use App\Repositories\UsersPartyRepository;

class UserPartyService extends MainService
{

    public function __construct(UsersPartyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function checkUserAlreadyAssociated($userId, $partyId): bool
    {
        return $this->repository->index(['user_id' => $userId, 'party_id' => $partyId])->isNotEmpty();
    }

}
