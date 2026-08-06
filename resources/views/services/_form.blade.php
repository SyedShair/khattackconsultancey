@php
    $isEdit = isset($service);
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
               value="{{ old('title', $isEdit ? $service->title : '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Link <span class="text-muted small">(optional)</span></label>
        <input type="text" name="link" class="form-control" placeholder="e.g. #tb__service or https://..."
               value="{{ old('link', $isEdit ? $service->link : '') }}">
        <div class="form-text">Leave blank to link back to the services section (#tb__service).</div>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label d-block">Status</label>
        <div class="form-check form-switch pt-2">
            <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1"
                   {{ old('is_active', $isEdit ? $service->is_active : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active (shown on homepage)</label>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Icon</label>
        @if($isEdit && $service->icon_url)
            <div class="mb-2">
                <img src="{{ $service->icon_url }}" style="width:60px;height:60px;object-fit:contain;">
            </div>
        @endif
        <input type="file" name="icon" class="form-control" accept="image/*">
        <div class="form-text">PNG/SVG works best for a crisp icon.</div>
    </div>

    <div class="col-12 mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" rows="3" class="form-control">{{ old('description', $isEdit ? $service->description : '') }}</textarea>
    </div>

</div>