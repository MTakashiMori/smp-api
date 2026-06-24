<?php

namespace App\Policies;

use App\Policies\Concerns\AuthorizesTenantResources;

class FinancialPolicy
{
    use AuthorizesTenantResources;
}
