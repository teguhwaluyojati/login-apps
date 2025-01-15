<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckTokenExpiration
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user) {
            $token = $user->tokens->last();

            if ($token && Carbon::parse($token->expires_at)->isPast()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token has expired, please login again.',
                ], 401);
            }
        }

        return $next($request);
    }
}
