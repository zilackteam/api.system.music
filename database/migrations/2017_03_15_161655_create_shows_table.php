<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shows', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('content_id');
			$table->datetime('on_datetime')->nullable();
			$table->date('end_date')->nullable();
			$table->string('name')->nullable();
			$table->string('address')->nullable();
			$table->text('contact')->nullable();
			$table->string('impression')->nullable();
			$table->text('content')->nullable();
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
        Schema::drop('shows');
    }
}
