<?php

class UserSupervisor extends Eloquent
{

    protected $table = "user_supervisor";
    protected $guarded = [];
    public static $rules = array();
    public static $userSubs = array();

    public static function createTree($users)
    {
        $branch = array();
        // get each user subs
        foreach ($users as $user) {
            static::$userSubs[$user->user_id] = $user->user_id;
            $user = static::getSub($user);
            if($user->children){
                foreach($user->children as $child){
                    static::$userSubs[$child->user_id] = $child->user_id;
                }

                static ::createTree($user->children);
            }
            $branch[] = $user;

        }

        return $branch;

    }

    public static function getSub($user){
        $children = UserSupervisor::where('super_id', $user->user_id)->get(['user_id']);

        if ($children) {
            $user->children = $children;
        }
        return $user;
    }

}