<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWhatsapppassToUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('user', function(Blueprint $table) {
            $table->string('whatsapp_password',40);
            $table->string('whatsapp_nickname',50);
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
            $table->dropColumn('whatsapp_password');
            $table->dropColumn('whatsapp_nickname');
        });
	}

}
