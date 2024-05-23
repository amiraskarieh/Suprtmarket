<?php

namespace App\Http\Controllers;

use App\Models\MaritalStatus;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MaritalStatusController extends Controller
{
    public function index()
    {
        $statuses = MaritalStatus::all();
        return Inertia::render('MaritalStatus/Index', [
            'statuses' => $statuses,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|string|unique:marital_statuses,status',
        ]);

        $maritalStatus = MaritalStatus::create($request->all());

        return redirect()->route('marital-statuses.index')->with('success', 'Marital Status created successfully.');
    }

    public function destroy(MaritalStatus $maritalStatus)
    {
        $maritalStatus->delete();

        return redirect()->route('marital-statuses.index')->with('success', 'Marital Status deleted successfully.');
    }
}
