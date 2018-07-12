<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('name_id');
            $table->unsignedInteger('producer_id')->nullable();
            $table->unsignedInteger('some_case_id')->nullable();
            $table->unsignedInteger('article_id')->nullable();
            $table->unsignedInteger('picture_id')->nullable();
            $table->timestamps();
            $table->foreign('name_id')->references('id')->on('names');
            $table->foreign('picture_id')->references('id')->on('pictures');
            $table->foreign('article_id')->references('id')->on('articles');
            $table->foreign('producer_id')->references('id')->on('producers');
            $table->foreign('some_case_id')->references('id')->on('some_cases');
        });
        Schema::create('picture_product', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('picture_id')->nullable();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::dropIfExists('picture_product');
        Schema::dropIfExists('products');
    }
}
