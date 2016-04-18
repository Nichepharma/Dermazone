<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountInvoiceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_invoice', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('number')->nullable();
			$table->integer('vendor_id')->nullable();
			$table->integer('main_type_id');
			$table->integer('type_id');
			$table->integer('operation');
			$table->date('date')->nullable();
			$table->decimal('total_amount');
			$table->decimal('discount')->nullable();
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
		Schema::drop('account_invoice');
	}

}
