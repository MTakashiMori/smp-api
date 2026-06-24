<?php

namespace App\Policies;

use App\Policies\Concerns\AuthorizesTenantResources;

class RolePolicy
{
    use AuthorizesTenantResources;
}
