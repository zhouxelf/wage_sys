<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    /*
     * 登录
     */
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $name = $request->name;
            $pwd = $request->pwd;
            $user = User::getUser($name);

            if ($user && $user->status == 0) {
                if (encrypt_password($pwd, $user->salt) == $user->password) {
                    session(['user' => $user]);
                    return response()->json(['status' => 0, 'msg' => '登录成功']);
                } else {
                    return response()->json(['status' => 1, 'msg' => '用户名或密码错误,请重新输入']);
                }
            } else {
                return response()->json(['status' => 1, 'msg' => '用户名或密码错误,请重新输入']);
            }
        } else {
            return view('login');
        }
    }

    /*
     * 登出
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }

}
