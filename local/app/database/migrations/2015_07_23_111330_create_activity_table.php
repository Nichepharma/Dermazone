<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activity', function(Blueprint $table) {
			$table->increments('id');
			$table->boolean('type');
			$table->string('name', 255)->nullable();
			$table->text('description', 65535)->nullable();
			$table->boolean('active');
			$table->integer('managed_by')->nullable();
			$table->datetime('start');
			$table->datetime('end');
			$table->boolean('allDay');
			$table->string('backgroundColor', 30)->nullable();
			$table->string('borderColor', 30);
			$table->boolean('deleted');
			$table->integer('remind_after')->nullable();
			$table->boolean('with');
			$table->integer('with_id');
			$table->boolean('call_type');
			$table->boolean('status');
			$table->boolean('priority');
			$table->string('where', 255);
			$table->integer('updated_by')->nullable();
			$table->integer('created_by')->nullable();
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
		Schema::drop('activity');
	}

}
