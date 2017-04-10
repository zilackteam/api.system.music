<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_posts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('master_id');
            $table->integer('content_id');
			$table->text('content')->nullable();
			$table->string('photo')->nullable();
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
        Schema::drop('master_posts');
    }
}
