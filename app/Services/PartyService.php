<?php

namespace App\Services;

use App\Repositories\PartyRepository;

class PartyService extends MainService
{

    private PartyMenuService $partyMenuService;

    private FinancialService $financialService;

    private FinancialCategoriesService $financialCategoriesService;

    public function __construct(
        PartyRepository $repository,
        PartyMenuService $partyMenuService,
        FinancialService $financialService,
        FinancialCategoriesService $financialCategoriesService
    )
    {
        $this->repository = $repository;
        $this->partyMenuService = $partyMenuService;
        $this->financialService = $financialService;
        $this->financialCategoriesService = $financialCategoriesService;
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


}
