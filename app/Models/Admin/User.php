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

    /**
     * 添加、编辑用户
     * @param $user
     * @return bool
     */
    public static function edit($user)
    {
        $id = $user['id'];
        $code = $user['code'];
        $name = $user['name'];
        $sex = $user['sex'];
        $phone = $user['phone'];

        $res = self::find($id);
        if (empty($res)) {
            $_user = new self;
            $_user->code = $code;
            $_user->name = $name;
            $_user->name_quanpin = get_pinyin_all($name);
            $_user->name_jianpin = get_pinyin_simple($name);
            $_user->sex = $sex;
            $_user->phone = $phone;
            $_user->salt = get_salt();
            $_user->password = encrypt_password(substr($phone, -6), $_user->salt);
            $_user->type = 0;
            $_user->status = 0;
            $_user->creator = get_session_user_id();
            return $_user->save();
        } else {
            $res->code = $code;
            $res->name = $name;
            $res->sex = $sex;
            $res->phone = $phone;
            $res->updater = get_session_user_id();
            return $res->save();
        }
    }

    /**
     * 删除用户
     * @param $id 用户
     * @return mixed
     */
    public static function del($id)
    {
        $user = self::find($id);
        $user->status = '1';
        return $user->save();
    }

    public static function getList($pageSize, $keyword)
    {
        $query = self::where('status', '0')->where('type', 0);
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->orWhere('name', 'like', $keyword . '%')
                    ->orWhere('name_quanpin', 'like', $keyword . '%')
                    ->orWhere('name_jianpin', 'like', $keyword . '%')
                    ->orWhere('code', 'like', $keyword . '%');
            });
        }
        $result = $query->paginate($pageSize);
        return responseToPage($result);
    }
}
