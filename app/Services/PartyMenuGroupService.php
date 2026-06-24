<?php

namespace App\Services;

use App\Models\PartyMenu;
use App\Repositories\PartyMenuGroupRepository;
use App\Support\TenantContext;

class PartyMenuGroupService extends MainService
{

    public function __construct(PartyMenuGroupRepository $repository, private TenantContext $tenantContext)
    {
        $this->repository = $repository;
    }

    public function store($data)
    {
        $this->validatePartyMenu($data['party_menu_id']);

        return parent::store($data);
    }

    public function update($data, $id)
    {
        $this->validatePartyMenu($data['party_menu_id']);

        return parent::update($data, $id);
    }

    private function validatePartyMenu(string $partyMenuId): void
    {
        PartyMenu::query()->forTenant($this->tenantContext)->findOrFail($partyMenuId);
    }

}
