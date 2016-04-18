<?php
 
//
// NOTE Migration Created: 2015-03-12 08:51:18
// --------------------------------------------------
 
class CreateCrm2Database {
//
// NOTE - Make changes to the database.
// --------------------------------------------------
 
public function up()
{

//
// NOTE -- company
// --------------------------------------------------
 
Schema::create('company', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 150)->nullable();
 $table->string('mobile', 20)->nullable();
 $table->string('email', 50)->nullable();
 $table->string('address', 255)->nullable();
 $table->string('image', 30)->nullable();
 $table->string('fax', 150)->nullable();
 $table->unsignedInteger('country_id')->default("65");
 $table->dateTime('created_at')->default("0000-00-00 00:00:00");
 $table->unsignedInteger('created_by')->nullable();
 $table->dateTime('updated_at')->default("0000-00-00 00:00:00");
 $table->unsignedInteger('updated_by')->nullable();
 $table->string('website', 255)->nullable();
 $table->string('notes', 255)->nullable();
 });


//
// NOTE -- contact
// --------------------------------------------------
 
Schema::create('contact', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 150)->nullable();
 $table->string('arabic_name', 255)->nullable();
 $table->boolean('title')->nullable();
 $table->string('mobile', 20)->nullable();
 $table->string('email', 50)->nullable();
 $table->unsignedInteger('company_id')->unsigned();
 $table->string('position', 200)->nullable();
 $table->unsignedInteger('country_id')->default("65");
 $table->string('image', 30)->nullable();
 $table->boolean('favourite');
 $table->dateTime('created_at')->default("0000-00-00 00:00:00");
 $table->unsignedInteger('created_by')->nullable();
 $table->dateTime('updated_at')->default("0000-00-00 00:00:00");
 $table->unsignedInteger('updated_by')->nullable();
 $table->string('tags', 255)->nullable();
 $table->string('website', 255)->nullable();
 $table->unsignedInteger('user_id')->nullable()->unsigned();
 $table->tinyInteger('type')->nullable()->unsigned();
 $table->tinyInteger('status')->nullable();
 $table->string('Department', 255);
 $table->string('Role', 255);
 $table->text('Notes');
 });


//
// NOTE -- contact_message
// --------------------------------------------------
 
Schema::create('contact_message', function($table) {
 $table->increments('id')->unsigned();
 $table->unsignedInteger('contact_id')->nullable()->unsigned();
 $table->unsignedInteger('message_id')->nullable();
 $table->unsignedInteger('received_message_id')->nullable()->unsigned();
 $table->boolean('type');
 $table->unsignedInteger('user_id')->nullable()->unsigned();
 $table->boolean('inbox')->default("1");
 $table->dateTime('created_at');
 $table->dateTime('updated_at');
 });


//
// NOTE -- contact_note
// --------------------------------------------------
 
Schema::create('contact_note', function($table) {
 $table->increments('id')->unsigned();
 $table->unsignedInteger('contact_id')->nullable()->unsigned();
 $table->string('title', 255)->nullable();
 $table->text('details')->nullable();
 $table->dateTime('created_at');
 $table->unsignedInteger('created_by')->nullable()->unsigned();
 $table->unsignedInteger('updated_by')->nullable()->unsigned();
 $table->dateTime('updated_at');
 $table->boolean('important');
 });


//
// NOTE -- contact_product
// --------------------------------------------------
 
Schema::create('contact_product', function($table) {
 $table->increments('id')->unsigned();
 $table->unsignedInteger('contact_id')->nullable()->unsigned();
 $table->unsignedInteger('product_id')->nullable();
 $table->text('details')->nullable();
 $table->dateTime('created_at');
 $table->unsignedInteger('created_by')->nullable()->unsigned();
 $table->unsignedInteger('updated_by')->nullable()->unsigned();
 $table->dateTime('updated_at');
 $table->boolean('important');
 });


//
// NOTE -- country
// --------------------------------------------------
 
Schema::create('country', function($table) {
 $table->increments('id');
 $table->string('name', 80);
 $table->string('calling_code', 8)->nullable();
 $table->string('LAT', 10)->nullable();
 $table->string('LNG', 10)->nullable();
 });


//
// NOTE -- customer_service
// --------------------------------------------------
 
Schema::create('customer_service', function($table) {
 $table->increments('id');
 $table->unsignedInteger('client_id')->nullable();
 $table->unsignedInteger('service_id')->nullable();
 $table->unsignedInteger('user_id')->nullable();
 $table->boolean('status');
 $table->dateTime('created_at')->default("0000-00-00 00:00:00");
 $table->dateTime('updated_at')->default("0000-00-00 00:00:00");
 $table->dateTime('expected_finish_date')->default("0000-00-00 00:00:00");
 $table->dateTime('delivery_date')->default("0000-00-00 00:00:00");
 $table->string('dues', 100)->nullable();
 $table->dateTime('dues_date')->default("0000-00-00 00:00:00");
 $table->string('total_invoice', 100)->nullable();
 });


