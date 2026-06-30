<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\LoginHistory;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    /**
     * Daftar log aktivitas: filter user, tabel terkait, rentang tanggal.
     */
    public function activityLogs(Request $request)
    {
        $logs = ActivityLog::with('user')
            ->when($request->filled('user_id'), fn ($q) => $q->where('user_id', $request->user_id))
            ->when($request->filled('table_name'), fn ($q) => $q->where('table_name', $request->table_name))
            ->when($request->filled('date_from'), fn ($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn ($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->orderByDesc('created_at')
            ->paginate(25)
            ->withQueryString();

        return view('audit.activity-logs', compact('logs'));
    }

    /**
     * Daftar riwayat login: filter user, rentang tanggal.
     */
    public function loginHistories(Request $request)
    {
        $histories = LoginHistory::with('user')
            ->when($request->filled('user_id'), fn ($q) => $q->where('user_id', $request->user_id))
            ->when($request->filled('date_from'), fn ($q) => $q->whereDate('login_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn ($q) => $q->whereDate('login_at', '<=', $request->date_to))
            ->orderByDesc('login_at')
            ->paginate(25)
            ->withQueryString();

        return view('audit.login-histories', compact('histories'));
    }
}
