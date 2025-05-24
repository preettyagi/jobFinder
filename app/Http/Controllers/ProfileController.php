<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //Update the profile of the user

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
        ]);

        $user->update($validatedData);

        return redirect()->route('dashboard')->with('success', 'Profile updated successfully!');
    }
}
