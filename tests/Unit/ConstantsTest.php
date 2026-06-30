<?php

namespace Tests\Unit;

use App\Constants\Acl;
use App\Constants\FinancialConstants;
use App\Constants\MessagesConstants;
use App\Constants\ResponseMessages;
use App\Constants\TransactionsStatusConstants;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ConstantsTest extends TestCase
{
    public function test_acl_constants_have_expected_values(): void
    {
        $this->assertSame([
            'ROLE_SUPER_ADMIN' => 'Super Admin',
            'ROLE_ADMIN' => 'Admin',
            'ROLE_USER' => 'User',
            'ROLE_SELLER' => 'Seller',
            'PERMISSION_DASHBOARD_SUPER_ADMIN_READ' => 'dashboard.super-admin.read',
            'PERMISSION_DASHBOARD_ADMIN_READ' => 'dashboard.admin.read',
            'PERMISSION_DASHBOARD_SALES_READ' => 'dashboard.sales.read',
            'PERMISSION_PARTY_CREATE' => 'party.create',
            'PERMISSION_PARTY_READ' => 'party.read',
            'PERMISSION_PARTY_UPDATE' => 'party.update',
            'PERMISSION_PARTY_DELETE' => 'party.delete',
            'PERMISSION_PARTY_ASSIGN_USERS' => 'party.assign-users',
            'PERMISSION_PARTY_MENU_CREATE' => 'party-menu.create',
            'PERMISSION_PARTY_MENU_READ' => 'party-menu.read',
            'PERMISSION_PARTY_MENU_UPDATE' => 'party-menu.update',
            'PERMISSION_PARTY_MENU_DELETE' => 'party-menu.delete',
            'PERMISSION_PARTY_MENU_GROUP_CREATE' => 'party-menu-group.create',
            'PERMISSION_PARTY_MENU_GROUP_READ' => 'party-menu-group.read',
            'PERMISSION_PARTY_MENU_GROUP_UPDATE' => 'party-menu-group.update',
            'PERMISSION_PARTY_MENU_GROUP_DELETE' => 'party-menu-group.delete',
            'PERMISSION_PRODUCT_CREATE' => 'product.create',
            'PERMISSION_PRODUCT_READ' => 'product.read',
            'PERMISSION_PRODUCT_UPDATE' => 'product.update',
            'PERMISSION_PRODUCT_DELETE' => 'product.delete',
            'PERMISSION_PRODUCT_SELL' => 'product.sell',
            'PERMISSION_SPONSOR_CREATE' => 'sponsor.create',
            'PERMISSION_SPONSOR_READ' => 'sponsor.read',
            'PERMISSION_SPONSOR_UPDATE' => 'sponsor.update',
            'PERMISSION_SPONSOR_DELETE' => 'sponsor.delete',
            'PERMISSION_FINANCIAL_CREATE' => 'financial.create',
            'PERMISSION_FINANCIAL_READ' => 'financial.read',
            'PERMISSION_FINANCIAL_UPDATE' => 'financial.update',
            'PERMISSION_FINANCIAL_DELETE' => 'financial.delete',
            'PERMISSION_TRANSACTION_CREATE' => 'transaction.create',
            'PERMISSION_TRANSACTION_READ' => 'transaction.read',
            'PERMISSION_TRANSACTION_UPDATE' => 'transaction.update',
            'PERMISSION_TRANSACTION_DELETE' => 'transaction.delete',
            'PERMISSION_FINANCIAL_CATEGORY_CREATE' => 'financial-category.create',
            'PERMISSION_FINANCIAL_CATEGORY_READ' => 'financial-category.read',
            'PERMISSION_FINANCIAL_CATEGORY_UPDATE' => 'financial-category.update',
            'PERMISSION_FINANCIAL_CATEGORY_DELETE' => 'financial-category.delete',
            'PERMISSION_USER_CREATE' => 'user.create',
            'PERMISSION_USER_READ' => 'user.read',
            'PERMISSION_USER_UPDATE' => 'user.update',
            'PERMISSION_USER_DELETE' => 'user.delete',
            'PERMISSION_ROLE_CREATE' => 'role.create',
            'PERMISSION_ROLE_READ' => 'role.read',
            'PERMISSION_ROLE_UPDATE' => 'role.update',
            'PERMISSION_ROLE_DELETE' => 'role.delete',
            'PERMISSION_ROLE_ATTACH_USERS' => 'role.attach-users',
        ], $this->constantsFor(Acl::class));
    }

    public function test_acl_permission_values_are_unique(): void
    {
        $permissions = array_filter(
            $this->constantsFor(Acl::class),
            fn (string $name): bool => str_starts_with($name, 'PERMISSION_'),
            ARRAY_FILTER_USE_KEY
        );

        $this->assertSame($permissions, array_unique($permissions));
    }

    public function test_financial_constants_have_expected_values(): void
    {
        $this->assertSame([
            'OPEN' => 'Open',
            'CLOSED' => 'Closed',
            'ON_REVIEW' => 'On Review',
        ], $this->constantsFor(FinancialConstants::class));
    }

    public function test_messages_constants_have_expected_values(): void
    {
        $this->assertSame([
            'SUCCESS' => 'Success',
            'ERROR' => 'Error',
        ], $this->constantsFor(MessagesConstants::class));
    }

    public function test_response_messages_have_expected_values(): void
    {
        $this->assertSame([
            'SUCCESS' => 'Success',
            'ERROR' => 'Error',
            'NOT_AUTHORIZED' => 'Not authorized',
            'CREATED' => 'Created',
            'UPDATED' => 'Updated',
        ], $this->constantsFor(ResponseMessages::class));
    }

    public function test_transaction_status_constants_have_expected_values(): void
    {
        $this->assertSame([
            'APPROVED' => 'Approved',
            'REJECTED' => 'Rejected',
            'ON_REVIEW' => 'On review',
        ], $this->constantsFor(TransactionsStatusConstants::class));
    }

    private function constantsFor(string $class): array
    {
        return (new ReflectionClass($class))->getConstants();
    }
}
