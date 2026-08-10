@php
    $isEdit = isset($plan);
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
        <label class="form-label">Plan Title</label>
        <input type="text" name="title" class="form-control" placeholder="e.g. BASIC PLAN"
               value="{{ old('title', $isEdit ? $plan->title : '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Subtitle</label>
        <input type="text" name="subtitle" class="form-control" placeholder="e.g. Small Business"
               value="{{ old('subtitle', $isEdit ? $plan->subtitle : '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Monthly Price</label>
        <div class="input-group">
            <span class="input-group-text">$</span>
            <input type="number" step="0.01" min="0" name="price_monthly" class="form-control"
                   value="{{ old('price_monthly', $isEdit ? $plan->price_monthly : '') }}" required>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Yearly Price <span class="text-muted small">(optional)</span></label>
        <div class="input-group">
            <span class="input-group-text">$</span>
            <input type="number" step="0.01" min="0" name="price_yearly" class="form-control"
                   value="{{ old('price_yearly', $isEdit ? $plan->price_yearly : '') }}">
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Button Text</label>
        <input type="text" name="button_text" class="form-control"
               value="{{ old('button_text', $isEdit ? $plan->button_text : 'GET STARTED') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Button Link <span class="text-muted small">(optional)</span></label>
        <input type="text" name="button_link" class="form-control" placeholder="e.g. #tb__contact or https://..."
               value="{{ old('button_link', $isEdit ? $plan->button_link : '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <div class="form-check form-switch pt-2">
            <input type="checkbox" class="form-check-input" name="is_popular" id="is_popular" value="1"
                   {{ old('is_popular', $isEdit ? $plan->is_popular : false) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_popular">Highlight as "Popular Plan"</label>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="form-check form-switch pt-2">
            <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1"
                   {{ old('is_active', $isEdit ? $plan->is_active : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active (shown on homepage)</label>
        </div>
    </div>

    <div class="col-12 mb-3">
        <label class="form-label">Features <span class="text-muted small">(one per line)</span></label>
        <textarea name="features" rows="6" class="form-control" placeholder="Initial Consultation&#10;Strategy Development&#10;Market Research">{{ old('features', $isEdit ? $plan->features : '') }}</textarea>
    </div>

</div>
