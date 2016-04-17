<?php

class Area extends Eloquent {
	
	protected $table = "area";
	protected $guarded = [];
	public static $rules = array(
	);

    public function region()
    {
        return $this->belongsTo('Region');
    }

}