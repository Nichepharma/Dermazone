<?php

class VisitSlide extends Eloquent {

	protected $table = "visit_slide";
	public $timestamps = false;
	protected $guarded = [];
	public static $rules = array(
	);

	public function slideData()
	{
		return $this->belongsTo('ProductSlide','slide_id');
	}


}
