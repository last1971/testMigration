<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('alias')->unique();
            $table->timestamps();
        });

        Schema::table('prices', function (Blueprint $table) {
            //
            $table->unsignedInteger('price_type_id')->nullable();
            $table->foreign('price_type_id')->references('id')->on('price_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_types');
    }
}
