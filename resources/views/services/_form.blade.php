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

    {{-- ============== Service Details Page ============== --}}

    <div class="col-12">
        <hr class="my-3">
        <h5 class="mb-3">Service Details Page</h5>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Detail Image <span class="text-muted small">(large image at top of the details page)</span></label>
        @if($isEdit && $service->detail_image_url)
            <div class="mb-2">
                <img src="{{ $service->detail_image_url }}" style="max-height:100px;" class="rounded">
            </div>
        @endif
        <input type="file" name="detail_image" class="form-control" accept="image/*">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Planning Image <span class="text-muted small">(Implementation Planning section)</span></label>
        @if($isEdit && $service->planning_image_url)
            <div class="mb-2">
                <img src="{{ $service->planning_image_url }}" style="max-height:100px;" class="rounded">
            </div>
        @endif
        <input type="file" name="planning_image" class="form-control" accept="image/*">
    </div>

    <div class="col-12 mb-3">
        <label class="form-label">Main Content <span class="text-muted small">(paragraphs shown under the detail image)</span></label>
        <textarea name="content" rows="5" class="form-control">{{ old('content', $isEdit ? $service->content : '') }}</textarea>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Planning Heading</label>
        <input type="text" name="planning_heading" class="form-control" placeholder="Implementation Planning:"
               value="{{ old('planning_heading', $isEdit ? $service->planning_heading : '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Execution Heading</label>
        <input type="text" name="execution_heading" class="form-control" placeholder="Execution and Monitoring:"
               value="{{ old('execution_heading', $isEdit ? $service->execution_heading : '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Planning Text</label>
        <textarea name="planning_text" rows="4" class="form-control">{{ old('planning_text', $isEdit ? $service->planning_text : '') }}</textarea>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Execution Text</label>
        <textarea name="execution_text" rows="4" class="form-control">{{ old('execution_text', $isEdit ? $service->execution_text : '') }}</textarea>
    </div>

    <div class="col-12">
        <hr class="my-3">
        <h5 class="mb-3">Sidebar Brochure Downloads</h5>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Brochure PDF</label>
        @if($isEdit && $service->brochure_pdf_url)
            <div class="mb-2"><a href="{{ $service->brochure_pdf_url }}" target="_blank">Current PDF</a></div>
        @endif
        <input type="file" name="brochure_pdf" class="form-control" accept="application/pdf">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Brochure DOC/DOCX</label>
        @if($isEdit && $service->brochure_doc_url)
            <div class="mb-2"><a href="{{ $service->brochure_doc_url }}" target="_blank">Current DOC</a></div>
        @endif
        <input type="file" name="brochure_doc" class="form-control" accept=".doc,.docx">
    </div>

</div>