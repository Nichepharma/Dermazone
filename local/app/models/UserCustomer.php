<?php

class UserCustomer extends Eloquent {
	
	protected $table = "user_customer";
	protected $guarded = [];
	public $timestamps = false;
	public static $rules = array(
	);

}