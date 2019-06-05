<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class UserNameMiddleware
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
        //ログインしていない、ユーザー名が一致していない場合
        if (!Auth::check() || $request->user_name != Auth::user()->twitter_nickname) {
            return redirect()->route('top');
        }
        return $next($request);
    }
}
