<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWhatsappnumberToUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('user', function(Blueprint $table) {
            $table->string('whatsapp_number',15);
            $table->string('whatsapp_verify_code',10);
        });
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('user', function(Blueprint $table) {
            $table->dropColumn('whatsapp_number');
            $table->dropColumn('whatsapp_verify_code');
        });
	}

}
