<?php

namespace App\Policies;

use App\Policies\Concerns\AuthorizesTenantResources;

class PartyMenuPolicy
{
    use AuthorizesTenantResources;
}
