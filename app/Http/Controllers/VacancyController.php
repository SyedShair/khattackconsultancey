<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    public function index()
    {
        return view('vacancies.index');
    }

    /**
     * AJAX: paginated / searchable / filterable list of vacancies.
     */
    public function data(Request $request)
    {
        $query = Vacancy::withCount('applications');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $perPage = (int) $request->get('per_page', 10);
        $vacancies = $query->orderByDesc('id')->paginate($perPage)->withQueryString();

        $vacancies->getCollection()->transform(fn (Vacancy $v) => [
            'id'                => $v->id,
            'title'             => $v->title,
            'department'        => $v->department,
            'location'          => $v->location,
            'type'              => Vacancy::TYPES[$v->type] ?? $v->type,
            'status'            => $v->status,
            'deadline'          => optional($v->deadline)->format('Y-m-d'),
            'applications_count' => $v->applications_count,
            'edit_url'          => route('vacancies.edit', $v),
            // Public route/view is added later when the website is wired up;
            // guarded so the admin list still works before that exists.
            'public_url'        => \Illuminate\Support\Facades\Route::has('vacancies.public.show')
                ? route('vacancies.public.show', $v)
                : null,
        ]);

        return response()->json([
            'data'         => $vacancies->items(),
            'current_page' => $vacancies->currentPage(),
            'last_page'    => $vacancies->lastPage(),
            'total'        => $vacancies->total(),
        ]);
    }

    public function create()
    {
        return view('vacancies.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $vacancy = Vacancy::create($validated);

        return redirect()->route('vacancies.index')
            ->with('status', "Vacancy \"{$vacancy->title}\" created.");
    }

    public function edit(Vacancy $vacancy)
    {
        return view('vacancies.edit', compact('vacancy'));
    }

    public function update(Request $request, Vacancy $vacancy)
    {
        $validated = $this->validated($request, $vacancy);

        // Re-slug only if the title actually changed.
        if ($validated['title'] !== $vacancy->title) {
            $validated['slug'] = Vacancy::uniqueSlug($validated['title'], $vacancy->id);
        }

        $vacancy->update($validated);

        return redirect()->route('vacancies.index')
            ->with('status', "Vacancy \"{$vacancy->title}\" updated.");
    }

    public function destroy(Vacancy $vacancy)
    {
        $title = $vacancy->title;
        $vacancy->delete();

        return response()->json(['message' => "Vacancy \"{$title}\" deleted."]);
    }

    /**
     * AJAX: quick open/close toggle from the list.
     */
    public function toggleStatus(Vacancy $vacancy)
    {
        $vacancy->update([
            'status' => $vacancy->status === 'open' ? 'closed' : 'open',
        ]);

        return response()->json([
            'message' => "Vacancy \"{$vacancy->title}\" is now {$vacancy->status}.",
            'status'  => $vacancy->status,
        ]);
    }

    protected function validated(Request $request, ?Vacancy $vacancy = null): array
    {
        return $request->validate([
            'title'        => ['required', 'string', 'max:150'],
            'department'   => ['nullable', 'string', 'max:100'],
            'location'     => ['nullable', 'string', 'max:150'],
            'type'         => ['required', 'string', 'in:' . implode(',', array_keys(Vacancy::TYPES))],
            'description'  => ['required', 'string'],
            'requirements' => ['nullable', 'string'],
            'salary_min'   => ['nullable', 'integer', 'min:0'],
            'salary_max'   => ['nullable', 'integer', 'min:0', 'gte:salary_min'],
            'status'       => ['required', 'string', 'in:open,closed'],
            'deadline'     => ['nullable', 'date'],
        ]);
    }
}