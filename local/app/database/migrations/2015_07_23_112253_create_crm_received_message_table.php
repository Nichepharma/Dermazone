<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCrmReceivedMessageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('crm_received_message', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255)->nullable();
			$table->string('subject', 255)->nullable();
			$table->text('content', 65535)->nullable();
			$table->string('contact_email', 200)->nullable();
			$table->string('user_email', 200)->nullable();
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
		Schema::drop('crm_received_message');
	}

}
