<?php

use Toddish\Verify\Models\Permission as VerifyPermission;

class PermissionModel extends VerifyPermission
{
	protected $table = "permission";
	protected $fillable = ['action', 'module', 'name', 'description'];


	public static $rules = array(
		'name' => 'required|max:32',
	);

}