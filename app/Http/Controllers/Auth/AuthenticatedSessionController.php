<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use app\Models\user;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();
        $roleNames = $user->roles->pluck('role'); // ['admin', 'user', 'manager']

        if ($roleNames->contains('admin')) {
            return redirect('/admin');
        } elseif ($roleNames->contains('manager')) {
            return redirect('/manager');
        } elseif ($roleNames->contains('user') && $user->dep !== null) {
            return redirect('/');
        } else {
            Auth::logout(); // Optionally log them out
            return redirect('/login')->withErrors([
                'message' => 'Account not approved. Admin must assign a department to you.',
            ]);
        }
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
