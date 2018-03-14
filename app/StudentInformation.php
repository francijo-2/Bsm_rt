<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class StudentInformation extends Model
{
    protected $table = 'StudentInformations';
	
	public $timestamps = false;

	protected $primaryKey = 'reg_no';
	
	function getFeesTransactionDetails()
	{
	
	return FeesTransaction::where('regist_no', $this->reg_no)
								->where('particulars', 1)
								->orderby('date1', 'DESC')
								->first();
	
	}

	function getSearchDataName()
	{
	
	return StudentTeacherMapping::where('regi_no', $this->reg_no)
								->where('status', 1)
								->get();
	
	}
	
	
}