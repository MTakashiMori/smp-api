<?php

namespace App\Policies;

use App\Policies\Concerns\AuthorizesTenantResources;

class PartyPolicy
{
    use AuthorizesTenantResources;
}
