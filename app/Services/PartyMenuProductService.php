<?php

namespace App\Services;

use App\Repositories\PartyMenuProductRepository;

class PartyMenuProductService extends MainService
{

    public function __construct(PartyMenuProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findAlreadyAddedProducts($partyMenuId, $items)
    {
        return $this->repository->index([
            'party_menu_id' => $partyMenuId,
            'product_id' => array_column($items,'id')
        ]);
    }

}
