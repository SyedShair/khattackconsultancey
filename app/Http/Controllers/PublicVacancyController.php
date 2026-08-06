<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class PublicVacancyController extends Controller
{
    /**
     * Public listing at /vacancies. Indeed-style cards when jobs are open;
     * falls back to a simple "no openings right now, apply anyway" form
     * with just name, email, phone, and resume when there's nothing open.
     */
    public function index(Request $request)
    {
        $query = Vacancy::open()->latest();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($location = $request->get('location')) {
            $query->where('location', 'like', "%{$location}%");
        }

        $vacancies = $query->paginate(9)->withQueryString();

        return view('public.vacancies.index', compact('vacancies'));
    }

    public function show(Vacancy $vacancy)
    {
        abort_unless($vacancy->is_open, 404);

        return view('public.vacancies.show', compact('vacancy'));
    }

    /**
     * Apply to a specific open vacancy.
     */
    public function apply(Request $request, Vacancy $vacancy)
    {
        abort_unless($vacancy->is_open, 404);

        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:150'],
            'email'        => ['required', 'email', 'max:150'],
            'phone'        => ['required', 'string', 'max:30'],
            'resume'       => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'cover_letter' => ['nullable', 'string', 'max:5000'],
        ]);

        $validated['resume'] = $request->file('resume')->store('resumes', 'local');
        $validated['vacancy_id'] = $vacancy->id;

        Application::create($validated);

        return back()->with('status', "Thanks {$validated['name']}, your application for \"{$vacancy->title}\" has been received.");
    }

    /**
     * General application used when there are currently no open vacancies.
     * Per requirement: only name, email, phone, and resume — no cover
     * letter, no vacancy selection.
     */
    public function applyGeneral(Request $request)
    {
        // Safety: if a vacancy is actually open, general applications are
        // not accepted — send people to the real listing instead.
        if (Vacancy::open()->exists()) {
            return redirect()->route('vacancies.public.index');
        }

        $validated = $request->validate([
            'name'   => ['required', 'string', 'max:150'],
            'email'  => ['required', 'email', 'max:150'],
            'phone'  => ['required', 'string', 'max:30'],
            'resume' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $validated['resume'] = $request->file('resume')->store('resumes', 'local');
        $validated['vacancy_id'] = null;

        Application::create($validated);

        return back()->with('status', "Thanks {$validated['name']}, we've received your details and will reach out if a suitable role opens up.");
    }
}