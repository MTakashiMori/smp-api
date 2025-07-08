<?php

namespace App\Services;

use App\Repositories\SponsorRepository;

class SponsorService extends MainService
{

    private PartyService $partyService;

    public function __construct(SponsorRepository $repository, PartyService $partyService)
    {
        $this->repository = $repository;
        $this->partyService = $partyService;
    }

    public function getFilterData()
    {
        $parties = $this->partyService->index()->map(function ($party) {
            return [
                'id' => $party->id,
                'name' => $party->name,
            ];
        });

        return [
            'parties' => $parties,
        ];
    }

}
