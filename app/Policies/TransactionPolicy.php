<?php

namespace App\Policies;

use App\Policies\Concerns\AuthorizesTenantResources;

class TransactionPolicy
{
    use AuthorizesTenantResources;
}
