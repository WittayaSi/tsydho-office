<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        if($request->user()->isAdmin()){
            return $next($request);
        }
        // return back()->withErrors(['admin_errors' => 'หน้า setting เข้าได้เฉพาะ Admin เท่านั้น']);
        abort(401, 'หน้านี้เข้าได้เฉพาะ Admin เท่านั้น');
        // return response('หน้า setting เข้าได้เฉพาะ Admin เท่านั้น', 401);
    }
}
