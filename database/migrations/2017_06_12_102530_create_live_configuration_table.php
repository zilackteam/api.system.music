<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiveConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_configuration', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('app_id');
            $table->integer('protocol');
            $table->string('address');
            $table->integer('port');
            $table->string('application');
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
        Schema::drop('live_configuration');
    }
}
