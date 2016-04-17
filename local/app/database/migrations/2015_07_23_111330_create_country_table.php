<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('country', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 80);
			$table->string('calling_code', 8)->nullable();
			$table->string('LAT', 10)->nullable();
			$table->string('LNG', 10)->nullable();
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
		Schema::drop('country');
	}

}
