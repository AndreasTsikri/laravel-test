<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class AuthenticateBearerToken
{
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');

        if (! $authHeader || ! str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['message' => 'Missing or invalid Authorization header'], 401);
        }

        $token = $request->bearerToken();//substr($authHeader, 7);

	$user = User::where('simpleBearerToken', $token/*hash('sha256', $token)*/)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        auth()->setUser($user);

        return $next($request);
    }
}
