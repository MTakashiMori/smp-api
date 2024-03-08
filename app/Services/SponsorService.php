<?php

namespace App\Services;

use App\Repositories\SponsorRepository;

class SponsorService extends MainService
{

    public function __construct(SponsorRepository $repository)
    {
        $this->repository = $repository;
    }

}
