<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLateFeeCountersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('LateFeeCounters', function (Blueprint $table) {
             $table->increments('late_no');
             $table->date('date5')->default('19870505');
             $table->integer('late_status')->unsigned()->default('0');
                        
             });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('LateFeeCounters');
    }
}
