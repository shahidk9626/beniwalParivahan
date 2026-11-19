<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Vendor login page (website open hote hi yahi dikhta hai).
     */
    public function create(): View
    {
        return view('auth.login', [
            'isAdmin' => false,
            'title' => 'Vendor Login',
            'action' => route('login'),
        ]);
    }

    /**
     * Super Admin login page (/admin).
     */
    public function createAdmin(): View
    {
        return view('auth.login', [
            'isAdmin' => true,
            'title' => 'Super Admin Login',
            'action' => route('admin.login.submit'),
        ]);
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(User::ROLE_VENDOR);
        $request->session()->regenerate();

        return redirect()->intended(route('vendor.dashboard', absolute: false));
    }

    public function storeAdmin(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(User::ROLE_SUPER_ADMIN);
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $wasAdmin = $request->user()?->isSuperAdmin();

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect($wasAdmin ? route('admin.login') : route('login'));
    }
}