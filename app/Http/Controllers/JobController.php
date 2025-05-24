<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JobController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $title = 'Available jobs!';
        $jobs = Job::paginate(6);
        return view('Jobs.jobs')->with('jobs', $jobs);
    }

    public function create()
    {
        return view('Jobs.create');
    }

    public function show(Job $job): View
    {
        return view('Jobs.show')->with('job', $job);
    }

    public function store(Request $request)
    {
        $title = $request->input('Title');
        $description = $request->input('Description');

        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|integer',
            'tags' => 'nullable|string',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'required|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:50000',
            'company_website' => 'nullable|url',
        ]);

        //Hardcoded user_id for now
        $validatedData['user_id'] = auth()->user()->id;


        if ($request->hasfile('company_logo')) {
            //Store file and get the path
            $path = $request->file('company_logo')->store('logos', 'public');

            //Add the path to the validated data
            $validatedData['company_logo'] = $path;
        }

        //Submit data to the database
        Job::create($validatedData);

        return redirect()->route('jobs.index')->with('success', 'Job created successfully');
    }

    // Edit the specified resource
    public function edit(Job $job): View
    {
        //Chech if the user is authorized to edit the job
        $this->authorize('update', $job);

        return view('Jobs.edit')->with('job', $job);
    }

    // Update the specified resource in storage
    public function update(Request $request, Job $job): RedirectResponse
    {
        //Chech if the user is authorized to update the job
        $this->authorize('update', $job);

        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|integer',
            'tags' => 'nullable|string',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'required|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:50000',
            'company_website' => 'nullable|url',
        ]);

        if ($request->hasfile('company_logo')) {
            //Delete the old logo if it exists
            Storage::delete('public/logos' . basename($job->company_logo));
            //Store file and get the path
            $path = $request->file('company_logo')->store('logos', 'public');

            //Add the path to the validated data
            $validatedData['company_logo'] = $path;
        }

        //Submit data to the database
        $job->update($validatedData);

        return redirect()->route('jobs.index')->with('success', 'Job updated successfully');
    }

    // Delete the specified resource from storage
    public function destroy(Job $job): RedirectResponse
    {
        //Chech if the user is authorized to update the job
        $this->authorize('delete', $job);

        //Delete the old logo if it exists
        Storage::delete('public/logos/' . $job->company_logo);

        //Delete the job
        $job->delete();

        //If request received from Dashboard
        if (request()->query('from') == 'dashboard') {
            return redirect()->route('dashboard')->with('success', 'Job deleted successfully');
        }

        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully');
    }
}
