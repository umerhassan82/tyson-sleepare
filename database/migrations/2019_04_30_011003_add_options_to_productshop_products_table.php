<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOptionsToProductshopProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_products', function (Blueprint $table) {
            $table->decimal('twin', '8', '2')->nullable();
            $table->decimal('twin-xl', '8', '2')->nullable();
            $table->decimal('full', '8', '2')->nullable();
            $table->decimal('queen', '8', '2')->nullable();
            $table->decimal('king', '8', '2')->nullable();
            $table->decimal('cal-king', '8', '2')->nullable();
            $table->decimal('split-king', '8', '2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_products', function (Blueprint $table) {
            //
        });
    }
}
