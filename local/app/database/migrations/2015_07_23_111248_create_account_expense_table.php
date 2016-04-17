<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountExpenseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_expense', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('main_type_id');
			$table->integer('type_id');
			$table->integer('invoice_id')->nullable();
			$table->decimal('amount');
			$table->date('date');
			$table->integer('created_by');
			$table->integer('updated_by');
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
		Schema::drop('account_expense');
	}

}
