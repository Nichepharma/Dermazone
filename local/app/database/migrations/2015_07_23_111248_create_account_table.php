<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 150)->nullable();
			$table->string('mobile', 20)->nullable();
			$table->text('email', 65535)->nullable();
			$table->string('address', 255)->nullable();
			$table->string('image', 30)->nullable();
			$table->string('fax', 150)->nullable();
			$table->integer('section_id');
			$table->integer('type_id');
			$table->integer('industry_id');
			$table->integer('managed_by');
			$table->string('website', 255)->nullable();
			$table->string('facebook', 100)->nullable();
			$table->string('twitter', 100)->nullable();
			$table->string('linkedin', 100)->nullable();
			$table->string('youtube', 150);
			$table->integer('country_id');
			$table->boolean('favourite');
			$table->text('tags', 65535)->nullable();
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->nullable();
			$table->text('description', 65535)->nullable();
			$table->boolean('deleted');
			$table->string('skype', 100)->nullable();
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
		Schema::drop('account');
	}

}
