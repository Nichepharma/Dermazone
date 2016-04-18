<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user', function(Blueprint $table) {
			$table->increments('id');
			$table->string('username', 30);
			$table->string('email', 255);
			$table->string('mobile', 30)->nullable();
			$table->string('password', 60);
			$table->boolean('title')->nullable();
			$table->string('salt', 32);
			$table->string('remember_token', 100)->nullable();
			$table->boolean('verified');
			$table->boolean('disabled');
			$table->datetime('deleted_at')->nullable();
			$table->integer('department_id')->nullable();
			$table->string('position', 100)->nullable();
			$table->string('image', 100)->nullable();
			$table->string('smtp_username', 100)->nullable();
			$table->string('smtp_password', 100)->nullable();
			$table->string('smtp_host', 150)->nullable();
			$table->string('resalty_username', 100)->nullable();
			$table->string('resalty_password', 100)->nullable();
			$table->text('email_signature', 65535)->nullable();
			$table->integer('sms_used');
			$table->date('sms_count_start_date');
			$table->integer('monthly_sms_allowed');
			$table->integer('lastactivity');
			$table->integer('country_id');
			$table->boolean('deleted');
			$table->string('skype', 100)->nullable();
			$table->string('mandrill_password', 200);
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
		Schema::drop('user');
	}

}
