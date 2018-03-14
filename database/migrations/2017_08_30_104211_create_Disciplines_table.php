<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisciplinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Disciplines', function (Blueprint $table) {
            $table->increments('discipline_id');
            $table->string('disciplines');
			$table->integer('strength');
			$table->integer('sub_category')->unsigned();
        });
		
			Schema::table('Disciplines', function($table){
			$table->foreign('sub_category')->references('SubCategoriesId')->on('SubCategories');
			});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Disciplines');
    }
}
