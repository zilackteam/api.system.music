<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('content_id');
			$table->string('title')->nullable();
			$table->text('excerpt')->nullable();
			$table->text('content')->nullable();
			$table->string('thumb_url')->nullable();
			$table->string('feature_url')->nullable();
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
        //
    }
}
