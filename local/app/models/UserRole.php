<?php

class UserRole extends Eloquent {

	protected $table = "role_user";
	protected $guarded = [];
	public static $rules = array(
		'title'=>'required|alpha_spaces|max:20',
		'description'=>'required|max:400',
		'img' => 'image',
		'icon' => 'image',
	);

	public function user()
	{
		return $this->belongsToMany('UserModel');
	}



}