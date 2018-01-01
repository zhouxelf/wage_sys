<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\User;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        // 依据角色跳转到哪里
        $user = get_session_user();
        if ($user) {
            if ($user->type == User::TYPE_ADMIN) {
                // 管理员
                return view('admin.index');
            } else if ($user->type == User::TYPE_COMMON) {
                // 普通用户
                return view('common.index');
            }
        }
        return view('login');
    }
}
