<?php

use Illuminate\Database\Seeder;
use App\Module;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::create([
        	'module_code' => 'POS_CTRL',
        	'module_name' => 'POS Control',
        	'module_category' => 'POS',
        	'icon' => 'zmdi zmdi-menu zmdi-hc-fw',
        	'create_user' => 1,
        	'update_user' => 1
        ]);

        Module::create([
        	'module_code' => 'CUS_LST',
        	'module_name' => 'Customer List',
        	'module_category' => 'Customers',
        	'icon' => 'zmdi zmdi-accounts zmdi-hc-fw',
        	'create_user' => 1,
        	'update_user' => 1
        ]);


        Module::create([
        	'module_code' => 'CUS_MEM',
        	'module_name' => 'Membership',
        	'module_category' => 'Customers',
        	'icon' => 'zmdi zmdi-accounts zmdi-hc-fw',
        	'create_user' => 1,
        	'update_user' => 1
        ]);


        Module::create([
        	'module_code' => 'INV_LST',
        	'module_name' => 'Inventory List',
        	'module_category' => 'Inventory',
        	'icon' => 'zmdi zmdi-label zmdi-hc-fw',
        	'create_user' => 1,
        	'update_user' => 1
        ]);


        Module::create([
        	'module_code' => 'SUM_LST',
        	'module_name' => 'Summary List',
        	'module_category' => 'Inventory',
        	'icon' => 'zmdi zmdi-label zmdi-hc-fw',
        	'create_user' => 1,
        	'update_user' => 1
        ]);


        Module::create([
        	'module_code' => 'RCV_ITM',
        	'module_name' => 'Receive Item',
        	'module_category' => 'Inventory',
        	'icon' => 'zmdi zmdi-label zmdi-hc-fw',
        	'create_user' => 1,
        	'update_user' => 1
        ]);


        Module::create([
        	'module_code' => 'UPD_INV',
        	'module_name' => 'Update Inventory',
        	'module_category' => 'Inventory',
        	'icon' => 'zmdi zmdi-label zmdi-hc-fw',
        	'create_user' => 1,
        	'update_user' => 1
        ]);


        Module::create([
        	'module_code' => 'ITM_OUT',
        	'module_name' => 'Item Output',
        	'module_category' => 'Inventory',
        	'icon' => 'zmdi zmdi-label zmdi-hc-fw',
        	'create_user' => 1,
        	'update_user' => 1
        ]);

        Module::create([
        	'module_code' => 'EMP_LST',
        	'module_name' => 'Employee List',
        	'module_category' => 'Employee',
        	'icon' => 'zmdi zmdi-accounts-list',
        	'create_user' => 1,
        	'update_user' => 1
        ]);

        Module::create([
        	'module_code' => 'EMP_REG',
        	'module_name' => 'Employee Registration',
        	'module_category' => 'Employee',
        	'icon' => 'zmdi zmdi-accounts-list',
        	'create_user' => 1,
        	'update_user' => 1
        ]);

        Module::create([
        	'module_code' => 'PRD_LST',
        	'module_name' => 'Product List',
        	'module_category' => 'Product',
        	'icon' => 'zmdi zmdi-shopping-basket',
        	'create_user' => 1,
        	'update_user' => 1
        ]);

        Module::create([
        	'module_code' => 'PRD_REG',
        	'module_name' => 'Product Registration',
        	'module_category' => 'Product',
        	'icon' => 'zmdi zmdi-shopping-basket',
        	'create_user' => 1,
        	'update_user' => 1
        ]);

        Module::create([
        	'module_code' => 'GEN_SET',
        	'module_name' => 'General Settings',
        	'module_category' => 'Settings',
        	'icon' => 'zmdi zmdi-settings zmdi-hc-fw',
        	'create_user' => 1,
        	'update_user' => 1
        ]);

        Module::create([
        	'module_code' => 'DRP_SET',
        	'module_name' => 'Dropdown Settings',
        	'module_category' => 'Settings',
        	'icon' => 'zmdi zmdi-settings zmdi-hc-fw',
        	'create_user' => 1,
        	'update_user' => 1
        ]);

        Module::create([
        	'module_code' => 'SAL_RPT',
        	'module_name' => 'Sales Report',
        	'module_category' => 'Reports',
        	'icon' => 'zmdi zmdi-file zmdi-hc-fw',
        	'create_user' => 1,
        	'update_user' => 1
        ]);
    }
}
