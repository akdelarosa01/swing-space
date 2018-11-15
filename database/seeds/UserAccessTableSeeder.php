<?php

use Illuminate\Database\Seeder;
use App\UserAccess;
use App\Module;

class UserAccessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$modules = Module::all();

    	foreach ($modules as $key => $mod) {
    		UserAccess::create([
	        	'module_id' => $mod->id,
				'user_id' => 1,
				'access' => 1,
				'create_user' => 1,
				'update_user' => 1
	        ]);
    	}
        
    }
}
