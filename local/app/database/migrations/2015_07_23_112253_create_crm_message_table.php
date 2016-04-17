<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCrmMessageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('crm_message', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255)->nullable();
			$table->string('subject', 255)->nullable();
			$table->text('content', 65535)->nullable();
			$table->string('reply_to', 150)->nullable();
			$table->integer('contacts_number')->nullable();
			$table->integer('user_id');
			$table->boolean('type');
			$table->boolean('important');
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
		Schema::drop('crm_message');
	}

}
