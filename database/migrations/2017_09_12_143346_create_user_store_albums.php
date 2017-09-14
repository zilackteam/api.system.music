<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStoreAlbums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store_albums', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('album_id');
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
        Schema::drop('user_store_albums');
    }
}
