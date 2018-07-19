<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('availibility_id');
            $table->unsignedInteger('valute_id');
            $table->decimal('value',18,6);
            $table->unsignedInteger('maximum');
            $table->timestamps();
            $table->foreign('availibility_id')->references('id')->on('availibilities');
            $table->foreign('valute_id')->references('id')->on('valutes');
        });
        Schema::table('availibilities', function (Blueprint $table) {
            //
            $table->unique(['store_id', 'position_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
