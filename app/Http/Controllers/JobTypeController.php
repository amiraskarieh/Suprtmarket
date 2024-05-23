<?php

namespace App\Http\Controllers;

use App\Models\JobType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobTypeController extends Controller
{
    public function index()
    {
        $types = JobType::all();
        return Inertia::render('JobType/Index', [
            'types' => $types,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|unique:job_types,type',
        ]);

        $jobType = JobType::create($request->all());

        return redirect()->route('job-types.get')->with('success', 'Job Type created successfully.');
    }

    public function destroy(JobType $jobType)
    {
        $jobType->delete();

        return redirect()->route('job-types.get')->with('success', 'Job Type deleted successfully.');
    }
}
