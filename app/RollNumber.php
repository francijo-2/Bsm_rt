<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RollNumber extends Model
{
    protected $table = 'RollNumberTable';
	
	protected $primaryKey = 'Serial';
	
	 public $timestamps = false;
}
