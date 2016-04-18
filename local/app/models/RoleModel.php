<?php

use Toddish\Verify\Models\Role as VerifyRole;

class RoleModel extends VerifyRole
{

	protected $table = "role";
    protected $fillable = [];
    protected $guarded = [];

    public static $rules = array(
		'name' => 'required|max:32',
	);

    public function permissions()
    {
        return $this->belongsToMany(
            \Config::get('verify::models.permission'),
            $this->prefix.'permission_role','role_id'
        )
            ->withTimestamps();
    }


}