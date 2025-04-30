<?php
namespace App\Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticateAtzicay {
    public function handle(Request $request, Closure $next) {
        
        return $next($request);
    }
}