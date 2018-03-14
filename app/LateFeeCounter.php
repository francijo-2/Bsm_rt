<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LateFeeCounter extends Model
{
   protected $table = 'LateFeeCounters';

   public $timestamps = false;

   protected $primaryKey = 'late_no';
}
