<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (get_session_user_id()) {
            return $next($request);
        } else {
            if ($request->ajax()) {
                // 跳转到登录,登录成功后返回到原页面
                return response("Unauthorized.(未登录)", 401)->header("X-CSRF-TOKEN", csrf_token());
            } else {
                return redirect('/login');
            }
        }

    }
}
