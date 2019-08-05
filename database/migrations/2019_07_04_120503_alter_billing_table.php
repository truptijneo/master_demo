<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBillingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('billing', function(Blueprint $table){
            $table->integer('pincode')->after('city');
            $table->integer('user_id')->after('pincode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('billing', function(Blueprint $table){
            $table->dropColumn('pincode');
            $table->dropColumn('user_id');
        });
    }
}
