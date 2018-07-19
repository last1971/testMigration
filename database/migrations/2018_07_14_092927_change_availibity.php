<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAvailibity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('availibilities', function (Blueprint $table) {
            //
            $table->unsignedInteger('minimum')->default(1);
            $table->unsignedInteger('multiply')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('availibilities', function (Blueprint $table) {
            //
        });
    }
}