//
// NOTE -- element_list_value
// --------------------------------------------------
 
Schema::create('element_list_value', function($table) {
 $table->increments('id')->unsigned();
 $table->unsignedInteger('form_element_id')->unsigned();
 $table->string('name', 255);
 $table->string('value', 255)->nullable();
 });


//
// NOTE -- file
// --------------------------------------------------
 
Schema::create('file', function($table) {
 $table->increments('id')->unsigned();
 $table->string('module', 30)->nullable();
 $table->unsignedInteger('record_id')->unsigned();
 $table->string('name', 50)->nullable();
 $table->string('title', 255)->nullable();
 $table->boolean('type');
 });


//
// NOTE -- form_element
// --------------------------------------------------
 
Schema::create('form_element', function($table) {
 $table->increments('id');
 $table->string('form_name', 100)->nullable();
 $table->string('name', 255)->nullable();
 $table->enum('type', array('text','textarea','list'));
 });


//
// NOTE -- mail_template
// --------------------------------------------------
 
Schema::create('mail_template', function($table) {
 $table->increments('id');
 $table->string('title', 255)->nullable();
 $table->string('subject', 255)->nullable();
 $table->text('content')->nullable();
 $table->string('reply_to', 150)->nullable();
 $table->boolean('active');
 $table->unsignedInteger('created_by')->nullable()->unsigned();
 $table->dateTime('created_at');
 $table->unsignedInteger('updated_by')->nullable()->unsigned();
 $table->dateTime('updated_at');
 });


//
// NOTE -- message
// --------------------------------------------------
 
Schema::create('message', function($table) {
 $table->increments('id')->unsigned();
 $table->string('title', 255)->nullable();
 $table->string('subject', 255)->nullable();
 $table->text('content')->nullable();
 $table->string('reply_to', 150)->nullable();
 $table->unsignedInteger('contacts_number')->nullable()->default("1");
 $table->unsignedInteger('user_id');
 $table->boolean('type');
 $table->dateTime('created_at');
 $table->dateTime('updated_at');
 $table->boolean('important');
 });


//
// NOTE -- permission
// --------------------------------------------------
 
Schema::create('permission', function($table) {
 $table->increments('id')->unsigned();
 $table->string('action', 100)->nullable();
 $table->string('module', 100)->nullable();
 $table->string('name', 100)->nullable();
 $table->string('description', 255)->nullable();
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 });


//
// NOTE -- permission_role
// --------------------------------------------------
 
Schema::create('permission_role', function($table) {
 $table->unsignedInteger('permission_id')->unsigned();
 $table->unsignedInteger('role_id')->unsigned();
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 });


//
// NOTE -- product
// --------------------------------------------------
 
Schema::create('product', function($table) {
 $table->increments('id')->unsigned();
 $table->string('title', 255)->nullable();
 $table->text('description')->nullable();
 $table->boolean('active')->default("1");
 $table->dateTime('created_at')->default("0000-00-00 00:00:00");
 $table->unsignedInteger('created_by')->nullable();
 $table->dateTime('updated_at')->default("0000-00-00 00:00:00");
 $table->unsignedInteger('updated_by')->nullable();
 });


//
// NOTE -- received_message
// --------------------------------------------------
 
Schema::create('received_message', function($table) {
 $table->increments('id')->unsigned();
 $table->string('title', 255)->nullable();
 $table->string('subject', 255)->nullable();
 $table->text('content')->nullable();
 $table->string('contact_email', 200)->nullable();
 $table->string('user_email', 200)->nullable();
 $table->dateTime('created_at');
 $table->dateTime('updated_at');
 $table->boolean('important');
 });


//
// NOTE -- role
// --------------------------------------------------
 
Schema::create('role', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 100);
 $table->string('description', 255)->nullable();
 $table->unsignedInteger('level')->default("1");
 $table->boolean('active')->default("1");
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 });


//
// NOTE -- role_user
// --------------------------------------------------
 
Schema::create('role_user', function($table) {
 $table->unsignedInteger('user_id')->unsigned();
 $table->unsignedInteger('role_id')->unsigned();
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->increments('id')->unsigned();
 });


//
// NOTE -- section
// --------------------------------------------------
 
