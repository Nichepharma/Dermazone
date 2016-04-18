<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project', function(Blueprint $table) {
			$table->increments('id');
			$table->decimal('revenue');
			$table->integer('currency_id');
			$table->boolean('probability');
			$table->date('start_date');
			$table->date('closing_date');
			$table->integer('contact_id');
			$table->integer('account_id');
			$table->integer('type_id');
			$table->boolean('favourite');
			$table->text('tags', 65535)->nullable();
			$table->text('details', 65535)->nullable();
			$table->integer('managed_by');
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
		Schema::drop('project');
	}

}
