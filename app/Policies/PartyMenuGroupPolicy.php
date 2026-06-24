<?php

namespace App\Policies;

use App\Policies\Concerns\AuthorizesTenantResources;

class PartyMenuGroupPolicy
{
    use AuthorizesTenantResources;
}
