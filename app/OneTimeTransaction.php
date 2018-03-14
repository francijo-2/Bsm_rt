<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OneTimeTransaction extends Model
{
   protected $table = 'OneTimeTransactions';
   
   public $timestamps = false;
}
