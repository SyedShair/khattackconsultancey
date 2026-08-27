@extends('layouts.admin')

@section('title', 'Services')
@section('page_title', 'Services')

@section('breadcrumb')
    <li class="breadcrumb-item active">Services</li>
@endsection

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">All Services</h3>
        <a href="{{ route('services.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Add Service
        </a>
    </div>

    <div class="card-body">
        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <p class="text-muted small mb-2">Drag rows by the handle to reorder — the order here is the order services appear on the homepage.</p>

        <table class="table table-striped align-middle" id="servicesTable">
            <thead>
                <tr>
                    <th style="width:40px;"></th>
                    <th style="width:70px;">Icon</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th style="width:100px;">Active</th>
                    <th style="width:160px;" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody id="servicesSortable">
                @forelse($services as $service)
                <tr data-id="{{ $service->id }}">
                    <td class="drag-handle" style="cursor:grab;"><i class="bi bi-grip-vertical"></i></td>
                    <td>
                        @if($service->icon_url)
                            <img src="{{ $service->icon_url }}" alt="" style="width:40px;height:40px;object-fit:contain;">
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td>{{ $service->title }}</td>
                    <td><code>{{ $service->slug ?? '—' }}</code></td>
                    <td>
                        <button type="button"
                                class="btn btn-sm toggle-active-btn {{ $service->is_active ? 'btn-success' : 'btn-outline-secondary' }}"
                                data-url="{{ route('services.toggleActive', $service) }}">
                            {{ $service->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn"
                                data-url="{{ route('services.destroy', $service) }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No services yet.</td></tr>
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
    const el = document.getElementById('servicesSortable');
    if (el) {
        Sortable.create(el, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function () {
                const order = $(el).find('tr').map(function () {
                    return $(this).data('id');
                }).get();

                $.post('{{ route('services.reorder') }}', { order });
            }
        });
    }

    // active/inactive toggle (controller returns { message, is_active })
    $('.toggle-active-btn').on('click', function () {
        const btn = $(this);
        $.post(btn.data('url')).done(function (res) {
            btn.text(res.is_active ? 'Active' : 'Inactive')
               .toggleClass('btn-success', res.is_active)
               .toggleClass('btn-outline-secondary', !res.is_active);
        });
    });

    // delete (controller destroy() returns JSON, not a redirect, so this
    // needs an AJAX DELETE rather than a plain form submit)
    $('.delete-btn').on('click', function () {
        if (!confirm('Delete this service? This cannot be undone.')) return;

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