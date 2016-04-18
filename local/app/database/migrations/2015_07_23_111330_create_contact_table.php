<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contact', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 150)->nullable();
			$table->string('arabic_name', 255)->nullable();
			$table->boolean('title');
			$table->string('title_text', 255)->nullable();
			$table->string('department', 255)->nullable();
			$table->string('mobile', 20)->nullable();
			$table->string('email', 50)->nullable();
			$table->string('personal_email', 250)->nullable();
			$table->integer('account_id');
			$table->integer('position_id')->nullable();
			$table->integer('country_id');
			$table->string('image', 30)->nullable();
			$table->boolean('favourite');
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->nullable();
			$table->string('tags', 255)->nullable();
			$table->integer('section_id')->nullable();
			$table->integer('type_id');
			$table->boolean('status')->nullable();
			$table->string('facebook', 200)->nullable();
			$table->string('twitter', 200)->nullable();
			$table->string('linkedin', 200)->nullable();
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
		Schema::drop('contact');
	}

}
