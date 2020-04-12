<?php
namespace Modules\Holonews\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;

class Authenticate
{
    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle(Request $request, \Closure $next)
    {
        if($request->header("API_KEY") && ($request->header("API_KEY") === env("API_KEY")))
        {
            return $next($request);
        }
        if ($this->auth->guard('holonews')->check()) {
            $this->auth->shouldUse('holonews');
        } else {
            throw new AuthenticationException(
                'Unauthenticated.', ['wink'], route('holonews.auth.login')
            );
        }

        return $next($request);
    }
}
