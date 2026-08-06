@php
    $isEdit = isset($slide);
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
               value="{{ old('title', $isEdit ? $slide->title : '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Button Text</label>
        <input type="text" name="button_text" class="form-control" placeholder="e.g. OUR ALL SERVICES"
               value="{{ old('button_text', $isEdit ? $slide->button_text : '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Button Link</label>
        <input type="text" name="button_link" class="form-control" placeholder="e.g. #tb__service or https://..."
               value="{{ old('button_link', $isEdit ? $slide->button_link : '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label d-block">Status</label>
        <div class="form-check form-switch pt-2">
            <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1"
                   {{ old('is_active', $isEdit ? $slide->is_active : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active (shown in slider)</label>
        </div>
    </div>

    <div class="col-12 mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" rows="3" class="form-control">{{ old('description', $isEdit ? $slide->description : '') }}</textarea>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Background Image</label>
        @if($isEdit && $slide->background_image_url)
            <div class="mb-2">
                <img src="{{ $slide->background_image_url }}" style="max-width:100%;max-height:120px;object-fit:cover;border-radius:8px;">
            </div>
        @endif
        <input type="file" name="background_image" class="form-control" accept="image/*">
        <div class="form-text">Full-width slide background. Recommended ~1920x900px.</div>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Foreground Image</label>
        @if($isEdit && $slide->image_url)
            <div class="mb-2">
                <img src="{{ $slide->image_url }}" style="max-width:100%;max-height:120px;object-fit:contain;">
            </div>
        @endif
        <input type="file" name="image" class="form-control" accept="image/*">
        <div class="form-text">The illustration/photo shown on the right side of the slide.</div>
    </div>

</div>