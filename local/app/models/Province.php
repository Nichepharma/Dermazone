<?php

class Province extends Eloquent {
	
	protected $table = "province";
	protected $guarded = [];
	public static $rules = [];
	public $timestamps = false;

	static function userProvinces($userIds){
		$provinces = DB::select("select distinct `province_id` from `user` WHERE `id` in (".toString($userIds).")");
		$provinceIds = [];
		foreach($provinces as $province){
			$provinceIds[] = $province->province_id;
		}
		return $provinceIds;
	}

}