<?php

class VisitSlide extends Eloquent {

	protected $table = "visit_slide";
	public $timestamps = false;
	protected $guarded = [];
	public static $rules = array(
	);

	public function slideData()
	{
		return $this->hasOne('ProductSlide','num', 'slide_id')->where('product_id' , 6);
	}


}
