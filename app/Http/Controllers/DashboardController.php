<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    // Show user job listings
    public function index(): View
    {
        // Get authenticated user
        $user = Auth::user();

        // Fetch job listings for the authenticated user
        $jobListings = Job::where('user_id', $user->id)->get();

        return view('dashboard.index', compact('user', 'jobListings'));
    }
}
