<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CorrectDocumentLines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_lines', function (Blueprint $table) {
            //
            $table->unsignedInteger('availibility_id')->nullable();
            $table->foreign('availibility_id')->references('id')->on('availibilities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_lines', function (Blueprint $table) {
            //
        });
    }
}
