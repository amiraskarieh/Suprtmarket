<?php

namespace App\Http\Controllers;

use App\Models\EmployeeLog;
use App\Models\CustomerLog;
use App\Models\ProductLog;
use App\Models\ProductTransactionLog;
use App\Models\SuppliedLog;
use App\Models\SupplierLog;
use App\Models\TransactionLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function getRecentLogs(Request $request)
    {
        $validated = $request->validate([
            'n' => 'required|integer|min:1'
        ]);

        $n = $validated['n'];

        $employeeLogs = EmployeeLog::select('id', 'operation_type', 'old_value', 'new_value', 'user_id', 'timestamp')
            ->get()->toArray();
        $customerLogs = CustomerLog::select('id', 'operation_type', 'old_value', 'new_value', 'user_id', 'timestamp')
            ->get()->toArray();
        $productLogs = ProductLog::select('id', 'operation_type', 'old_value', 'new_value', 'user_id', 'timestamp')
            ->get()->toArray();
        $productTransactionLogs = ProductTransactionLog::select('id', 'operation_type', 'old_value', 'new_value', 'user_id', 'timestamp')
            ->get()->toArray();
        $suppliedLogs = SuppliedLog::select('id', 'operation_type', 'old_value', 'new_value', 'user_id', 'timestamp')
            ->get()->toArray();
        $supplierLogs = SupplierLog::select('id', 'operation_type', 'old_value', 'new_value', 'user_id', 'timestamp')
            ->get()->toArray();
        $transactionLogs = TransactionLog::select('id', 'operation_type', 'old_value', 'new_value', 'user_id', 'timestamp')
            ->get()->toArray();

        $logs = array_merge($employeeLogs, $customerLogs, $productLogs, $productTransactionLogs, $suppliedLogs, $supplierLogs, $transactionLogs);

        usort($logs, function ($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });

        $recentLogs = array_slice($logs, 0, $n);

        return response()->json($recentLogs);
    }
}
