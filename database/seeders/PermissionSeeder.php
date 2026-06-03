<?php

namespace Database\Seeders;

use App\Constants\Acl;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach ([
            Acl::PERMISSION_DASHBOARD_SUPER_ADMIN_READ => 'Read Super Admin Dashboard',
            Acl::PERMISSION_DASHBOARD_ADMIN_READ => 'Read Admin Dashboard',
            Acl::PERMISSION_DASHBOARD_SALES_READ => 'Read Sales Dashboard',
            Acl::PERMISSION_PARTY_CREATE => 'Create Party',
            Acl::PERMISSION_PARTY_READ => 'Read Party',
            Acl::PERMISSION_PARTY_UPDATE => 'Update Party',
            Acl::PERMISSION_PARTY_DELETE => 'Delete Party',
            Acl::PERMISSION_PARTY_ASSIGN_USERS => 'Assign Users To Party',
            Acl::PERMISSION_PARTY_MENU_CREATE => 'Create Party Menu',
            Acl::PERMISSION_PARTY_MENU_READ => 'Read Party Menu',
            Acl::PERMISSION_PARTY_MENU_UPDATE => 'Update Party Menu',
            Acl::PERMISSION_PARTY_MENU_DELETE => 'Delete Party Menu',
            Acl::PERMISSION_PARTY_MENU_GROUP_CREATE => 'Create Party Menu Group',
            Acl::PERMISSION_PARTY_MENU_GROUP_READ => 'Read Party Menu Group',
            Acl::PERMISSION_PARTY_MENU_GROUP_UPDATE => 'Update Party Menu Group',
            Acl::PERMISSION_PARTY_MENU_GROUP_DELETE => 'Delete Party Menu Group',
            Acl::PERMISSION_PRODUCT_CREATE => 'Create Product',
            Acl::PERMISSION_PRODUCT_READ => 'Read Product',
            Acl::PERMISSION_PRODUCT_UPDATE => 'Update Product',
            Acl::PERMISSION_PRODUCT_DELETE => 'Delete Product',
            Acl::PERMISSION_PRODUCT_SELL => 'Sell Product',
            Acl::PERMISSION_SPONSOR_CREATE => 'Create Sponsor',
            Acl::PERMISSION_SPONSOR_READ => 'Read Sponsor',
            Acl::PERMISSION_SPONSOR_UPDATE => 'Update Sponsor',
            Acl::PERMISSION_SPONSOR_DELETE => 'Delete Sponsor',
            Acl::PERMISSION_FINANCIAL_CREATE => 'Create Financial',
            Acl::PERMISSION_FINANCIAL_READ => 'Read Financial',
            Acl::PERMISSION_FINANCIAL_UPDATE => 'Update Financial',
            Acl::PERMISSION_FINANCIAL_DELETE => 'Delete Financial',
            Acl::PERMISSION_TRANSACTION_CREATE => 'Create Transaction',
            Acl::PERMISSION_TRANSACTION_READ => 'Read Transaction',
            Acl::PERMISSION_TRANSACTION_UPDATE => 'Update Transaction',
            Acl::PERMISSION_TRANSACTION_DELETE => 'Delete Transaction',
            Acl::PERMISSION_FINANCIAL_CATEGORY_CREATE => 'Create Financial Category',
            Acl::PERMISSION_FINANCIAL_CATEGORY_READ => 'Read Financial Category',
            Acl::PERMISSION_FINANCIAL_CATEGORY_UPDATE => 'Update Financial Category',
            Acl::PERMISSION_FINANCIAL_CATEGORY_DELETE => 'Delete Financial Category',
            Acl::PERMISSION_USER_CREATE => 'Create User',
            Acl::PERMISSION_USER_READ => 'Read User',
            Acl::PERMISSION_USER_UPDATE => 'Update User',
            Acl::PERMISSION_USER_DELETE => 'Delete User',
            Acl::PERMISSION_ROLE_CREATE => 'Create Role',
            Acl::PERMISSION_ROLE_READ => 'Read Role',
            Acl::PERMISSION_ROLE_UPDATE => 'Update Role',
            Acl::PERMISSION_ROLE_DELETE => 'Delete Role',
            Acl::PERMISSION_ROLE_ATTACH_USERS => 'Attach Users To Role',
        ] as $name => $description) {
            Permission::updateOrCreate([
                'name' => $name,
            ], [
                'description' => $description,
            ]);
        }
    }
}
