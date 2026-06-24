<?php

namespace App\Policies;

use App\Policies\Concerns\AuthorizesTenantResources;

class FinancialCategoryPolicy
{
    use AuthorizesTenantResources;
}
