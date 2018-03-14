<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ExamsTables', function (Blueprint $table)
		{
			$table->increments('exam_no');
			$table->integer('exam_code');
			$table->string('exam_name')->default('Trinity');
			$table->integer('category_code');
			$table->date('approx_date');
			$table->date('last_app_date');
			$table->boolean('status')->default('1');
            $table->integer('user')->unsigned();
		});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ExamsTables');
    }
}
