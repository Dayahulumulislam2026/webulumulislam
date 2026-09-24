<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(): View
    {
        $logs = AuditLog::with('user')->orderByDesc('created_at')->paginate(25);
        return view('admin.audit_logs.index', compact('logs'));
    }
}
