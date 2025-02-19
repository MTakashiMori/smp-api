<?php

namespace App\Services;

use App\Repositories\PartyRepository;
use Illuminate\Database\Eloquent\Collection;

class PartyService extends MainService
{

    private PartyMenuService $partyMenuService;

    private FinancialService $financialService;

    private FinancialCategoriesService $financialCategoriesService;

    private UserPartyService $userPartyService;

    public function __construct(
        PartyRepository $repository,
        PartyMenuService $partyMenuService,
        FinancialService $financialService,
        FinancialCategoriesService $financialCategoriesService,
        UserPartyService $userPartyService
    )
    {
        $this->repository = $repository;
        $this->partyMenuService = $partyMenuService;
        $this->financialService = $financialService;
        $this->financialCategoriesService = $financialCategoriesService;
        $this->userPartyService = $userPartyService;
    }

    public function store($data)
    {
        $data = parent::store($data);

        $this->partyMenuService->store(['party_id' => $data->id]);
        $financial = $this->financialService->store(['party_id' => $data->id]);
        $this->financialCategoriesService->store([
            'financial_id' => $financial->id,
            'name' => 'Geral'
        ]);

        return $data;
    }

    public function assignUsersToParty($request): void
    {
        foreach ($request['users'] as $userId) {
            $this->userPartyService->store([
                'user_id' => $userId,
                'party_id' => $request['party_id']
            ]);
        }
    }

    public function getRelatedPartiesByUserId($request): Collection
    {
        return $this->userPartyService->index([
            'user_id' => $request['user_id']
        ]);
    }


}
