<?php

namespace App\Providers;

use App\Constants\Acl;
use App\Models\Financial;
use App\Models\FinancialCategories;
use App\Models\Party;
use App\Models\PartyMenu;
use App\Models\PartyMenuGroup;
use App\Models\Products;
use App\Models\Role;
use App\Models\Sponsor;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Financial::class => \App\Policies\FinancialPolicy::class,
        FinancialCategories::class => \App\Policies\FinancialCategoryPolicy::class,
        Party::class => \App\Policies\PartyPolicy::class,
        PartyMenuGroup::class => \App\Policies\PartyMenuGroupPolicy::class,
        PartyMenu::class => \App\Policies\PartyMenuPolicy::class,
        Products::class => \App\Policies\ProductPolicy::class,
        Role::class => \App\Policies\RolePolicy::class,
        Sponsor::class => \App\Policies\SponsorPolicy::class,
        Transactions::class => \App\Policies\TransactionPolicy::class,
        User::class => \App\Policies\UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(function (User $user) {
            return $user->hasRole(Acl::ROLE_SUPER_ADMIN) ? true : null;
        });
    }
}
