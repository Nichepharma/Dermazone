<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCrmContactMessageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('crm_contact_message', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('contact_id')->nullable();
			$table->integer('message_id')->nullable();
			$table->integer('received_message_id')->nullable();
			$table->boolean('type');
			$table->integer('user_id')->nullable();
			$table->boolean('inbox');
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
		Schema::drop('crm_contact_message');
	}

}
