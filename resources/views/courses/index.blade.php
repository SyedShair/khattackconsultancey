@extends('layouts.admin')

@section('title', 'Courses')
@section('page_title', 'Courses')

@section('breadcrumb')
    <li class="breadcrumb-item active">Courses</li>
@endsection

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">All Courses</h3>
        <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Add Course
        </a>
    </div>

    <div class="card-body">
        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <p class="text-muted small mb-2">Drag rows by the handle to reorder — this is the order courses appear on the website and in the COURSES menu.</p>

        <table class="table table-striped align-middle" id="coursesTable">
            <thead>
                <tr>
                    <th style="width:40px;"></th>
                    <th style="width:90px;">Image</th>
                    <th>Title</th>
                    <th style="width:130px;">Sub-courses</th>
                    <th style="width:100px;">Active</th>
                    <th style="width:160px;" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody id="coursesSortable">
                @forelse($courses as $course)
                <tr data-id="{{ $course->id }}">
                    <td class="drag-handle" style="cursor:grab;"><i class="bi bi-grip-vertical"></i></td>
                    <td>
                        @if($course->image_url)
                            <img src="{{ $course->image_url }}" alt="" style="width:70px;height:48px;object-fit:cover;" class="rounded">
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td>
                        {{ $course->title }}
                        <div><code class="small">{{ $course->slug }}</code></div>
                    </td>
                    <td><span class="badge text-bg-secondary">{{ $course->items_count }}</span></td>
                    <td>
                        <button type="button"
                                class="btn btn-sm toggle-active-btn {{ $course->is_active ? 'btn-success' : 'btn-outline-secondary' }}"
                                data-url="{{ route('courses.toggleActive', $course) }}">
                            {{ $course->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn"
                                data-url="{{ route('courses.destroy', $course) }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No courses yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
$(function () {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrfToken } });

    // drag-to-reorder
    const el = document.getElementById('coursesSortable');
    if (el) {
        Sortable.create(el, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function () {
                const order = $(el).find('tr').map(function () {
                    return $(this).data('id');
                }).get();

                $.post('{{ route('courses.reorder') }}', { order });
            }
        });
    }

    // active/inactive toggle
    $('.toggle-active-btn').on('click', function () {
        const btn = $(this);
        $.post(btn.data('url')).done(function (res) {
            btn.text(res.is_active ? 'Active' : 'Inactive')
               .toggleClass('btn-success', res.is_active)
               .toggleClass('btn-outline-secondary', !res.is_active);
        });
    });

    // delete (controller returns JSON)
    $('.delete-btn').on('click', function () {
        if (!confirm('Delete this course and all its sub-courses? This cannot be undone.')) return;

        const row = $(this).closest('tr');
        $.ajax({
            url: $(this).data('url'),
            type: 'POST',
            data: { _method: 'DELETE' }
        }).done(function () {
            row.remove();
        });
    });
});
</script>
@endpush
