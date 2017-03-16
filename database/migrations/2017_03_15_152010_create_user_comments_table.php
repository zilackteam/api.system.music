<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_comments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('master_post_id');
			$table->text('comment')->nullable();
			$table->boolean('liked');
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
        Schema::drop('user_comments');
    }
}
