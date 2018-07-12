<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lft');
            $table->unsignedInteger('rgt');
            $table->unsignedInteger('level');
            $table->unsignedInteger('name_id');
            $table->unsignedInteger('article_id');
            $table->unsignedInteger('picture_id');
            $table->timestamps();
            $table->foreign('name_id')->references('id')->on('names');
            $table->foreign('picture_id')->references('id')->on('pictures');
            $table->foreign('article_id')->references('id')->on('articles');
        });
        Schema::table('products', function (Blueprint $table) {
            //
            $table->unsignedInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
            $table->dropForeign('category_id_foreign');
            $table->dropColumn('category_id');
        });
        Schema::dropIfExists('categories');
    }
}
