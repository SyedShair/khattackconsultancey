@extends('layouts.admin')

@section('title', 'Team Members')
@section('page_title', 'Team Members')

@section('breadcrumb')
    <li class="breadcrumb-item active">Team Members</li>
@endsection

@section('content')

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="text-muted small">Drag rows to reorder — the order here is the order shown on the homepage team slider.</span>
            <a href="{{ route('team-members.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg"></i> New Member
            </a>
        </div>

        <div class="card-body p-0">

            @if(session('status'))
                <div class="alert alert-success m-3">{{ session('status') }}</div>
            @endif

            @if($members->isEmpty())
                <div class="text-center text-muted py-5">No team members yet. Add your first one.</div>
            @else
                <table class="table table-hover mb-0" id="membersTable">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th style="width: 70px;">Photo</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Active</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="membersTableBody">
                        @foreach($members as $member)
                            <tr data-id="{{ $member->id }}">
                                <td class="drag-handle text-muted" style="cursor: grab;">
                                    <i class="bi bi-grip-vertical"></i>
                                </td>
                                <td>
                                    @if($member->photo_url)
                                        <img src="{{ $member->photo_url }}" style="width:44px;height:44px;object-fit:cover;border-radius:50%;">
                                    @else
                                        <div class="bg-secondary-subtle rounded-circle" style="width:44px;height:44px;"></div>
                                    @endif
                                </td>
                                <td class="fw-semibold">{{ $member->name }}</td>
                                <td>{{ $member->designation ?? '—' }}</td>
                                <td>
                                    <button class="btn btn-sm p-0 border-0 btn-toggle-active" data-id="{{ $member->id }}" title="Click to toggle">
                                        @if($member->is_active)
                                            <span class="badge text-bg-success">active</span>
                                        @else
                                            <span class="badge text-bg-secondary">inactive</span>
                                        @endif
                                    </button>
                                </td>
                                <td class="text-end">
                                    <a class="btn btn-sm btn-outline-primary" href="{{ route('team-members.edit', $member) }}" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger btn-delete" data-id="{{ $member->id }}" data-name="{{ $member->name }}" title="Delete">
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
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle text-danger me-1"></i> Delete Team Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete <strong id="deleteMemberName"></strong>? This cannot be undone.
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
(function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const routes = {
        toggleActive: id => `{{ url('admin/team-members') }}/${id}/toggle-active`,
        destroy: id => `{{ url('admin/team-members') }}/${id}`,
        reorder: `{{ route('team-members.reorder') }}`,
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
    const tableBody = document.getElementById('membersTableBody');
    if (tableBody && window.Sortable) {
        Sortable.create(tableBody, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function () {
                const order = Array.from(tableBody.querySelectorAll('tr')).map(tr => tr.dataset.id);

                fetch(routes.reorder, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
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
            this.disabled = true;

            fetch(routes.toggleActive(id), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            })
                .then(res => res.json())
                .then(payload => {
                    this.innerHTML = payload.is_active
                        ? '<span class="badge text-bg-success">active</span>'
                        : '<span class="badge text-bg-secondary">inactive</span>';
                    showToast(payload.message, 'success');
                })
                .catch(() => showToast('Could not update status.', 'error'))
                .finally(() => this.disabled = false);
        });
    });

    // ── Delete (modal + toast) ──────────────────────────────────────
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteMemberName = document.getElementById('deleteMemberName');
    const btnConfirmDelete = document.getElementById('btnConfirmDelete');
    const deleteSpinner = document.getElementById('deleteSpinner');
    let pendingDeleteId = null;

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            pendingDeleteId = this.dataset.id;
            deleteMemberName.textContent = this.dataset.name;
            deleteModal.show();
        });
    });

    btnConfirmDelete.addEventListener('click', () => {
        if (!pendingDeleteId) return;
        btnConfirmDelete.disabled = true;
        deleteSpinner.classList.remove('d-none');

        fetch(routes.destroy(pendingDeleteId), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        })
            .then(async res => {
                const payload = await res.json();
                if (!res.ok) throw payload;
                return payload;
            })
            .then(payload => {
                deleteModal.hide();
                showToast(payload.message ?? 'Team member deleted.', 'success');
                document.querySelector(`tr[data-id="${pendingDeleteId}"]`)?.remove();
            })
            .catch(err => showToast(err.message ?? 'Could not delete team member.', 'error'))
            .finally(() => {
                btnConfirmDelete.disabled = false;
                deleteSpinner.classList.add('d-none');
                pendingDeleteId = null;
            });
    });
})();
</script>
@endpush