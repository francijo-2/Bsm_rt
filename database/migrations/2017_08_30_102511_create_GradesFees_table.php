<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradesFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GradesFees', function (Blueprint $table) {
            $table->increments('grades');
			$table->integer('fees');
			$table->string('particulars');
			$table->integer('sub_category')->unsigned();
			$table->integer('category')->unsigned();
        });
		
		Schema::table('GradesFees', function($table){
			$table->foreign('sub_category')->references('SubCategoriesId')->on('SubCategories');
			$table->foreign('category')->references('CategoriesId')->on('Categories');
			
			});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('GradesFees');
    }
}
