<?php

namespace Tests\Feature\Models;

use App\Models\Address;
use App\Models\BaseResponse;
use App\Models\Financial;
use App\Models\FinancialCategories;
use App\Models\Party;
use App\Models\PartyMenu;
use App\Models\PartyMenuGroup;
use App\Models\PartySponsor;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Products;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Sponsor;
use App\Models\Transactions;
use App\Models\TransactionsType;
use App\Models\User;
use App\Models\UserParty;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class ModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_models_can_persist_minimal_valid_records(): void
    {
        $models = $this->createModelGraph();

        foreach ($this->uuidModels($models) as $model) {
            $this->assertTrue(Str::isUuid($model->id), $model::class . ' should have a UUID primary key.');
        }

        $this->assertDatabaseHas('addresses', ['id' => $models['address']->id]);
        $this->assertDatabaseHas('parties', ['id' => $models['party']->id]);
        $this->assertDatabaseHas('users', ['id' => $models['user']->id]);
        $this->assertDatabaseHas('roles', ['id' => $models['role']->id]);
        $this->assertDatabaseHas('permissions', ['id' => $models['permission']->id]);
        $this->assertDatabaseHas('permission_roles', ['id' => $models['permissionRole']->id]);
        $this->assertDatabaseHas('role_users', ['id' => $models['roleUser']->id]);
        $this->assertDatabaseHas('user_parties', ['id' => $models['userParty']->id]);
        $this->assertDatabaseHas('sponsors', ['id' => $models['sponsor']->id]);
        $this->assertDatabaseHas('party_sponsors', ['id' => $models['partySponsor']->id]);
        $this->assertDatabaseHas('financials', ['id' => $models['financial']->id]);
        $this->assertDatabaseHas('financial_categories', ['id' => $models['category']->id]);
        $this->assertDatabaseHas('transaction_types', ['id' => $models['transactionType']->id]);
        $this->assertDatabaseHas('transactions', ['id' => $models['transaction']->id]);
        $this->assertDatabaseHas('party_menus', ['id' => $models['menu']->id]);
        $this->assertDatabaseHas('party_menu_groups', ['id' => $models['group']->id]);
        $this->assertDatabaseHas('products', ['id' => $models['product']->id]);
    }

    public function test_model_relationships_resolve_expected_records(): void
    {
        $models = $this->createModelGraph();

        $this->assertTrue($models['party']->address->is($models['address']));
        $this->assertTrue($models['party']->financial->first()->is($models['financial']));
        $this->assertTrue($models['party']->partyMenu->first()->is($models['menu']));
        $this->assertTrue($models['party']->currentPartyMenu->is($models['menu']));
        $this->assertTrue($models['party']->sponsors->first()->is($models['sponsor']));
        $this->assertTrue($models['party']->users->first()->is($models['user']));

        $this->assertTrue($models['financial']->party->is($models['party']));
        $this->assertTrue($models['financial']->transactions->first()->is($models['transaction']));
        $this->assertTrue($models['category']->financial->is($models['financial']));
        $this->assertTrue($models['transaction']->financial->is($models['financial']));
        $this->assertTrue($models['transaction']->categories->is($models['category']));

        $this->assertTrue($models['menu']->party->is($models['party']));
        $this->assertTrue($models['menu']->products->first()->is($models['product']));
        $this->assertTrue($models['group']->menu->is($models['menu']));
        $this->assertTrue($models['product']->menu->is($models['menu']));
        $this->assertTrue($models['product']->group->is($models['group']));

        $this->assertTrue($models['sponsor']->sponsoredParties->first()->is($models['party']));
        $this->assertTrue($models['permissionRole']->permission->is($models['permission']));
        $this->assertTrue($models['permissionRole']->role->is($models['role']));
        $this->assertTrue($models['roleUser']->role->is($models['role']));
        $this->assertTrue($models['roleUser']->party->is($models['party']));
        $this->assertTrue($models['roleUser']->user->is($models['user']));
        $this->assertTrue($models['userParty']->user->is($models['user']));
        $this->assertTrue($models['userParty']->party->is($models['party']));
    }

    public function test_model_accessors_return_expected_values(): void
    {
        $models = $this->createModelGraph();

        $this->assertSame([$models['party']->start_date, $models['party']->end_date], $models['party']->date);
        $this->assertSame($models['party']->name, $models['menu']->party_name);
        $this->assertSame($models['menu']->label, $models['product']->menu_label);
        $this->assertSame($models['group']->name, $models['product']->group_name);
        $this->assertSame($models['party']->name, $models['userParty']->party_name);
        $this->assertSame($models['menu']->id, $models['userParty']->current_menu);
    }

    public function test_user_acl_helpers_return_roles_permissions_and_parties(): void
    {
        $models = $this->createModelGraph();
        $user = $models['user'];

        $this->assertTrue($user->hasRole('Admin', $models['party']->id));
        $this->assertTrue($user->hasPermission('party.read', $models['party']->id));
        $this->assertSame(['Admin'], $user->roleNames($models['party']->id));
        $this->assertSame(['party.read'], $user->permissionNames($models['party']->id));
        $this->assertSame(['parties' => []], $user->getJWTCustomClaims());
        $this->assertSame($user->id, $user->getJWTIdentifier());

        $acl = $user->aclByParty();

        $this->assertCount(1, $acl);
        $this->assertSame($models['party']->id, $acl[0]['id']);
        $this->assertSame(['Admin'], $acl[0]['roles']);
        $this->assertSame(['party.read'], $acl[0]['permissions']);
    }

    public function test_base_response_stores_data_message_and_code(): void
    {
        $response = new BaseResponse();

        $response->setData(['id' => '123']);
        $response->setMessage('Created');
        $response->setCode(201);

        $this->assertSame(['id' => '123'], $response->getData());
        $this->assertSame('Created', $response->getMessage());
        $this->assertSame(201, $response->getCode());
    }

    private function createModelGraph(): array
    {
        $address = Address::create([
            'address' => 'Rua Teste, 123',
            'cep' => '70000-000',
            'neighborhood' => 'Centro',
            'city' => 'Brasilia',
            'uf' => 'DF',
        ]);

        $party = Party::create([
            'name' => 'Party Test',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDay()->toDateString(),
            'reference' => 'party-test',
            'address_id' => $address->id,
        ]);

        $user = User::create([
            'name' => 'Model User',
            'email' => 'model-user@example.com',
            'telephone' => '61999999999',
            'password' => Hash::make('password'),
            'current_party_id' => $party->id,
        ]);

        $role = Role::create([
            'name' => 'Admin',
            'party_id' => $party->id,
        ]);

        $permission = Permission::create([
            'name' => 'party.read',
            'description' => 'Read parties',
        ]);

        $permissionRole = PermissionRole::create([
            'permission_id' => $permission->id,
            'role_id' => $role->id,
        ]);

        $roleUser = RoleUser::create([
            'user_id' => $user->id,
            'role_id' => $role->id,
            'party_id' => $party->id,
        ]);

        $userParty = UserParty::create([
            'user_id' => $user->id,
            'party_id' => $party->id,
        ]);

        $sponsor = Sponsor::create([
            'name' => 'Sponsor Test',
            'telephone' => '61988888888',
            'reference' => 'sponsor-test',
            'address' => 'Sponsor Address',
        ]);

        $partySponsor = PartySponsor::create([
            'party_id' => $party->id,
            'sponsor_id' => $sponsor->id,
        ]);

        $financial = Financial::create([
            'party_id' => $party->id,
        ]);

        $category = FinancialCategories::create([
            'financial_id' => $financial->id,
            'name' => 'Category Test',
        ]);

        $transactionType = TransactionsType::create();

        $transaction = Transactions::create([
            'financial_id' => $financial->id,
            'financial_categories_id' => $category->id,
            'name' => 'Transaction Test',
            'description' => 'Transaction description',
            'value' => 10.50,
        ]);

        $menu = PartyMenu::create([
            'party_id' => $party->id,
            'label' => 'Menu Test',
            'active' => true,
        ]);

        $group = PartyMenuGroup::create([
            'party_menu_id' => $menu->id,
            'name' => 'Group Test',
            'icon' => 'star',
            'color' => '#ffffff',
        ]);

        $product = Products::create([
            'party_menu_id' => $menu->id,
            'party_menu_group_id' => $group->id,
            'name' => 'Product Test',
            'price' => 25.90,
        ]);

        return compact(
            'address',
            'party',
            'user',
            'role',
            'permission',
            'permissionRole',
            'roleUser',
            'userParty',
            'sponsor',
            'partySponsor',
            'financial',
            'category',
            'transactionType',
            'transaction',
            'menu',
            'group',
            'product',
        );
    }

    private function uuidModels(array $models): array
    {
        return [
            $models['address'],
            $models['party'],
            $models['user'],
            $models['role'],
            $models['permission'],
            $models['userParty'],
            $models['sponsor'],
            $models['partySponsor'],
            $models['financial'],
            $models['category'],
            $models['transactionType'],
            $models['transaction'],
            $models['menu'],
            $models['group'],
            $models['product'],
        ];
    }
}
