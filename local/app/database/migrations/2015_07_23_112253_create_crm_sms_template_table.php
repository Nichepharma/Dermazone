<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCrmSmsTemplateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('crm_sms_template', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255)->nullable();
			$table->string('subject', 255)->nullable();
			$table->text('content', 65535)->nullable();
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
		Schema::drop('crm_sms_template');
	}

}
