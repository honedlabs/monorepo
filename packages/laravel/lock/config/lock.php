<?php

return [
    'models' => [
        // 'permission' => \Honed\Lock\Models\Permission::class,
        // 'role' => \Honed\Lock\Models\Role::class,
    ],

    'tables' => [
        'roles' => 'roles',
        'permissions' => 'permissions',
        'user_permissions' => 'user_permissions',
        'user_roles' => 'user_roles',
        'role_permissions' => 'role_permissions',
    ],

    'columns' => [
        'guard_name' => 'name',
        'role_foreign_key' => 'role_id',
        'permission_foreign_key' => 'permission_id',
    ],

    'cache' => [
        'expiration_time' => 3600,

        'key' => 'lock.permissions.cache',

        'store' => 'default',
    ],

];