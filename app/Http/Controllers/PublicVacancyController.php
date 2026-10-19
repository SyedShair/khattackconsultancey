<?php

namespace App\Http\Controllers;

use App\Mail\NewJobApplicationAdminMail;
use App\Models\Application;
use App\Models\User;
use App\Models\Vacancy;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PublicVacancyController extends Controller
{
    /**
     * Public listing at /vacancies. Indeed-style cards when jobs are open;
     * falls back to a simple "no openings right now, apply anyway" form
     * with just name, email, phone, and resume when there's nothing open.
     */
    public function index(Request $request)
    {
        $query = Vacancy::latest();

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
        // abort_unless($vacancy->is_open, 404);

        return view('public.vacancies.show', compact('vacancy'));
    }

    /**
     * Apply to a specific open vacancy.
     */
    public function apply(Request $request, Vacancy $vacancy)
    {
        // abort_unless($vacancy->is_open, 404);

        $validated = $request->validate([
            // 1. Personal details
            'name'             => ['required', 'string', 'max:150'],
            'email'            => ['required', 'email', 'max:150'],
            'phone'            => ['required', 'string', 'max:30'],
            'current_location' => ['required', 'string', 'max:150'],

            // 2. Qualifications and experience
            'highest_qualification' => ['required', Rule::in(array_keys(Application::QUALIFICATIONS))],
            'years_experience'      => ['required', Rule::in(array_keys(Application::EXPERIENCE))],

            // 3. Right to work
            'right_to_work'        => ['required', 'in:yes,no'],
            'requires_sponsorship' => ['required', 'in:yes,no'],

            // 4. Supporting information (max 150 words)
            'suitability' => ['nullable', 'string', 'max:2000', function ($attribute, $value, $fail) {
                $words = preg_split('/\s+/u', trim((string) $value), -1, PREG_SPLIT_NO_EMPTY);
                if (count($words) > 150) {
                    $fail('Please keep this answer to 150 words or fewer.');
                }
            }],

            // 5. CV
            'resume' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],

            // 6. Declaration
            'declaration' => ['accepted'],
        ], [
            'declaration.accepted' => 'You must confirm the declaration to submit your application.',
        ]);

        $data = collect($validated)->except(['declaration', 'right_to_work', 'requires_sponsorship', 'resume'])->all();

        $data['right_to_work']            = $validated['right_to_work'] === 'yes';
        $data['requires_sponsorship']     = $validated['requires_sponsorship'] === 'yes';
        $data['declaration_accepted']     = true;
        $data['declaration_accepted_at']  = now();
        $data['resume']                   = $request->file('resume')->store('resumes', 'local');
        $data['vacancy_id']               = $vacancy->id;

        $application = Application::create($data);

        $this->notifyNewApplication($application);

        return back()
            ->with('status', "Thanks {$validated['name']}, your application for \"{$vacancy->title}\" has been received.")
            ->with('download_url', $this->pdfUrl($application));
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

        $application = Application::create($validated);

        $this->notifyNewApplication($application);

        return back()
            ->with('status', "Thanks {$validated['name']}, we've received your details and will reach out if a suitable role opens up.")
            ->with('download_url', $this->pdfUrl($application));
    }

    /**
     * PDF copy of a submitted application. Reached only through the
     * signed, short-lived link created right after submission.
     * e.g. application-jane-doe-english-tutor.pdf
     */
    public function applicationPdf(Application $application)
    {
        $application->load('vacancy');

        $filename = Str::slug(
            'application ' . $application->name . ' ' . ($application->vacancy->title ?? 'general')
        ) . '.pdf';

        return Pdf::loadView('pdf.application', compact('application'))
            ->setPaper('a4')
            ->download($filename);
    }

    /**
     * Signed link, valid for 10 minutes, no login required.
     */
    protected function pdfUrl(Application $application): string
    {
        return URL::temporarySignedRoute(
            'vacancies.public.applicationPdf',
            now()->addMinutes(10),
            ['application' => $application->id]
        );
    }

    /**
     * Emails every admin about the new application. Wrapped so a mail
     * failure never breaks the submission itself — the application is
     * already saved by the time this runs.
     */
    protected function notifyNewApplication(Application $application): void
    {
        try {
            $adminEmails = User::role('admin')->pluck('email')->filter();
            if ($adminEmails->isNotEmpty()) {
                Mail::to($adminEmails)->send(new NewJobApplicationAdminMail($application));
            }
        } catch (\Throwable $e) {
            Log::error('Failed to send new application admin alert email: ' . $e->getMessage());
        }
    }
}