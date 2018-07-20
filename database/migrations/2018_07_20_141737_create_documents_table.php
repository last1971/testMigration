<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('document_type_id');
            $table->string('number');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('firm_id');
            $table->unsignedInteger('buyer_id')->nullable();
            $table->unsignedInteger('store_id')->nullable();
            $table->unsignedInteger('to_id')->nullable();
            $table->string('note');
            $table->timestamps();
            $table->foreign('document_type_id')->references('id')->on('document_types');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('firm_id')->references('id')->on('firms');
            $table->foreign('buyer_id')->references('id')->on('firms');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('to_id')->references('id')->on('stores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
