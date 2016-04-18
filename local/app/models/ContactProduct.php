<?php

class ContactProduct extends Eloquent {
	
	protected $table = "contact_product";
	protected $guarded = [];
	public static $rules = array(
	);


	public function contact()
	{
		return $this->belongsTo('Contact');
	}

}