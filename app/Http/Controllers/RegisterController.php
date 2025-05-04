<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(): View
    {
        return view('auth.register');
    }

    //function to handle the registration form submission
    public function store(Request $request): RedirectResponse
    {
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|string|email|max:120|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        // Hash the password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Create the user
        $user = User::create($validatedData);

        return redirect()->route('login')->with('success', 'Registration successful! You can now log in.');
    }
}
