<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_infos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('app_id');
			$table->string('platform');
			$table->string('icon')->nullable();
			$table->string('version')->nullable();
			$table->string('store_url')->nullable();
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
        Schema::drop('app_infos');
    }
}
