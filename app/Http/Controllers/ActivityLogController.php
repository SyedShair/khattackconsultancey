<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get(['id', 'name']);

        return view('activity-logs.index', compact('users'));
    }

    public function data(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%");
            });
        }

        if ($userId = $request->get('user_id')) {
            $query->where('user_id', $userId);
        }

        if ($action = $request->get('action')) {
            $query->where('action', $action);
        }

        $perPage = (int) $request->get('per_page', 15);
        $logs = $query->paginate($perPage)->withQueryString();

        $logs->getCollection()->transform(fn (ActivityLog $log) => [
            'id'           => $log->id,
            'user_name'    => $log->user_name ?? 'System',
            'action'       => $log->action,
            'description'  => $log->description,
            'subject_label' => $log->subject_label,
            'ip_address'   => $log->ip_address,
            'created_at'   => $log->created_at->format('Y-m-d g:i A'),
            'created_human' => $log->created_at->diffForHumans(),
        ]);

        return response()->json([
            'data'         => $logs->items(),
            'current_page' => $logs->currentPage(),
            'last_page'    => $logs->lastPage(),
            'total'        => $logs->total(),
        ]);
    }
}