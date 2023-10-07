<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
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
        $user = User::where('token', $request->bearerToken())->first();

        if(!$user || !$request->bearerToken()) {
            return response()->json([
                'message' => 'Invalid token'
            ]);
        }

        if($user->role != "admin") {
            return response()->json([
                'message' => 'Unauthorized user'
            ]);
        }

        return $next($request);
    }
}
