<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTeacherMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('StudentTeacherMappings', function (Blueprint $table) {
            $table->increments('sl_no');
			$table->integer('regi_no')->unsigned();
			$table->integer('level')->unsigned();
			$table->integer('discipline')->unsigned();
			$table->date('date_of_joining');
			$table->date('date_change');
			$table->integer('teacher')->unsigned();
			$table->integer('special_fee');
			$table->integer('status');
			$table->integer('diff_amount');
			$table->integer('enrolment');
			$table->integer('refundable_deposit');
			$table->integer('frequency');
			$table->integer('user')->unsigned();
			});
			
			Schema::table('StudentTeacherMappings', function($table){
				$table->foreign('regi_no')->references('reg_no')->on('StudentInformations');    
				$table->foreign('level')->references('grades')->on('GradesFees');
				$table->foreign('discipline')->references('discipline_id')->on('Disciplines');
				$table->foreign('teacher')->references('teachers_id')->on('Teachers');
				});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('StudentTeacherMappings');
    }
}
