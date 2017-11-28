<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    /**
     * 获取用户
     * @param $loginName 登录名:工号或手机号
     * @return mixed
     */
    public static function getUser($loginName)
    {
        $user = self::where('code', $loginName)
                    ->orWhere('phone', $loginName)
                    ->first();
        return $user;
    }
}
