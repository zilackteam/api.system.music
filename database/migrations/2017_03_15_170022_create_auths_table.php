<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auths', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('sec_name');
			$table->string('sec_pass')->nullable();
			$table->string('level')->nullable();
			$table->integer('type')->nullable();
			$table->integer('status')->default(0);
			$table->string('name', 255)->nullable();
			$table->string('phone', 255)->nullable();
			$table->string('avatar', 255)->nullable();
			$table->date('dob')->nullable();
			$table->string('short_info', 255)->nullable();
			$table->text('detail_info')->nullable();
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
        Schema::drop('auths');
    }
}
