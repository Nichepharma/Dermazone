<?php

class Customer extends Eloquent {
	
	protected $table = "customer";
	protected $guarded = [];
	public static $rules = array(
	);

    public function doctor()
    {
        return $this->hasOne('Doctor');
    }

}