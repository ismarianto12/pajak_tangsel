<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class AuthloginMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $data = $request->header();
        $key = $data['x-api-key'][0]; 
        try {
            if ($key == 'ismarianto') {
                return $next($request);
            } else {
                return response()->json([
                    'msg' => 'key api salah',
                ]);
            }
        } catch (\Throwable $key) {
            return response()->json([
                'msg' => 'autentitkassi gagal',
            ]);
        }
    }
}
