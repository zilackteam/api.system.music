<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('websites', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('content_id');
            $table->text('singer_info')->nullable();
            $table->text('bio_title')->nullable();
            $table->text('bio_content')->nullable();
            $table->text('contact_title')->nullable();
            $table->text('contact_content')->nullable();
            $table->text('app_title')->nullable();
            $table->text('app_content')->nullable();
            $table->text('dev_title')->nullable();
            $table->text('dev_content')->nullable();
            $table->text('guide_title')->nullable();
            $table->text('guide_content')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
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
        Schema::drop('websites');
    }
}
