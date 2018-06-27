<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('name_id');
            $table->unsignedInteger('picture_id')->nullable();
            $table->unsignedInteger('article_id')->nullable();
            $table->timestamps();
            $table->foreign('name_id')->references('id')->on('names');
            $table->foreign('picture_id')->references('id')->on('pictures');
            $table->foreign('article_id')->references('id')->on('articles');
        });
        Schema::create('picture_producer', function (Blueprint $table) {
            $table->unsignedInteger('producer_id');
            $table->unsignedInteger('picture_id')->nullable();
            $table->timestamps();
            $table->foreign('producer_id')->references('id')->on('producers');
            $table->foreign('picture_id')->references('id')->on('pictures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producers');
    }
}
