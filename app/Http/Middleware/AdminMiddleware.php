<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
   public function handle(Request $request, Closure $next)
    {
        // 管理者でない場合はトップページへリダイレクト
        if (!$request->user() || !$request->user()->is_admin) {
            abort(403);
        }

        return $next($request);
    }
}
