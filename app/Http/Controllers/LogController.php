<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function getRecentLogs(Request $request)
    {
        $validated = $request->validate([
            'n' => 'required|integer|min:10'
        ]);

        $logs = Log::all()->sortBy('created_at')->take($validated['n']);

        return response()->json($logs);
    }
}
