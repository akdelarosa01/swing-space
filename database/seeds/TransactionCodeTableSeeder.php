<?php

use Illuminate\Database\Seeder;
use App\TransactionCode;

class TransactionCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransactionCode::create([
        	'code' => 'CUS_CODE',
        	'description' => 'Customer Code',
        	'prefix' => 'A', // {Branch Code}
        	'next_no' => 1,
        	'next_no_length' => 4,
        	'create_user' => 1,
        	'update_user' => 1,
        ]);

        TransactionCode::create([
        	'code' => 'EMP_ID',
        	'description' => 'Employee ID',
        	'prefix' => 'SSA', // Swing Space {Branch Code}
        	'next_no' => 1,
        	'next_no_length' => 3,
        	'create_user' => 1,
        	'update_user' => 1,
        ]);

        TransactionCode::create([
        	'code' => 'ITM_CODE',
        	'description' => 'Item Code',
        	'prefix' => 'SSI', // Swing Space Item
        	'next_no' => 1,
        	'next_no_length' => 3,
        	'create_user' => 1,
        	'update_user' => 1,
        ]);

        TransactionCode::create([
        	'code' => 'PRD_CODE',
        	'description' => 'Product Code',
        	'prefix' => 'SSP', // Swing Space Product
        	'next_no' => 1,
        	'next_no_length' => 3,
        	'create_user' => 1,
        	'update_user' => 1,
        ]);

        TransactionCode::create([
        	'code' => 'INC_CODE',
        	'description' => 'Incentive Code',
        	'prefix' => 'SSAI', // Swing Space {Branch Code} Incentive
        	'next_no' => 1,
        	'next_no_length' => 3,
        	'create_user' => 1,
        	'update_user' => 1,
        ]);

        TransactionCode::create([
            'code' => 'RWD_CODE',
            'description' => 'Rewards Code',
            'prefix' => 'SSAR', // Swing Space {Branch Code} Rewward
            'next_no' => 1,
            'next_no_length' => 3,
            'create_user' => 1,
            'update_user' => 1,
        ]);
    }
}
