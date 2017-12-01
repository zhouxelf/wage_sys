<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    /**
     * 获取用户
     * @param $loginName /登录名:工号或手机号
     * @return mixed
     */
    public static function getUser($loginName)
    {
        $user = self::where('code', $loginName)
                    ->orWhere('phone', $loginName)
                    ->first();
        return $user;
    }

    /**
     * 判断原密码是否正确
     * @param $pwd /原密码
     */
    public static function isPwdRight($pwd)
    {
        $user = self::where('id', get_session_user_id())->first();
        return $user->password == encrypt_password($pwd, $user->salt);
    }

    /**
     * 修改密码
     * @param $pwd /新密码
     */
    public static function updatePwd($pwd)
    {
        $salt = get_salt();
        $password = encrypt_password($pwd, $salt);
        $res = self::where('id', get_session_user_id())
            ->update(['password' => $password, 'salt' => $salt]);
        return $res;
    }
}
