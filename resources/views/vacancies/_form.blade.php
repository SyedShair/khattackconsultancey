@php
    $isEdit = isset($vacancy);
@endphp

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Job Title</label>
        <input type="text" name="title" class="form-control"
               value="{{ old('title', $isEdit ? $vacancy->title : '') }}" required>
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label">Department</label>
        <input type="text" name="department" class="form-control"
               value="{{ old('department', $isEdit ? $vacancy->department : '') }}">
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control"
               placeholder="e.g. Peshawar / Remote"
               value="{{ old('location', $isEdit ? $vacancy->location : '') }}">
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label">Employment Type</label>
        <select name="type" class="form-select">
            @foreach(\App\Models\Vacancy::TYPES as $key => $label)
                <option value="{{ $key }}"
                    {{ old('type', $isEdit ? $vacancy->type : 'full-time') === $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="open" {{ old('status', $isEdit ? $vacancy->status : 'open') === 'open' ? 'selected' : '' }}>Open</option>
            <option value="closed" {{ old('status', $isEdit ? $vacancy->status : '') === 'closed' ? 'selected' : '' }}>Closed</option>
        </select>
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label">Salary Min</label>
        <input type="number" name="salary_min" class="form-control" min="0"
               value="{{ old('salary_min', $isEdit ? $vacancy->salary_min : '') }}">
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label">Salary Max</label>
        <input type="number" name="salary_max" class="form-control" min="0"
               value="{{ old('salary_max', $isEdit ? $vacancy->salary_max : '') }}">
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label">Application Deadline</label>
        <input type="date" name="deadline" class="form-control"
               value="{{ old('deadline', $isEdit && $vacancy->deadline ? $vacancy->deadline->format('Y-m-d') : '') }}">
    </div>

    <div class="col-12 mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" rows="6" class="form-control" required>{{ old('description', $isEdit ? $vacancy->description : '') }}</textarea>
    </div>

    <div class="col-12 mb-3">
        <label class="form-label">Requirements <span class="text-muted small">(one per line)</span></label>
        <textarea name="requirements" rows="5" class="form-control">{{ old('requirements', $isEdit ? $vacancy->requirements : '') }}</textarea>
    </div>

</div>