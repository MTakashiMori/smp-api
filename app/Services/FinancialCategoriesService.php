<?php

namespace App\Services;

use App\Models\Financial;
use App\Repositories\FinancialCategoriesRepository;
use App\Support\TenantContext;

class FinancialCategoriesService extends MainService
{

    public function __construct(FinancialCategoriesRepository $repository, private TenantContext $tenantContext)
    {
        $this->repository = $repository;
    }

    public function store($data)
    {
        $this->validateFinancial($data['financial_id']);

        return parent::store($data);
    }

    public function update($data, $id)
    {
        $this->validateFinancial($data['financial_id']);

        return parent::update($data, $id);
    }

    private function validateFinancial(string $financialId): void
    {
        Financial::query()->forTenant($this->tenantContext)->findOrFail($financialId);
    }

}
