<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSomeCaseAliasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('some_case_aliases', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('master_id');
            $table->unsignedInteger('some_case_id')->unique();
            $table->timestamps();
            $table->foreign('master_id')->references('id')->on('some_cases');
            $table->foreign('some_case_id')->references('id')->on('some_cases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('some_case_aliases');
    }
}
