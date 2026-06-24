<?php

namespace App\Policies;

use App\Policies\Concerns\AuthorizesTenantResources;

class SponsorPolicy
{
    use AuthorizesTenantResources;
}
