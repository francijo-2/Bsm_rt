<?php

namespace App;
use App\Teacher;
use App\Discipline;
use App\StudentInformation;

use Illuminate\Database\Eloquent\Model;

class StudentTeacherMapping extends Model
{
    protected $table = 'StudentTeacherMappings';
	
	public $timestamps = false;

	protected $primaryKey = 'sl_no';
	
	function getTeacherName()
	{
	
	return Teacher::where('teachers_id', $this->teacher)->first()->teacher_name;
	
	}
	
	function getDisciplineName()
	{
	
	return Discipline::where('discipline_id', $this->discipline)->first();
	
	}

	function getNameOfDiscipline()				/*FOR USE IN edit_student FUNCTION OF MainController*/
	{
	
	return Discipline::where('discipline_id', $this->discipline)->first()->disciplines;
	
	}
	
	function getStudentPersonalDetails()
	{
	
	return StudentInformation::where('reg_no', $this->regi_no)->first();
	
	}
	
	function getStudentFees()
	{
	
	return GradesFee::where('grades', $this->level)->first();
	
	}

	function getParticualrsOfStudentFees()
	{
	
	return GradesFee::where('grades', $this->level)->first()->particulars;
	
	}

	function getConvertedDate()
	{
	
		$converted_date = StudentInformation::where('reg_no', $this->regi_no)->first()->joining_date;

		$converted_date = date('Ymd', strtotime("$converted_date"));

		return $converted_date;
	
	}

	function getFeesTransactionDetails()
	{
	
	return FeesTransaction::where('regist_no', $this->regi_no)
								->where('particulars', 1)
								->where('section', $this->discipline)
								->orderby('date1', 'DESC')
								->first();
	
	}		
}	

