<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradesFee extends Model
{
    protected $table = 'GradesFees';

    protected $primaryKey = 'grades';
	
	 public $timestamps = false;
	
}
