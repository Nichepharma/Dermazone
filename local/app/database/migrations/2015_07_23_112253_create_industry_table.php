<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIndustryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('industry', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 255)->nullable();
			$table->text('description', 65535)->nullable();
			$table->boolean('active');
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->nullable();
			$table->boolean('deleted');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('industry');
	}

}
