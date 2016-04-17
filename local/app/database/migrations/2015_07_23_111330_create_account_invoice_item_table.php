<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountInvoiceItemTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_invoice_item', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('invoice_id');
			$table->string('name', 255)->nullable();
			$table->integer('qty');
			$table->decimal('price');
			$table->decimal('total');
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
		Schema::drop('account_invoice_item');
	}

}
