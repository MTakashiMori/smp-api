<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService extends MainService
{

    public function __construct(ProductRepository $repository)
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
