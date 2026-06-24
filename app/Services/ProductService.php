<?php

namespace App\Services;

use App\Models\PartyMenu;
use App\Models\PartyMenuGroup;
use App\Repositories\ProductRepository;
use App\Support\TenantContext;

class ProductService extends MainService
{

    public function __construct(ProductRepository $repository, private TenantContext $tenantContext)
    {
        $this->repository = $repository;
    }

    public function store($data)
    {
        $this->validateMenuReferences($data);

        return parent::store($data);
    }

    public function update($data, $id)
    {
        $this->validateMenuReferences($data);

        return parent::update($data, $id);
    }

    public function findAlreadyAddedProducts($partyMenuId, $items)
    {
        PartyMenu::query()->forTenant($this->tenantContext)->findOrFail($partyMenuId);

        return $this->repository->index([
            'party_menu_id' => $partyMenuId,
            'product_id' => array_column($items,'id')
        ]);
    }

    private function validateMenuReferences(array $data): void
    {
        PartyMenu::query()->forTenant($this->tenantContext)->findOrFail($data['party_menu_id']);
        PartyMenuGroup::query()->forTenant($this->tenantContext)->findOrFail($data['party_menu_group_id']);
    }

}
