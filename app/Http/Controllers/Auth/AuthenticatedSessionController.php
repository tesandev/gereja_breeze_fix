<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function login(LoginRequest $request):RedirectResponse
    {
        $cek = DB::table('users')
            ->where('isAdmin', '=', 1)
            ->where('email','=',$request->email)
            ->first();
        if ($cek) {
            if (password_verify($request->password,$cek->password)) {
                $request->session()->regenerate();
                return redirect()->intended(RouteServiceProvider::HOME);
            }else{
                $request->session()->invalidate();

                $request->session()->regenerateToken();

                return redirect('/');
            }
        }else {
            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/');
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
