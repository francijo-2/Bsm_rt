<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VirtualRollNum extends Model
{
   protected $table = 'VirtualRollNo';
   
   protected $primaryKey = 'VirtualNo';
   
   public $timestamps = false;
}
