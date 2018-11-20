<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('actual_password');
            $table->enum('user_type',['Owner','Employee','Customer','Administrator']);
            $table->enum('gender',['Male','Female']);
            $table->integer('is_admin')->default(0);
            $table->integer('disabled')->default(0);
            $table->string('language')->default('en');
            $table->string('photo')->default('/img/default-profile.png');
            $table->rememberToken();
            $table->timestamps();
        });

        User::create([
            'firstname' => 'Kurt',
            'lastname' => 'Dela Rosa',
            'email' => 'ak.delarosa01@gmail.com',
            'password' => '$2y$10$bMDjdL4CHf.YGB8cxzPtbebouko91OZMJUT6y34SME2P31mww6MS2',
            'actual_password' => 'akdelarosa',
            'user_type' => 'Administrator',
            'gender' => 'Male',
            'is_admin' => 1,
            'points' => 100.00
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
