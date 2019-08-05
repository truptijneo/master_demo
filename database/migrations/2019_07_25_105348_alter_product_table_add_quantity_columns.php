<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProductTableAddQuantityColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->integer('total_quantity')->after('image');
            $table->integer('available_quantity')->after('total_quantity');
            $table->integer('sold_out')->after('available_quantity');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('total_quantity');
            $table->dropColumn('available_quantity');
            $table->dropColumn('sold_out');
        });
    }
}
