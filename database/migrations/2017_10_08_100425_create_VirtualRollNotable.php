<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVirtualRollNotable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('VirtualRollNo', function (Blueprint $table) {
            $table->increments('VirtualNo');
			 $table->integer('VirtualRoll');
			 $table->integer('VirtualPre');
			 $table->integer('VirtualPost');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('VirtualRollNo');
    }
}
