<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('auth_id');
			$table->string('name', 255)->nullable();
			$table->string('phone', 255)->nullable();
			$table->string('avatar', 255)->nullable();
			$table->date('dob')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
