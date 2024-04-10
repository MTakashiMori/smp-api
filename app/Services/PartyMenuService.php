<?php

namespace App\Services;

use App\Repositories\PartyMenuRepository;

class PartyMenuService extends MainService
{

    private PartyMenuProductService $partyMenuProductsService;

    public function __construct(PartyMenuRepository $repository, PartyMenuProductService $partyMenuProductsService)
    {
        $this->repository = $repository;
        $this->partyMenuProductsService = $partyMenuProductsService;
    }

    public function addProductsToPartyMenu($request)
    {
        $existingItems = $this->partyMenuProductsService
            ->findAlreadyAddedProducts($request['party_menu_id'], $request['items'])
            ->map(function ($item) {
                return $item->product_id;
            })->toArray();

        foreach ($request['items'] as $item) {

            if(in_array($item['id'], $existingItems)) {
                continue;
            }

            $price = str_replace('R$ ', '', $item['price']);
            $this->partyMenuProductsService->store([
                'party_menu_id' => $request['party_menu_id'],
                'product_id' => $item['id'],
                'price' => str_replace(',', '.', $price)
            ]);
        }
    }

}
