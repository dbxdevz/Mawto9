<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Dashboard
		Permission::create([
			'name' => 'dashboard-index',
			'table_name' => 'Dashboard',
		]);

        //Order History
        Permission::create([
			'name' => 'order-index',
			'table_name' => 'Order History',
		]);
		Permission::create([
			'name' => 'order-store',
			'table_name' => 'Order History',
		]);
		Permission::create([
			'name' => 'order-show',
			'table_name' => 'Order History',
		]);
		Permission::create([
			'name' => 'order-update',
			'table_name' => 'Order History',
		]);
		Permission::create([
			'name' => 'order-destroy',
			'table_name' => 'Order History',
		]);

        //Products
		Permission::create([
			'name' => 'product-index',
			'table_name' => 'Inventory Products',
		]);
		Permission::create([
			'name' => 'product-store',
			'table_name' => 'Inventory Products',
		]);
		Permission::create([
			'name' => 'product-show',
			'table_name' => 'Inventory Products',
		]);
		Permission::create([
			'name' => 'product-update',
			'table_name' => 'Inventory Products',
		]);
        Permission::create([
			'name' => 'product-destroy',
			'table_name' => 'Inventory Products',
		]);

        //Transactions
		Permission::create([
			'name' => 'transaction-index',
			'table_name' => 'Inventory Transactions',
		]);
		Permission::create([
			'name' => 'transaction-store',
			'table_name' => 'Inventory Transactions',
		]);
		Permission::create([
			'name' => 'transaction-show',
			'table_name' => 'Inventory Transactions',
		]);
		Permission::create([
			'name' => 'transaction-update',
			'table_name' => 'Inventory Transactions',
		]);
        Permission::create([
			'name' => 'transaction-destroy',
			'table_name' => 'Inventory Transactions',
		]);

        //Statistics
        Permission::create([
			'name' => 'statistic-index',
			'table_name' => 'Statistics',
		]);
		Permission::create([
			'name' => 'statistic-store',
			'table_name' => 'Statistics',
		]);
		Permission::create([
			'name' => 'statistic-show',
			'table_name' => 'Statistics',
		]);
		Permission::create([
			'name' => 'statistic-update',
			'table_name' => 'Statistics',
		]);
		Permission::create([
			'name' => 'statistic-destroy',
			'table_name' => 'Statistics',
		]);

        //Affiliate network management
        Permission::create([
            'name' => 'affiliate-index',
            'table_name' => 'Affiliate network management',
        ]);
        Permission::create([
            'name' => 'affiliate-store',
            'table_name' => 'Affiliate network management',
        ]);
        Permission::create([
            'name' => 'affiliate-show',
            'table_name' => 'Affiliate network management',
        ]);
        Permission::create([
            'name' => 'affiliate-update',
            'table_name' => 'Affiliate network management',
        ]);
        Permission::create([
            'name' => 'affiliate-destroy',
            'table_name' => 'Affiliate network management',
        ]);

        //Customers
        Permission::create([
            'name' => 'customer-index',
            'table_name' => 'Customers',
        ]);
        Permission::create([
            'name' => 'customer-store',
            'table_name' => 'Customers',
        ]);
        Permission::create([
            'name' => 'customer-show',
            'table_name' => 'Customers',
        ]);
        Permission::create([
            'name' => 'customer-update',
            'table_name' => 'Customers',
        ]);
        Permission::create([
            'name' => 'customer-destroy',
            'table_name' => 'Customers',
        ]);

        // Roles
		Permission::create([
			'name' => 'role-index',
			'table_name' => 'Role',
		]);
		Permission::create([
			'name' => 'role-store',
			'table_name' => 'Role',
		]);
		Permission::create([
			'name' => 'role-show',
			'table_name' => 'Role',
		]);
		Permission::create([
			'name' => 'role-update',
			'table_name' => 'Role',
		]);
		Permission::create([
			'name' => 'role-destroy',
			'table_name' => 'Role',
		]);

        //User
		Permission::create([
			'name' => 'user-index',
			'table_name' => 'User',
		]);
		Permission::create([
			'name' => 'user-store',
			'table_name' => 'User',
		]);
		Permission::create([
			'name' => 'user-show',
			'table_name' => 'User',
		]);
		Permission::create([
			'name' => 'user-update',
			'table_name' => 'User',
		]);
		Permission::create([
			'name' => 'user-destroy',
			'table_name' => 'User',
		]);

        //Shipping
        Permission::create([
			'name' => 'shipping-index',
			'table_name' => 'Shipping',
		]);
		Permission::create([
			'name' => 'shipping-store',
			'table_name' => 'Shipping',
		]);
		Permission::create([
			'name' => 'shipping-show',
			'table_name' => 'Shipping',
		]);
		Permission::create([
			'name' => 'shipping-update',
			'table_name' => 'Shipping',
		]);
		Permission::create([
			'name' => 'shipping-destroy',
			'table_name' => 'Shipping',
		]);

        //Messaging center
        Permission::create([
			'name' => 'messaging-index',
			'table_name' => 'Messaging',
		]);
		Permission::create([
			'name' => 'messaging-store',
			'table_name' => 'Messaging',
		]);
		Permission::create([
			'name' => 'messaging-show',
			'table_name' => 'Messaging',
		]);
		Permission::create([
			'name' => 'messaging-update',
			'table_name' => 'Messaging',
		]);
		Permission::create([
			'name' => 'messaging-destroy',
			'table_name' => 'Messaging',
		]);

        //Notifications
        Permission::create([
            'name' => 'notification-index',
            'table_name' => 'Notifications',
        ]);
        Permission::create([
            'name' => 'notification-store',
            'table_name' => 'Notifications',
        ]);
        Permission::create([
            'name' => 'notification-show',
            'table_name' => 'Notifications',
        ]);
        Permission::create([
            'name' => 'notification-update',
            'table_name' => 'Notifications',
        ]);
        Permission::create([
            'name' => 'notification-destroy',
            'table_name' => 'Notifications',
        ]);

        // //Permissions
        // Permission::create([
		// 	'name' => 'permission-index',
		// 	'table_name' => 'Permissions',
		// ]);

		$permissions = Permission::all();

		$role = Role::find(1);

		foreach ($permissions as $permission) {
			$role->permissions()->attach($permission->id);
		}
    }
}
