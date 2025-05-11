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
        // $a = user::query();
        // $request = $a->where('email', $request->email)->first();

        $request->session()->regenerate();
        if (Auth::user()->role == 'admin') {
            return redirect('/admin');
        } else if (Auth::user()->role == 'user') {
            return redirect("/");
        } else if (Auth::user()->role == 'manager') {
            return redirect('/admin');
        }

        // Default return statement
        // return redirect('/login');
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
