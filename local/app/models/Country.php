<?php

class Country extends Eloquent {
	
	protected $table = "country";
	protected $guarded = [];
	public static $rules = array(
	);

    public function contact()
    {
        return $this->hasOne('Contact');
    }

}