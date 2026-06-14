<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();
        if (!$user) {
            return redirect('/')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        if ($user->role !== $role) {
            if ($role === 'owner' && $user->role === 'tenant') {
                return redirect()->route('profile.upgrade')->with('info', 'Bạn cần nâng cấp tài khoản thành Chủ trọ để đăng tin phòng trọ.');
            }
            return redirect('/')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }

        return $next($request);
    }
}
