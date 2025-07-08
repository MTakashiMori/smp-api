<?php

namespace App\Repositories;

use App\Models\Sponsor;

class SponsorRepository extends MainRepository
{

    public function __construct(Sponsor $model)
    {
        $this->model = $model;
        $this->relationship = [
            'sponsoredParties'
        ];
    }
}
