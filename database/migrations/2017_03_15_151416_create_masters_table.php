<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('masters', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('auth_id');
			$table->integer('content_id');
			$table->string('name', 255)->nullable();
			$table->string('avatar', 255)->nullable();
			$table->string('short_info', 255)->nullable();
			$table->text('detail_info')->nullable();
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
        Schema::drop('masters');
    }
}
