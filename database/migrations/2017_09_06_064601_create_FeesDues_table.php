<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeesDuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FeesDues', function(Blueprint $table)
		{
		  $table->increments('sno');
		  $table->integer('registration_no')->unsigned();
		  $table->date('fee_date')->default('19870707');
		  $table->integer('discipline_no')->unsigned()->default('0');
		  $table->integer('teacher_no')->unsigned()->default('0');
		  $table->boolean('status')->default('0');
		  $table->integer('particulars');
          $table->integer('sub_cat')->unsigned()->default('0');
          			 
		});
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('FeesDues');
    }
}
