<?php

namespace App;
use App\StudentInformation;
use App\GradesFee;

use Illuminate\Database\Eloquent\Model;

class FeesTransaction extends Model
{
    protected $table = 'FeesTransactions';
	
	public $timestamps = false;

	function getTheName()
	{
	
	return StudentInformation::where('reg_no', $this->regist_no)->first()->stu_name;
	
	}

	function getFeeParticulars()
	{
	
	return GradesFee::where('grades', $this->particulars)->first()->particulars;
	
	}

	function getDisciplineName()
	{
	
	return Discipline::where('discipline_id', $this->section)->first()->disciplines;
	
	}

	function getTeacherName()
	{
	
	return Teacher::where('teachers_id', $this->teacher1)->first()->teacher_name;
	
	}
}	

