<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    // Render the login form
    public function login(): View
    {
        return view('auth.login');
    }

    // Handle the login request
    public function authenticate(Request $request): RedirectResponse
    {
        //Validate the request
        $credentialData = $request->validate([
            'email' => 'required|email|max:120',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentialData)) {
            // Authentication passed
            // Regenerate the session to prevent session fixation attacks
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Login successful!');
        }
        // Authentication failed
        return back()->withErrors([
            'email' => ' ',
            'password' => 'The provided credentials do not match our records.'
        ])->onlyInput('email');
    }

    // Handle the logout request
    public function logoutUser(Request $request): RedirectResponse
    {
        Auth::logout();
        // Invalidate the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logout successful!');
    }
}
