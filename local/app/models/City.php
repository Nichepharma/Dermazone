<?php

class City extends Eloquent {
	
	protected $table = "city";
	protected $guarded = [];
	public static $rules = [];
    public $timestamps = false;

    public function province()
    {
        return $this->belongsTo('provenance');
    }

}