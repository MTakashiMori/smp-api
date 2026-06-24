<?php

namespace App\Policies;

use App\Policies\Concerns\AuthorizesTenantResources;

class ProductPolicy
{
    use AuthorizesTenantResources;
}
