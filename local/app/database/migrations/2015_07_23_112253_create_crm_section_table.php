<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCrmSectionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('crm_section', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('subof');
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
		Schema::drop('crm_section');
	}

}
