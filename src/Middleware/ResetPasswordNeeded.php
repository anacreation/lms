<?php

namespace Anacreation\Lms\Middleware;

use Closure;

class ResetPasswordNeeded
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if ($user = $request->user() and $user->need_reset_password) {
            return redirect()->route("password.update");
        }

        return $next($request);
    }
}
