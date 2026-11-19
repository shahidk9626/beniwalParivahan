<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        // Admin ne vendor ko block kar diya to turant logout
        if (! $user->is_active) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route($role === 'super_admin' ? 'admin.login' : 'login')
                ->withErrors(['email' => 'Aapka account band kar diya gaya hai.']);
        }

        abort_unless($user->role === $role, 403);

        return $next($request);
    }
}