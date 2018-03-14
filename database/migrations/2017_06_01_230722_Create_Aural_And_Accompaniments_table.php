<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuralAndAccompanimentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('AuralAndAccompaniments', function (Blueprint $table)
        {
            $table->increments('a_no');
            $table->integer('a_code');
            $table->integer('a_roll_no');
            $table->integer('a_discipline');
            $table->integer('a_teacher');
            $table->integer('subject_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('AuralAndAccompaniments');
    }
}
