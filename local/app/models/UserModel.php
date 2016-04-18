<?php

use Toddish\Verify\Models\User as VerifyUser;

class UserModel extends VerifyUser
{
	protected $table = "user";
    protected $guarded = [];
//	protected $fillable = ['username', 'password', 'salt', 'email', 'verified', 'deleted_at', 'disabled', 'mobile','title','created_at','updated_at','department_id'];
	protected $fillable = [];

	public static $rules = array(
		'username' => 'required',
		'email' => 'required|email|unique:user',
		'mobile'=>'numeric',
		'pass' => 'required|min:6|max:64',
//		'smtp_username' => 'required|unique:user',
//		'resalty_username' => 'required|unique:user',
		'image' => 'image',
	);

    public function message()
    {
        return $this->hasOne('Message');
    }

	public function visits()
	{
		return $this->hasMany('Visit','user_id');
	}


	protected $to_check_cache;
	//protected $hidden = array('password');

	public function roles($role_id = null)
    {
        return $this->belongsToMany('RoleModel','role_user','user_id','role_id');
    }

	public function user_roles($role_id = null)
    {
        return $this->hasMany('UserRole','user_id');
    }

    public static function has_perm($perm="")
	{
		if(Auth::check()) {
			return true;
		}
		return false;
	}



    private function getToCheck()
    {

        if(empty($this->to_check_cache))
        {
            $key = static::getKeyName();

            $to_check = static::with(['roles', 'roles.permissions'])
                ->where($key, '=', $this->attributes[$key])
                ->first();

            $this->to_check_cache = $to_check;
        }
        else
        {
            $to_check = $this->to_check_cache;
        }

        return $to_check;
    }

    /**
     * Can the User do something
     *
     * @param  array|string $permissions Single permission or an array or permissions
     * @return boolean
     */
    public function can($permissions)
    {
        $permissions = !is_array($permissions)
            ? [$permissions]
            : $permissions;

        $to_check = $this->getToCheck();

        // Are we a super admin?
        foreach ($to_check->roles as $role)
        {
            if ($role->name === \Config::get('verify::super_admin'))
            {
                return TRUE;
            }
        }

        $valid = FALSE;
        foreach ($to_check->roles as $role)
        {
            if($role->active==0) continue;
            foreach ($role->permissions as $permission)
            {
                if (in_array($permission->name, $permissions))
                {
                    $valid = TRUE;
                    break 2;
                }
            }
        }

        return $valid;
    }

    public static function makeUsername($fullName){
        $name = str_replace([' ','.','-','_'],'',$fullName);
        return strtolower($name);
    }
}