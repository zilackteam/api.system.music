<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStoreSongs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_songs', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('song_id');
            $table->integer('content_id');
            $table->integer('user_id');
            $table->integer('pay');
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
        Schema::drop('user_store_songs');
    }
}
