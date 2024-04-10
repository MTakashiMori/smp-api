<?php

namespace App\Services;

use App\Repositories\PartyRepository;

class PartyService extends MainService
{

    private PartyMenuService $partyMenuService;

    private FinancialService $financialService;

    public function __construct(
        PartyRepository $repository,
        PartyMenuService $partyMenuService,
        FinancialService $financialService
    )
    {
        $this->repository = $repository;
        $this->partyMenuService = $partyMenuService;
        $this->financialService = $financialService;
    }

    public function store($data)
    {
        $data = parent::store($data);

        $this->partyMenuService->store(['party_id' => $data->id]);
        $this->financialService->store(['party_id' => $data->id]);

        return $data;
    }


}
