<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JunctionTeachersDiscipline extends Model
{
    protected $table = 'JunctionTeachersDisciplines';


    function getTeacherName()
	{
	
	return Teacher::where('teachers_id', $this->teachers)->first()->teacher_name;
	
	}

	function getStudentCount()
	{
	
	return StudentTeacherMapping::where('teacher', $this->teachers)
									->where('status', 1)
									->count();
	
	}
}
