<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function getRecentLogs(Request $request)
    {
        $logs = Log::all()->sortBy('created_at')->take(40);

        return response()->json($logs);
    }
}
