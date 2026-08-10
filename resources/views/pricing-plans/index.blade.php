@extends('layouts.admin')

@section('title', 'Pricing Plans')
@section('page_title', 'Pricing Plans')

@section('breadcrumb')
    <li class="breadcrumb-item active">Pricing Plans</li>
@endsection

@section('content')

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="text-muted small">Drag rows to reorder — the order here is the order shown on the homepage pricing section.</span>
            <a href="{{ route('pricing-plans.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg"></i> New Plan
            </a>
        </div>

        <div class="card-body p-0">

            @if(session('status'))
                <div class="alert alert-success m-3">{{ session('status') }}</div>
            @endif

            @if($plans->isEmpty())
                <div class="text-center text-muted py-5">No pricing plans yet. Add your first one.</div>
            @else
                <table class="table table-hover mb-0" id="plansTable">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th>Title</th>
                            <th>Monthly</th>
                            <th>Yearly</th>
                            <th>Popular</th>
                            <th>Active</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="plansTableBody">
                        @foreach($plans as $plan)
                            <tr data-id="{{ $plan->id }}" class="{{ ! $plan->is_active ? 'table-secondary text-muted' : '' }}">
                                <td class="drag-handle text-muted" style="cursor: grab;">
                                    <i class="bi bi-grip-vertical"></i>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $plan->title }}</div>
                                    <div class="text-muted small">{{ $plan->subtitle }}</div>
                                </td>
                                <td>${{ number_format($plan->price_monthly, 2) }}</td>
                                <td>{{ $plan->price_yearly ? '$' . number_format($plan->price_yearly, 2) : '—' }}</td>
                                <td>
                                    <button class="btn btn-sm p-0 border-0 btn-toggle-popular" data-id="{{ $plan->id }}" title="Click to toggle">
                                        @if($plan->is_popular)
                                            <span class="badge text-bg-warning">popular</span>
                                        @else
                                            <span class="badge text-bg-light border">—</span>
                                        @endif
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-sm p-0 border-0 btn-toggle-active" data-id="{{ $plan->id }}" title="Click to toggle">
                                        @if($plan->is_active)
                                            <span class="badge text-bg-success">active</span>
                                        @else
                                            <span class="badge text-bg-secondary">inactive</span>
                                        @endif
                                    </button>
                                </td>
                                <td class="text-end">
                                    <a class="btn btn-sm btn-outline-primary" href="{{ route('pricing-plans.edit', $plan) }}" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger btn-delete" data-id="{{ $plan->id }}" data-title="{{ $plan->title }}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>


    <!-- =========================
         DELETE CONFIRMATION MODAL
    ========================== -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle text-danger me-1"></i> Delete Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete <strong id="deletePlanTitle"></strong>? This cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmDelete">
                        <span class="spinner-border spinner-border-sm d-none" id="deleteSpinner"></span>
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1080;" id="toastContainer"></div>

@endsection

@push('styles')
<style>
    #plansTable tbody tr { transition: background-color .15s ease, opacity .15s ease; }
    #plansTable tbody tr.table-secondary { background-color: #f4f4f5 !important; opacity: .75; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
(function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const routes = {
        toggleActive: id => `{{ url('admin/pricing-plans') }}/${id}/toggle-active`,
        togglePopular: id => `{{ url('admin/pricing-plans') }}/${id}/toggle-popular`,
        destroy: id => `{{ url('admin/pricing-plans') }}/${id}`,
        reorder: `{{ route('pricing-plans.reorder') }}`,
    };

    function showToast(message, type = 'success') {
        const colors = { success: 'text-bg-success', error: 'text-bg-danger', info: 'text-bg-primary' };
        const icons = { success: 'bi-check-circle', error: 'bi-x-circle', info: 'bi-info-circle' };
        const toastEl = document.createElement('div');
        toastEl.className = `toast align-items-center ${colors[type] ?? colors.info} border-0`;
        toastEl.setAttribute('role', 'alert');
        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body"><i class="bi ${icons[type] ?? icons.info} me-2"></i>${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>`;
        document.getElementById('toastContainer').appendChild(toastEl);
        const toast = new bootstrap.Toast(toastEl, { delay: 3500 });
        toast.show();
        toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
    }

    // ── Drag & drop reorder ─────────────────────────────────────────
    const tableBody = document.getElementById('plansTableBody');
    if (tableBody && window.Sortable) {
        Sortable.create(tableBody, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function () {
                const order = Array.from(tableBody.querySelectorAll('tr')).map(tr => tr.dataset.id);
                fetch(routes.reorder, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json', 'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ order }),
                })
                    .then(res => res.json())
                    .then(() => showToast('Order updated.', 'success'))
                    .catch(() => showToast('Could not save the new order.', 'error'));
            },
        });
    }

    // ── Active toggle ───────────────────────────────────────────────
    document.querySelectorAll('.btn-toggle-active').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const row = this.closest('tr');
            this.disabled = true;

            fetch(routes.toggleActive(id), {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            })
                .then(res => res.json())
                .then(payload => {
                    this.innerHTML = payload.is_active
                        ? '<span class="badge text-bg-success">active</span>'
                        : '<span class="badge text-bg-secondary">inactive</span>';
                    row.classList.toggle('table-secondary', !payload.is_active);
                    row.classList.toggle('text-muted', !payload.is_active);
                    showToast(payload.message, 'success');
                })
                .catch(() => showToast('Could not update status.', 'error'))
                .finally(() => this.disabled = false);
        });
    });

    // ── Popular toggle ──────────────────────────────────────────────
    document.querySelectorAll('.btn-toggle-popular').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            this.disabled = true;

            fetch(routes.togglePopular(id), {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            })
                .then(res => res.json())
                .then(payload => {
                    this.innerHTML = payload.is_popular
                        ? '<span class="badge text-bg-warning">popular</span>'
                        : '<span class="badge text-bg-light border">—</span>';
                    showToast(payload.message, 'success');
                })
                .catch(() => showToast('Could not update.', 'error'))
                .finally(() => this.disabled = false);
        });
    });

    // ── Delete (modal + toast) ──────────────────────────────────────
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deletePlanTitle = document.getElementById('deletePlanTitle');
    const btnConfirmDelete = document.getElementById('btnConfirmDelete');
    const deleteSpinner = document.getElementById('deleteSpinner');
    let pendingDeleteId = null;

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            pendingDeleteId = this.dataset.id;
            deletePlanTitle.textContent = this.dataset.title;
            deleteModal.show();
        });
    });

    btnConfirmDelete.addEventListener('click', () => {
        if (!pendingDeleteId) return;
        btnConfirmDelete.disabled = true;
        deleteSpinner.classList.remove('d-none');

        fetch(routes.destroy(pendingDeleteId), {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        })
            .then(async res => {
                const payload = await res.json();
                if (!res.ok) throw payload;
                return payload;
            })
            .then(payload => {
                deleteModal.hide();
                showToast(payload.message ?? 'Plan deleted.', 'success');
                document.querySelector(`tr[data-id="${pendingDeleteId}"]`)?.remove();
            })
            .catch(err => showToast(err.message ?? 'Could not delete plan.', 'error'))
            .finally(() => {
                btnConfirmDelete.disabled = false;
                deleteSpinner.classList.add('d-none');
                pendingDeleteId = null;
            });
    });
})();
</script>
@endpush
