<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('stock_defective');
            $table->unsignedinteger('stock_min')->default(0);
            $table->unsignedBigInteger('locations_id');
            $table->foreign('locations_id')->references('id')->on('locations');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedinteger('stock_defective')->default(0);
            $table->dropColumn('stock_min');
            $table->dropForeign(['locations_id']);
            $table->dropColumn('locations_id');
        });
    }
}