Schema::create('section', function($table) {
 $table->increments('id')->unsigned();
 $table->unsignedInteger('subof');
 $table->string('title', 255)->nullable();
 $table->text('description')->nullable();
 $table->boolean('active')->default("1");
 $table->dateTime('created_at')->default("0000-00-00 00:00:00");
 $table->unsignedInteger('created_by')->nullable();
 $table->dateTime('updated_at')->default("0000-00-00 00:00:00");
 $table->unsignedInteger('updated_by')->nullable();
 });


//
// NOTE -- sms_template
// --------------------------------------------------
 
Schema::create('sms_template', function($table) {
 $table->increments('id');
 $table->string('title', 255)->nullable();
 $table->string('subject', 255)->nullable();
 $table->text('content')->nullable();
 $table->boolean('active');
 $table->unsignedInteger('created_by')->nullable()->unsigned();
 $table->dateTime('created_at');
 $table->unsignedInteger('updated_by')->nullable()->unsigned();
 $table->dateTime('updated_at');
 });


//
// NOTE -- task
// --------------------------------------------------
 
Schema::create('task', function($table) {
 $table->increments('id')->unsigned();
 $table->string('title', 255)->nullable();
 $table->text('details')->nullable();
 $table->boolean('active');
 $table->unsignedInteger('user_id')->nullable()->unsigned();
 $table->dateTime('created_at')->default("0000-00-00 00:00:00");
 $table->unsignedInteger('created_by')->nullable();
 $table->dateTime('updated_at')->default("0000-00-00 00:00:00");
 $table->unsignedInteger('updated_by')->nullable();
 $table->dateTime('start')->default("0000-00-00 00:00:00");
 $table->dateTime('end');
 $table->boolean('allDay')->default("1");
 $table->string('backgroundColor', 30)->nullable();
 $table->string('borderColor', 30);
 });


//
// NOTE -- ticket
// --------------------------------------------------
 
Schema::create('ticket', function($table) {
 $table->unsignedInteger('id');
 $table->string('title', 255)->nullable();
 $table->text('content')->nullable();
 $table->boolean('type')->nullable();
 $table->unsignedInteger('sender_id')->nullable();
 $table->unsignedInteger('receiver_id')->nullable();
 $table->unsignedInteger('parent_id')->nullable();
 $table->dateTime('created_at')->nullable();
 $table->boolean('received')->nullable();
 });


//
// NOTE -- user
// --------------------------------------------------
 
Schema::create('user', function($table) {
 $table->increments('id')->unsigned();
 $table->string('username', 30);
 $table->string('email', 255);
 $table->string('mobile', 30)->nullable();
 $table->string('password', 60);
 $table->boolean('title')->nullable();
 $table->string('salt', 32);
 $table->string('remember_token', 100)->nullable();
 $table->boolean('verified');
 $table->boolean('disabled');
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->dateTime('deleted_at')->nullable();
 $table->unsignedInteger('department_id')->nullable()->unsigned();
 $table->string('position', 100)->nullable();
 $table->string('image', 100)->nullable();
 $table->string('smtp_username', 100)->nullable();
 $table->string('smtp_password', 100)->nullable();
 $table->string('mandrill_password', 100)->nullable();
 $table->string('resalty_username', 100)->nullable();
 $table->string('resalty_password', 100)->nullable();
 $table->text('email_signature')->nullable();
 });


//
// NOTE -- user_department
// --------------------------------------------------
 
Schema::create('user_department', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 255)->nullable();
 $table->text('description')->nullable();
 $table->boolean('active')->default("1");
 $table->dateTime('created_at')->default("0000-00-00 00:00:00");
 $table->unsignedInteger('created_by')->nullable();
 $table->dateTime('updated_at')->default("0000-00-00 00:00:00");
 $table->unsignedInteger('updated_by')->nullable();
 });


//
// NOTE -- role_user_foreign
// --------------------------------------------------
 
Schema::table('role_user', function($table) {
 $table->foreign('role_id')->references('id')->on('role');
 $table->foreign('user_id')->references('id')->on('user');
 });



}
 
//
// NOTE - Revert the changes to the database.
// --------------------------------------------------
 
public function down()
{

Schema::drop('company');
Schema::drop('contact');
Schema::drop('contact_message');
Schema::drop('contact_note');
Schema::drop('contact_product');
Schema::drop('country');
Schema::drop('customer_service');
Schema::drop('element_list_value');
Schema::drop('file');
Schema::drop('form_element');
Schema::drop('mail_template');
Schema::drop('message');
Schema::drop('permission');
Schema::drop('permission_role');
Schema::drop('product');
Schema::drop('received_message');
Schema::drop('role');
Schema::drop('role_user');
Schema::drop('section');
Schema::drop('sms_template');
Schema::drop('task');
Schema::drop('ticket');
Schema::drop('user');
Schema::drop('user_department');
Schema::drop('user_department');

}
}