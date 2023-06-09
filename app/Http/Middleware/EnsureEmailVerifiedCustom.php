<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Traits\HttpResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class EnsureEmailVerifiedCustom
{
    use HttpResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|null
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return $next($request);
        }

        if (($request->user() instanceof MustVerifyEmail &&
            ! $request->user()->hasVerifiedEmail())
            && $request->getRequestUri() != "/api/auth/logout"   
            ) {
            return $this->failure('Your email address is not verified.', '', 403);
        }

        return $next($request);
    }
}
