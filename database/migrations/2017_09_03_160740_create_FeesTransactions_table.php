<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeesTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('FeesTransactions', function (Blueprint $table){
		   $table->increments('tran_no');
		   $table->integer('regist_no')->unsigned();
		   $table->date('date1')->default(19870707);
		   $table->date('billing_date')->default(19870707);
		   $table->integer('money_collected')->default(0);
		   $table->integer('fee_by_month')->default(0);
		   $table->integer('section')->unsigned();
		   $table->integer('particulars')->default(0);
		   $table->integer('teacher1')->default(0);
		   $table->integer('receipt_no')->default(0);
		   $table->integer('user')->unsigned();
		   });
		   
		Schema::table('FeesTransactions', function($table){
			$table->foreign('section')->references('discipline_id')->on('Disciplines');
				
			});   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FeesTransactions');
    }
}
