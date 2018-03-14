<?php

namespace App;
use App\ExamsTable;

use Illuminate\Database\Eloquent\Model;

class ExamStudentDatabase extends Model
{
   protected $table = 'ExamStudentDatabases';
   
   public $timestamps = false;

   protected $primaryKey = 'e_s_d_no';
   
   function getExamDetails()
	{
	
	return ExamsTable::where('exam_no', $this->e_s_d_code)->first();
	
	}
	
	function getExamFees()
	{
	
	return GradesFee::where('grades', $this->e_s_d_grades)->first();
	
	}

	function getStudentDetails()
	{
	
	return StudentInformation::where('reg_no', $this->e_s_d_roll_num)->first();
	
	}

	function getExamParticulars()
	{
	
	return GradesFee::where('grades', $this->e_s_d_grades)->first();
	
	}

	function getTeacher()
	{
	
	return Teacher::where('teachers_id', $this->e_s_d_teacher)->first()->teacher_name;
	
	}

	function getDiscipline()
	{
	
	return Discipline::where('discipline_id', $this->e_s_d_discipline)->first();
	
	}
}
