<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valutes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('char_code')->unique();
            $table->string('cbr_id')->unique();
            $table->string('name')->unique();
            $table->unsignedInteger('num_code')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('valutes');
    }
}
