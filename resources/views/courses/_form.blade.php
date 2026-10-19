@php
    $isEdit = isset($course);

    // Rows to show: old input (after a validation error) or the saved sub-courses
    $existing = $isEdit ? $course->items->keyBy('id') : collect();

    $rows = old('items', $isEdit
        ? $course->items->map(fn ($i) => [
            'id' => $i->id,
            'title' => $i->title,
            'description' => $i->description,
        ])->all()
        : []);
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
        <label class="form-label">Course Title</label>
        <input type="text" name="title" class="form-control" placeholder="e.g. English"
               value="{{ old('title', $isEdit ? $course->title : '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label d-block">Status</label>
        <div class="form-check form-switch pt-2">
            <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1"
                   {{ old('is_active', $isEdit ? $course->is_active : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active (shown on website)</label>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Image</label>
        @if($isEdit && $course->image_url)
            <div class="mb-2">
                <img src="{{ $course->image_url }}" style="max-height:100px;" class="rounded">
            </div>
        @endif
        <input type="file" name="image" class="form-control" accept="image/*">
        <div class="form-text">Shown with the course on the website. Max 4 MB.</div>
    </div>

    <div class="col-12 mb-3">
        <label class="form-label">Detail <span class="text-muted small">(intro paragraph shown under the course title)</span></label>
        <textarea name="description" rows="4" class="form-control">{{ old('description', $isEdit ? $course->description : '') }}</textarea>
    </div>

    {{-- ============== Sub-courses ============== --}}
    <div class="col-12">
        <hr class="my-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="mb-0">Sub-courses</h5>
            <button type="button" class="btn btn-outline-primary btn-sm" id="addItemBtn">
                <i class="bi bi-plus-lg"></i> Add Sub-course
            </button>
        </div>
        <p class="text-muted small">e.g. under "English": ESOL Skills for Life, Functional Skills English. Drag to reorder. Each can have its own image. Rows with no title are ignored.</p>

        <div id="itemsWrapper">
            @foreach($rows as $i => $row)
                <div class="border rounded p-3 mb-2 item-row">
                    <input type="hidden" name="items[{{ $i }}][id]" value="{{ $row['id'] ?? '' }}">
                    <div class="row g-2 align-items-start">
                        <div class="col-auto pt-2 item-handle" style="cursor:grab;"><i class="bi bi-grip-vertical"></i></div>
                        <div class="col">
                            <input type="text" name="items[{{ $i }}][title]" class="form-control mb-2"
                                   placeholder="Sub-course title" value="{{ $row['title'] ?? '' }}">
                            <textarea name="items[{{ $i }}][description]" rows="2" class="form-control mb-2"
                                      placeholder="Short description (optional)">{{ $row['description'] ?? '' }}</textarea>

                            @php $img = !empty($row['id']) ? ($existing[$row['id']]->image_url ?? null) : null; @endphp
                            @if($img)
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <img src="{{ $img }}" style="height:60px;width:90px;object-fit:cover;" class="rounded">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="rm_{{ $i }}"
                                               name="items[{{ $i }}][remove_image]" value="1">
                                        <label class="form-check-label small" for="rm_{{ $i }}">Remove image</label>
                                    </div>
                                </div>
                            @endif
                            <input type="file" name="items[{{ $i }}][image]" class="form-control form-control-sm" accept="image/*">
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-item-btn"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>

<template id="itemTemplate">
    <div class="border rounded p-3 mb-2 item-row">
        <input type="hidden" name="items[__INDEX__][id]" value="">
        <div class="row g-2 align-items-start">
            <div class="col-auto pt-2 item-handle" style="cursor:grab;"><i class="bi bi-grip-vertical"></i></div>
            <div class="col">
                <input type="text" name="items[__INDEX__][title]" class="form-control mb-2" placeholder="Sub-course title">
                <textarea name="items[__INDEX__][description]" rows="2" class="form-control mb-2"
                          placeholder="Short description (optional)"></textarea>
                <input type="file" name="items[__INDEX__][image]" class="form-control form-control-sm" accept="image/*">
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-sm btn-outline-danger remove-item-btn"><i class="bi bi-trash"></i></button>
            </div>
        </div>
    </div>
</template>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const wrapper  = document.getElementById('itemsWrapper');
    const template = document.getElementById('itemTemplate').innerHTML;
    let counter    = wrapper.querySelectorAll('.item-row').length;

    document.getElementById('addItemBtn').addEventListener('click', function () {
        wrapper.insertAdjacentHTML('beforeend', template.replace(/__INDEX__/g, counter++));
    });

    wrapper.addEventListener('click', function (e) {
        const btn = e.target.closest('.remove-item-btn');
        if (btn) btn.closest('.item-row').remove();
    });

    // Rows are saved in the order they appear on screen
    Sortable.create(wrapper, { handle: '.item-handle', animation: 150 });
});
</script>
@endpush
