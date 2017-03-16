<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('content_id');
			$table->integer('category')->nullable();
			$table->string('name')->nullable();
			$table->string('performer')->nullable();
			$table->string('video_url')->nullable();
			$table->string('thumb_url')->nullable();
			$table->integer('is_feature')->nullable();
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
        Schema::drop('videos');
    }
}
