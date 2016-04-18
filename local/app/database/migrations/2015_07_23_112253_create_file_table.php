<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('file', function(Blueprint $table) {
			$table->increments('id');
			$table->string('module', 30)->nullable();
			$table->integer('record_id');
			$table->string('name', 50)->nullable();
			$table->string('title', 255)->nullable();
			$table->boolean('type');
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
		Schema::drop('file');
	}

}
