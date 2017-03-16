<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreamingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streamings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('content_id');
			$table->string('name');
			$table->string('description')->nullable();
			$table->string('video_url')->nullable();
			$table->datetime('publish_time')->nullable();
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
        Schema::drop('streamings');
    }
}
