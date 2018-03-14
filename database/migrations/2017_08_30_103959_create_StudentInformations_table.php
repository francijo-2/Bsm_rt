<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('StudentInformations', function (Blueprint $table) {
            $table->increments('reg_no');
			$table->integer('serial_annualised');
			$table->integer('pre_no');
			$table->integer('post_no');
			$table->string('stu_name');
			$table->date('dob');
			$table->date('joining_date');
			$table->date('scm');
			$table->boolean('exemption');
			$table->boolean('admin_fee_exemption');
			$table->string('landline');
			$table->string('phone_no');
			$table->string('pincode');	
			$table->string('address');	
			$table->string('father_name');
			$table->string('father_designation');
			$table->string('mother_name');
			$table->string('mother_designation');
			$table->string('email_address1');
			$table->string('email_address2');
			$table->string('email_address3');
			$table->boolean('status');
			$table->integer('user')->unsigned();
			$table->boolean('had_id');

        });

     }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('StudentInformations');
    }
}
