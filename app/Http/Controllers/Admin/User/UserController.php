<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\User;

class UserController extends Controller
{
    /*
     * 修改密码
     */
    public function updatePwd(Request $request)
    {
        $old_pwd = $request->old_pwd;
        $new_pwd = $request->new_pwd;
        $re_pwd = $request->re_pwd;

        if (strlen($new_pwd) < 5 || strlen($new_pwd) > 20) {
            return response()->json(['status' => 1, 'msg' => '新密码长度为5~20位']);
        }

        if ($new_pwd != $re_pwd) {
            return response()->json(['status' => 1, 'msg' => '两次输入新密码不一致']);
        }

        if (!User::isPwdRight($old_pwd)) {
            return response()->json(['status' => 1, 'msg' => '原密码不正确']);
        }

        if (User::updatePwd($new_pwd)) {
            return response()->json(['status' => 0, 'msg' => '密码修改成功']);
        } else {
            return response()->json(['status' => 1, 'msg' => '密码修改失败,请重试']);
        }
    }
}
