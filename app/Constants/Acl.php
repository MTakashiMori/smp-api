<?php

namespace App\Constants;

class Acl
{
    CONST ROLE_SUPER_ADMIN = 'Super Admin';
    CONST ROLE_ADMIN = 'Admin';
    CONST ROLE_USER = 'User';
    CONST ROLE_SELLER = 'Seller';

    CONST PERMISSION_DASHBOARD_SUPER_ADMIN_READ = 'dashboard.super-admin.read';
    CONST PERMISSION_DASHBOARD_ADMIN_READ = 'dashboard.admin.read';
    CONST PERMISSION_DASHBOARD_SALES_READ = 'dashboard.sales.read';
    CONST PERMISSION_PARTY_CREATE = 'party.create';
    CONST PERMISSION_PARTY_READ = 'party.read';
    CONST PERMISSION_PARTY_UPDATE = 'party.update';
    CONST PERMISSION_PARTY_DELETE = 'party.delete';
    CONST PERMISSION_PARTY_ASSIGN_USERS = 'party.assign-users';
    CONST PERMISSION_PARTY_MENU_CREATE = 'party-menu.create';
    CONST PERMISSION_PARTY_MENU_READ = 'party-menu.read';
    CONST PERMISSION_PARTY_MENU_UPDATE = 'party-menu.update';
    CONST PERMISSION_PARTY_MENU_DELETE = 'party-menu.delete';
    CONST PERMISSION_PARTY_MENU_GROUP_CREATE = 'party-menu-group.create';
    CONST PERMISSION_PARTY_MENU_GROUP_READ = 'party-menu-group.read';
    CONST PERMISSION_PARTY_MENU_GROUP_UPDATE = 'party-menu-group.update';
    CONST PERMISSION_PARTY_MENU_GROUP_DELETE = 'party-menu-group.delete';
    CONST PERMISSION_PRODUCT_CREATE = 'product.create';
    CONST PERMISSION_PRODUCT_READ = 'product.read';
    CONST PERMISSION_PRODUCT_UPDATE = 'product.update';
    CONST PERMISSION_PRODUCT_DELETE = 'product.delete';
    CONST PERMISSION_PRODUCT_SELL = 'product.sell';
    CONST PERMISSION_SPONSOR_CREATE = 'sponsor.create';
    CONST PERMISSION_SPONSOR_READ = 'sponsor.read';
    CONST PERMISSION_SPONSOR_UPDATE = 'sponsor.update';
    CONST PERMISSION_SPONSOR_DELETE = 'sponsor.delete';
    CONST PERMISSION_FINANCIAL_CREATE = 'financial.create';
    CONST PERMISSION_FINANCIAL_READ = 'financial.read';
    CONST PERMISSION_FINANCIAL_UPDATE = 'financial.update';
    CONST PERMISSION_FINANCIAL_DELETE = 'financial.delete';
    CONST PERMISSION_TRANSACTION_CREATE = 'transaction.create';
    CONST PERMISSION_TRANSACTION_READ = 'transaction.read';
    CONST PERMISSION_TRANSACTION_UPDATE = 'transaction.update';
    CONST PERMISSION_TRANSACTION_DELETE = 'transaction.delete';
    CONST PERMISSION_FINANCIAL_CATEGORY_CREATE = 'financial-category.create';
    CONST PERMISSION_FINANCIAL_CATEGORY_READ = 'financial-category.read';
    CONST PERMISSION_FINANCIAL_CATEGORY_UPDATE = 'financial-category.update';
    CONST PERMISSION_FINANCIAL_CATEGORY_DELETE = 'financial-category.delete';
    CONST PERMISSION_USER_CREATE = 'user.create';
    CONST PERMISSION_USER_READ = 'user.read';
    CONST PERMISSION_USER_UPDATE = 'user.update';
    CONST PERMISSION_USER_DELETE = 'user.delete';
    CONST PERMISSION_ROLE_CREATE = 'role.create';
    CONST PERMISSION_ROLE_READ = 'role.read';
    CONST PERMISSION_ROLE_UPDATE = 'role.update';
    CONST PERMISSION_ROLE_DELETE = 'role.delete';
    CONST PERMISSION_ROLE_ATTACH_USERS = 'role.attach-users';
}
