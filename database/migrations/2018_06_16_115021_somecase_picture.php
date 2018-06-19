<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SomecasePicture extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('picture_some_case', function (Blueprint $table) {
            $table->unsignedInteger('some_case_id');
            $table->unsignedInteger('picture_id')->nullable();
            $table->timestamps();
            $table->foreign('some_case_id')->references('id')->on('some_cases');
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
        //
    }
}
