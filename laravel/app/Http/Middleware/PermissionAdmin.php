<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\Notify;

class PermissionAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->has('userInfo')) {
            $user = $request->session()->get('userInfo');
            if($user['level'] == 'admin'){
                return $next($request);
            }else{
                return redirect()->route('/')->with('notify', Notify::export(false,['sMsg' => '', 'eMsg' => 'Bạn không có quyền truy cập chức năng này!']));
            }
        }
        return redirect()->route('auth')->with('notify', Notify::export(false,['sMsg' => '', 'eMsg' => 'Vui lòng đăng nhập trước!']));
    }
}
