<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index()
    {
        $vacancies = Vacancy::orderBy('title')->get(['id', 'title']);

        return view('applications.index', compact('vacancies'));
    }

    /**
     * AJAX: paginated / searchable / filterable list of applications.
     */
    public function data(Request $request)
    {
        $query = Application::with('vacancy:id,title')->latest();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($vacancyId = $request->get('vacancy_id')) {
            if ($vacancyId === 'general') {
                $query->whereNull('vacancy_id');
            } else {
                $query->where('vacancy_id', $vacancyId);
            }
        }

        $perPage = (int) $request->get('per_page', 10);
        $applications = $query->paginate($perPage)->withQueryString();

        $applications->getCollection()->transform(fn (Application $a) => [
            'id'          => $a->id,
            'name'        => $a->name,
            'email'       => $a->email,
            'phone'       => $a->phone,
            'vacancy'     => $a->vacancy?->title ?? 'General Application',
            'status'      => $a->status,
            'applied_at'  => $a->created_at->format('Y-m-d H:i'),
            'resume_url'  => route('applications.resume', $a),
        ]);

        return response()->json([
            'data'         => $applications->items(),
            'current_page' => $applications->currentPage(),
            'last_page'    => $applications->lastPage(),
            'total'        => $applications->total(),
        ]);
    }

    public function show(Application $application)
    {
        $application->load('vacancy');

        return response()->json([
            'id'            => $application->id,
            'name'          => $application->name,
            'email'         => $application->email,
            'phone'         => $application->phone,
            'cover_letter'  => $application->cover_letter,
            'vacancy'       => $application->vacancy?->title ?? 'General Application',
            'status'        => $application->status,
            'applied_at'    => $application->created_at->format('Y-m-d H:i'),
            'resume_url'    => route('applications.resume', $application),
        ]);
    }

    public function updateStatus(Request $request, Application $application)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:' . implode(',', array_keys(Application::STATUSES))],
        ]);

        $application->update($validated);

        return response()->json([
            'message' => "Status updated to \"{$application->status}\".",
        ]);
    }

    public function destroy(Application $application)
    {
        if ($application->resumeExists()) {
            Storage::disk('local')->delete($application->resume);
        }

        $application->delete();

        return response()->json(['message' => 'Application deleted.']);
    }

    /**
     * Stream the resume file. Kept on the private "local" disk (not
     * publicly accessible) — only reachable through this authenticated,
     * role:admin-protected route.
     */
    public function resume(Application $application)
    {
        abort_unless($application->resumeExists(), 404);

        return Storage::disk('local')->download(
            $application->resume,
            $application->name . '-resume.' . pathinfo($application->resume, PATHINFO_EXTENSION)
        );
    }
}