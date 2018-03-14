<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeesDue extends Model
{
    protected $table = 'FeesDues';
	
	public $timestamps = false;
	
	protected $primaryKey = 'sno';

	function getTheName()
	{
	
	return StudentInformation::where('reg_no', $this->registration_no)->first()->stu_name;
	
	}

	function getStuDetails()
	{
	
	return StudentTeacherMapping::where('regi_no', $this->registration_no)
									->where('discipline', $this->discipline_no)
									->where('teacher', $this->teacher_no)
									->first();
	
	}

	function getFeesParticulars()
	{
	
	return GradesFee::where('grades', $this->particulars)
								->first();
	}		

	function getFeeParticulars()
	{
	
	return GradesFee::where('grades', $this->particulars)->first()->fees;
	
	}


	function getDisciplineName()
	{
	
	return Discipline::where('discipline_id', $this->discipline_no)->first()->disciplines;
	
	}

	function getTeacherName()
	{
	
	return Teacher::where('teachers_id', $this->teacher_no)->first()->teacher_name;
	
	}
}
