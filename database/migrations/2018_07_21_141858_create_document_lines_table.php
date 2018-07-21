<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('document_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('quantity');
            $table->decimal('price',18,6);
            $table->decimal('vat',6,2)->default(18);
            $table->decimal('sales_tax',6,2)->default(0);
            $table->decimal('total',18,6);
            $table->boolean('taxes_include')->default(true);
            $table->boolean('enabled')->default(true);
            $table->timestamps();
            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('product_id')->references('id')->on('products');
        });
        Schema::table('documents', function (Blueprint $table) {
            //
            $table->unsignedInteger('exchange_rate_id');
            $table->foreign('exchange_rate_id')->references('id')->on('exchange_rates');
        });
        Schema::table('products', function (Blueprint $table) {
            //
            $table->decimal('vat',6,2)->default(18);
        });
        Schema::table('firms', function (Blueprint $table) {
            //
            $table->boolean('working_with_vat')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_lines');
    }
}
