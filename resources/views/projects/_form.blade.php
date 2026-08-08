@php
    $isEdit = isset($project);
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
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control"
               value="{{ old('title', $isEdit ? $project->title : '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Link <span class="text-muted small">(optional)</span></label>
        <input type="text" name="link" class="form-control" placeholder="e.g. https://..."
               value="{{ old('link', $isEdit ? $project->link : '') }}">
        <div class="form-text">Leave blank to link to nothing (#).</div>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label d-block">Status</label>
        <div class="form-check form-switch pt-2">
            <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1"
                   {{ old('is_active', $isEdit ? $project->is_active : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active (shown on homepage)</label>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Image</label>
        @if($isEdit && $project->image_url)
            <div class="mb-2">
                <img src="{{ $project->image_url }}" style="max-width:100%;max-height:140px;object-fit:cover;border-radius:8px;">
            </div>
        @endif
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>

</div>
