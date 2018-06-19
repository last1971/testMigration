<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('some_cases', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('name_id');
            $table->unsignedInteger('picture_id')->nullable();
            $table->unsignedInteger('article_id')->nullable();
            $table->timestamps();
            $table->foreign('name_id')->references('id')->on('names');
            $table->foreign('picture_id')->references('id')->on('pictures');
            $table->foreign('article_id')->references('id')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('somecases');
    }
}
