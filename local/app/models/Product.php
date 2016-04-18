<?php

class Product extends Eloquent {

	public $timestamps = false;
	protected $table = "product";
	protected $guarded = [];
	public static $rules = array(
	);

}
