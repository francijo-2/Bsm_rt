<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
	{
    protected $table = 'Disciplines';
	
	protected $primaryKey = 'discipline_id';

	public $timestamps = false;
	
	public static function text()
	{
	
	}
	
	}
