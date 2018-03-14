<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamStudentDatabaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ExamStudentDatabases', function(Blueprint $table){
			$table->increments('e_s_d_no');
			$table->integer('e_s_d_roll_num')->unsigned();
			$table->integer('e_s_d_code')->unsigned();
			$table->integer('e_s_d_discipline')->unsigned();
			$table->integer('e_s_d_grades')->unsigned();
            $table->integer('e_s_d_teacher')->unsigned();
			$table->boolean('e_s_d_status')->default(1);
            $table->boolean('e_s_d_paid')->default(0);
            $table->integer('e_s_d_user')->default(0);
			
			});
			
		Schema::table('ExamStudentDatabases', function($table){
			
			$table->foreign('e_s_d_code')->references('exam_no')->on('ExamsTables');
           });	
			
			DB::update("ALTER TABLE ExamStudentDatabases AUTO_INCREMENT = 80000000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('ExamStudentDatabases');
    }
}
