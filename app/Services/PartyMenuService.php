<?php

namespace App\Services;

use App\Repositories\PartyMenuRepository;

class PartyMenuService extends MainService
{

    private ProductService $partyMenuProductsService;

    private PartyMenuGroupService $partyMenuGroupService;

    public function __construct(
        PartyMenuRepository $repository,
        ProductService $partyMenuProductsService,
        PartyMenuGroupService $partyMenuGroupService)
    {
        $this->repository = $repository;
        $this->partyMenuProductsService = $partyMenuProductsService;
        $this->partyMenuGroupService = $partyMenuGroupService;
    }

    public function store($data): void
    {
        $this->disableActiveMenusByPartyId($data['party_id']);

        parent::store($data);
    }

    private function disableActiveMenusByPartyId($partyId): void
    {
        $this->repository->index(['party_id' => $partyId])->each(function ($item) {
            return $this->repository->update($item->id, ['active' => 0]);
        });
    }

    public function addProductsToPartyMenu($request): void
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

    public function getProductList($request)
    {
        $partyMenu = $this->repository->findById(['id' => $request['party_menu_id']]);

        return [
            'products' => $this->partyMenuProductsService->index(['party_menu_id' => $request['party_menu_id']]),
            'product_groups' => $this->partyMenuGroupService->index(['party_menu_id' => $request['party_menu_id']]),
            'party_name' => $partyMenu->party_name,
            'menu_label' => $partyMenu->label,
        ];
    }

}
