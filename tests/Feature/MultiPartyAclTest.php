<?php

namespace Tests\Feature;

use App\Constants\Acl;
use App\Models\Address;
use App\Models\Financial;
use App\Models\FinancialCategories;
use App\Models\Party;
use App\Models\PartyMenu;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Transactions;
use App\Models\User;
use App\Models\UserParty;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MultiPartyAclTest extends TestCase
{
    use RefreshDatabase;

    public function test_financial_index_is_limited_to_current_party(): void
    {
        [$user, $partyA, $partyB] = $this->tenantUserWithPermission(Acl::PERMISSION_FINANCIAL_READ);
        $financialA = Financial::create(['party_id' => $partyA->id]);
        $financialB = Financial::create(['party_id' => $partyB->id]);

        $response = $this->actingAs($user, 'api')
            ->withHeader('X-Party-Id', $partyA->id)
            ->getJson('/api/v1/financial');

        $response->assertOk();
        $response->assertJsonFragment(['id' => $financialA->id]);
        $response->assertJsonMissing(['id' => $financialB->id]);
    }

    public function test_user_cannot_show_financial_from_another_party(): void
    {
        [$user, $partyA, $partyB] = $this->tenantUserWithPermission(Acl::PERMISSION_FINANCIAL_READ);
        Financial::create(['party_id' => $partyA->id]);
        $financialB = Financial::create(['party_id' => $partyB->id]);

        $response = $this->actingAs($user, 'api')
            ->withHeader('X-Party-Id', $partyA->id)
            ->getJson('/api/v1/financial/' . $financialB->id);

        $response->assertOk();
        $response->assertJsonPath('data', null);
    }

    public function test_related_parties_uses_authenticated_user_for_non_super_admin(): void
    {
        [$user, $partyA, $partyB] = $this->tenantUserWithPermission(Acl::PERMISSION_PARTY_READ);
        $otherUser = User::factory()->create();
        UserParty::create(['user_id' => $otherUser->id, 'party_id' => $partyB->id]);

        $response = $this->actingAs($user, 'api')
            ->getJson('/api/v1/party/related-user?user_id=' . $otherUser->id);

        $response->assertOk();
        $response->assertJsonFragment(['party_id' => $partyA->id]);
        $response->assertJsonMissing(['party_id' => $partyB->id]);
    }

    public function test_user_with_multiple_parties_only_sees_the_selected_party_data(): void
    {
        [$user, $partyA, $partyB] = $this->tenantUserWithPermission(Acl::PERMISSION_FINANCIAL_READ);
        UserParty::create(['user_id' => $user->id, 'party_id' => $partyB->id]);
        $this->grantPartyPermission($user, $partyB, Acl::PERMISSION_FINANCIAL_READ);

        $financialA = Financial::create(['party_id' => $partyA->id]);
        $financialB = Financial::create(['party_id' => $partyB->id]);

        $partyAResponse = $this->actingAs($user, 'api')
            ->withHeader('X-Party-Id', $partyA->id)
            ->getJson('/api/v1/financial');

        $partyAResponse->assertOk();
        $partyAResponse->assertJsonFragment(['id' => $financialA->id]);
        $partyAResponse->assertJsonMissing(['id' => $financialB->id]);

        $partyBResponse = $this->actingAs($user, 'api')
            ->withHeader('X-Party-Id', $partyB->id)
            ->getJson('/api/v1/financial');

        $partyBResponse->assertOk();
        $partyBResponse->assertJsonFragment(['id' => $financialB->id]);
        $partyBResponse->assertJsonMissing(['id' => $financialA->id]);
    }

    public function test_super_admin_without_party_context_can_see_global_data(): void
    {
        $superAdmin = User::factory()->create();
        $partyA = $this->createParty('Party A');
        $partyB = $this->createParty('Party B');
        $financialA = Financial::create(['party_id' => $partyA->id]);
        $financialB = Financial::create(['party_id' => $partyB->id]);

        $superAdminRole = Role::create(['name' => Acl::ROLE_SUPER_ADMIN]);
        RoleUser::create(['user_id' => $superAdmin->id, 'role_id' => $superAdminRole->id]);

        $response = $this->actingAs($superAdmin, 'api')
            ->getJson('/api/v1/financial');

        $response->assertOk();
        $response->assertJsonFragment(['id' => $financialA->id]);
        $response->assertJsonFragment(['id' => $financialB->id]);
    }

    public function test_super_admin_with_party_context_can_see_global_financial_data(): void
    {
        $superAdmin = User::factory()->create();
        $partyA = $this->createParty('Party A');
        $partyB = $this->createParty('Party B');
        $financialA = Financial::create(['party_id' => $partyA->id]);
        $financialB = Financial::create(['party_id' => $partyB->id]);

        $superAdminRole = Role::create(['name' => Acl::ROLE_SUPER_ADMIN]);
        RoleUser::create(['user_id' => $superAdmin->id, 'role_id' => $superAdminRole->id]);

        $response = $this->actingAs($superAdmin, 'api')
            ->withHeader('X-Party-Id', $partyA->id)
            ->getJson('/api/v1/financial');

        $response->assertOk();
        $response->assertJsonFragment(['id' => $financialA->id]);
        $response->assertJsonFragment(['id' => $financialB->id]);
    }

    public function test_super_admin_with_party_context_can_see_all_party_menus(): void
    {
        $superAdmin = User::factory()->create();
        $partyA = $this->createParty('Party A');
        $partyB = $this->createParty('Party B');
        $menuA = PartyMenu::create(['party_id' => $partyA->id, 'label' => 'Menu A']);
        $menuB = PartyMenu::create(['party_id' => $partyB->id, 'label' => 'Menu B']);

        $superAdminRole = Role::create(['name' => Acl::ROLE_SUPER_ADMIN]);
        RoleUser::create(['user_id' => $superAdmin->id, 'role_id' => $superAdminRole->id]);

        $response = $this->actingAs($superAdmin, 'api')
            ->withHeader('X-Party-Id', $partyA->id)
            ->getJson('/api/v1/party-menu');

        $response->assertOk();
        $response->assertJsonFragment(['id' => $menuA->id]);
        $response->assertJsonFragment(['id' => $menuB->id]);
    }

    public function test_super_admin_assigns_users_to_request_party_even_with_party_context(): void
    {
        $superAdmin = User::factory()->create();
        $user = User::factory()->create();
        $partyA = $this->createParty('Party A');
        $partyB = $this->createParty('Party B');

        $superAdminRole = Role::create(['name' => Acl::ROLE_SUPER_ADMIN]);
        RoleUser::create(['user_id' => $superAdmin->id, 'role_id' => $superAdminRole->id]);

        $response = $this->actingAs($superAdmin, 'api')
            ->withHeader('X-Party-Id', $partyA->id)
            ->postJson('/api/v1/party/assign-users', [
                'users' => [$user->id],
                'party_id' => $partyB->id,
            ]);

        $response->assertOk();
        $this->assertDatabaseHas('user_parties', [
            'user_id' => $user->id,
            'party_id' => $partyB->id,
        ]);
        $this->assertDatabaseMissing('user_parties', [
            'user_id' => $user->id,
            'party_id' => $partyA->id,
        ]);
    }

    public function test_transaction_report_rejects_financial_from_another_party(): void
    {
        [$user, $partyA, $partyB] = $this->tenantUserWithPermission(Acl::PERMISSION_TRANSACTION_READ);
        $financialA = Financial::create(['party_id' => $partyA->id]);
        $financialB = Financial::create(['party_id' => $partyB->id]);
        $category = FinancialCategories::create(['financial_id' => $financialB->id, 'name' => 'Other']);
        Transactions::create([
            'financial_id' => $financialB->id,
            'financial_categories_id' => $category->id,
            'name' => 'Cross-party transaction',
            'description' => 'Should not be visible',
            'value' => 10,
        ]);

        $response = $this->actingAs($user, 'api')
            ->withHeader('X-Party-Id', $partyA->id)
            ->getJson('/api/v1/transactions/report?financial_id=' . $financialB->id);

        $response->assertNotFound();
        $this->assertNotNull($financialA);
    }

    private function tenantUserWithPermission(string $permissionName): array
    {
        $user = User::factory()->create();
        $partyA = $this->createParty('Party A');
        $partyB = $this->createParty('Party B');

        UserParty::create(['user_id' => $user->id, 'party_id' => $partyA->id]);

        $this->grantPartyPermission($user, $partyA, $permissionName);

        return [$user, $partyA, $partyB];
    }

    private function grantPartyPermission(User $user, Party $party, string $permissionName): void
    {
        $role = Role::create(['name' => 'Admin ' . $party->name . ' ' . $permissionName, 'party_id' => $party->id]);
        $permission = Permission::firstOrCreate([
            'name' => $permissionName,
        ], [
            'description' => $permissionName,
        ]);
        $role->permissions()->attach($permission->id);

        RoleUser::create([
            'user_id' => $user->id,
            'role_id' => $role->id,
            'party_id' => $party->id,
        ]);
    }

    private function createParty(string $name): Party
    {
        $address = Address::create([
            'address' => $name . ' address',
            'cep' => '70000-000',
            'neighborhood' => 'Centro',
            'city' => 'Brasilia',
            'uf' => 'DF',
        ]);

        return Party::create([
            'name' => $name,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDay()->toDateString(),
            'reference' => $name,
            'address_id' => $address->id,
        ]);
    }
}
