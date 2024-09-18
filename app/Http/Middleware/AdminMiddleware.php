<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->is_admin !== 1) {
            // 如果用戶未登入或不是管理員，可以選擇重定向或返回錯誤響應
            return redirect()->route('login')->with('error', '您沒有權限訪問該頁面。');
            // 或者返回一個 JSON 響應（如果是 API）
            // return response()->json(['error' => '未授權'], 403);
        }

        return $next($request);
    }

}
