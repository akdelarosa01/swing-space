<?php

use Illuminate\Database\Seeder;
use App\DropdownName;

class DropdownNameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DropdownName::create([
        	'description' => 'Employee Position',
			'create_user' => 1,
			'update_user' => 1,
        ]);

        DropdownName::create([
        	'description' => 'Item Type',
			'create_user' => 1,
			'update_user' => 1,
        ]);

        DropdownName::create([
        	'description' => 'Product Type',
			'create_user' => 1,
			'update_user' => 1,
        ]);

        DropdownName::create([
            'description' => 'Unit of Measurement',
            'create_user' => 1,
            'update_user' => 1,
        ]);

        DropdownName::create([
            'description' => 'Product Variants',
            'create_user' => 1,
            'update_user' => 1,
        ]);

        DropdownName::create([
            'description' => 'Space',
            'create_user' => 1,
            'update_user' => 1,
        ]);

        DropdownName::create([
            'description' => 'Discounts',
            'create_user' => 1,
            'update_user' => 1,
        ]);
    }
}
