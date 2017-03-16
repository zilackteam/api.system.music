<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('app_id');
			$table->datetime('last_login_time')->nullable();
			$table->datetime('actived_at')->nullable();
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
        Schema::drop('app_users');
    }
}
