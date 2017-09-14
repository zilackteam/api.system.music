<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('content_id');
			$table->string('performer')->nullable();
			$table->string('author')->nullable();
			$table->string('name')->nullable();
			$table->text('lyrics')->nullable();
			$table->text('description')->nullable();
			$table->string('thumb_url')->nullable();
			$table->integer('is_feature')->nullable()->default(0);
			$table->integer('is_public')->nullable();
			$table->string('file128')->nullable();
			$table->string('file320')->nullable();
			$table->string('file_lossless')->nullable();
			$table->string('keywords')->nullable();
			$table->integer('price')->default(0);
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
        Schema::drop('songs');
    }
}
