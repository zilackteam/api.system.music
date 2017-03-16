<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('content_id');
			$table->string('name')->nullable();
			$table->text('description')->nullable();
			$table->string('thumb_url')->nullable();
			$table->string('feature_url')->nullable();
			$table->integer('is_feature')->nullable();
			$table->integer('is_public')->nullable();
			$table->integer('is_single')->nullable();
			$table->string('keywords')->nullable();
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
        Schema::drop('albums');
    }
}
