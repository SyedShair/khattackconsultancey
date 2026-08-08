@extends('layouts.admin')

@section('title', 'Contact Messages')
@section('page_title', 'Contact Messages')

@section('breadcrumb')
    <li class="breadcrumb-item active">Contact Messages</li>
@endsection

@section('content')

    <div class="card">

        <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">

            <div class="d-flex gap-2 flex-wrap">
                <input type="text" id="searchInput" class="form-control form-control-sm"
                       placeholder="Search name, email, subject..." style="width: 240px;">

                <select id="statusFilter" class="form-select form-select-sm" style="width: 150px;">
                    <option value="">All statuses</option>
                    @foreach(\App\Models\ContactMessage::STATUSES as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="card-body p-0 position-relative">

            <div id="tableLoading" class="text-center py-5 d-none">
                <div class="spinner-border text-primary"></div>
            </div>

            <table class="table table-hover mb-0" id="messagesTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Received</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody id="messagesTableBody"></tbody>
            </table>

            <div class="text-center text-muted py-4 d-none" id="emptyState">No messages found.</div>

        </div>

        <div class="card-footer">
            <nav>
                <ul class="pagination pagination-sm mb-0 justify-content-end" id="pagination"></ul>
            </nav>
        </div>

    </div>


    <!-- =========================
         MESSAGE DETAIL MODAL
    ========================== -->
    <div class="modal fade" id="messageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Message Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <dl class="row mb-0">
                        <dt class="col-4">Name</dt>
                        <dd class="col-8" id="dName"></dd>

                        <dt class="col-4">Email</dt>
                        <dd class="col-8"><a id="dEmail" href="#"></a></dd>

                        <dt class="col-4">Phone</dt>
                        <dd class="col-8" id="dPhone"></dd>

                        <dt class="col-4">Subject</dt>
                        <dd class="col-8" id="dSubject"></dd>

                        <dt class="col-4">Received</dt>
                        <dd class="col-8" id="dReceivedAt"></dd>

                        <dt class="col-4">Message</dt>
                        <dd class="col-8" id="dMessage" style="white-space: pre-line;"></dd>
                    </dl>
                </div>

                <div class="modal-footer">
                    <select id="statusSelect" class="form-select form-select-sm w-auto">
                        @foreach(\App\Models\ContactMessage::STATUSES as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-primary btn-sm" id="btnSaveStatus">Update Status</button>
                    <button type="button" class="btn btn-outline-danger btn-sm" id="btnDeleteFromModal">Delete</button>
                </div>

            </div>
        </div>
    </div>


    <!-- =========================
         DELETE CONFIRMATION MODAL
    ========================== -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle text-danger me-1"></i> Delete Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this message? This cannot be undone.
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
<script>
(function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const routes = {
        data: "{{ route('contact-messages.data') }}",
        show: id => `{{ url('admin/contact-messages') }}/${id}`,
        updateStatus: id => `{{ url('admin/contact-messages') }}/${id}/status`,
        destroy: id => `{{ url('admin/contact-messages') }}/${id}`,
    };

    const tableBody = document.getElementById('messagesTableBody');
    const tableLoading = document.getElementById('tableLoading');
    const emptyState = document.getElementById('emptyState');
    const pagination = document.getElementById('pagination');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');

    const messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    let activeMessageId = null;
    let pendingDeleteId = null;

    let searchTimer = null;
    let currentPage = 1;

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

    function statusBadge(status) {
        const map = { new: 'primary', read: 'secondary', replied: 'success' };
        return `<span class="badge text-bg-${map[status] ?? 'secondary'}">${status}</span>`;
    }

    function loadMessages(page = 1) {
        currentPage = page;
        tableLoading.classList.remove('d-none');
        emptyState.classList.add('d-none');

        const params = new URLSearchParams({
            page,
            search: searchInput.value,
            status: statusFilter.value,
        });

        fetch(`${routes.data}?${params.toString()}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        })
            .then(res => res.json())
            .then(payload => {
                tableBody.innerHTML = '';

                if (payload.data.length === 0) {
                    emptyState.classList.remove('d-none');
                } else {
                    payload.data.forEach(m => {
                        const rowClass = m.status === 'new' ? 'fw-semibold' : '';
                        tableBody.insertAdjacentHTML('beforeend', `
                            <tr class="${rowClass}">
                                <td>${m.name}</td>
                                <td>${m.email}</td>
                                <td>${m.phone ?? '—'}</td>
                                <td>${m.subject}</td>
                                <td>${statusBadge(m.status)}</td>
                                <td>${m.created_at}</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary btn-view" data-id="${m.id}" title="View">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${m.id}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                }

                renderPagination(payload);
            })
            .catch(() => showToast('Could not load messages.', 'error'))
            .finally(() => tableLoading.classList.add('d-none'));
    }

    function renderPagination(payload) {
        pagination.innerHTML = '';
        if (!payload.last_page || payload.last_page <= 1) return;

        for (let p = 1; p <= payload.last_page; p++) {
            const active = p === payload.current_page ? 'active' : '';
            pagination.insertAdjacentHTML('beforeend', `
                <li class="page-item ${active}">
                    <a class="page-link" href="#" data-page="${p}">${p}</a>
                </li>
            `);
        }
    }

    pagination.addEventListener('click', e => {
        e.preventDefault();
        const page = e.target.closest('[data-page]')?.dataset.page;
        if (page) loadMessages(Number(page));
    });

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => loadMessages(1), 350);
    });
    statusFilter.addEventListener('change', () => loadMessages(1));

    tableBody.addEventListener('click', e => {
        const viewBtn = e.target.closest('.btn-view');
        const delBtn = e.target.closest('.btn-delete');

        if (viewBtn) {
            const id = viewBtn.dataset.id;
            fetch(routes.show(id), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.json())
                .then(m => {
                    activeMessageId = m.id;
                    document.getElementById('dName').textContent = m.name;
                    document.getElementById('dEmail').textContent = m.email;
                    document.getElementById('dEmail').href = `mailto:${m.email}`;
                    document.getElementById('dPhone').textContent = m.phone || '—';
                    document.getElementById('dSubject').textContent = m.subject || '—';
                    document.getElementById('dReceivedAt').textContent = m.created_at;
                    document.getElementById('dMessage').textContent = m.message;
                    document.getElementById('statusSelect').value = m.status;
                    messageModal.show();
                    loadMessages(currentPage); // refresh badges since viewing marks "new" as "read"
                });
        }

        if (delBtn) {
            pendingDeleteId = delBtn.dataset.id;
            deleteModal.show();
        }
    });

    document.getElementById('btnSaveStatus').addEventListener('click', () => {
        if (!activeMessageId) return;
        const status = document.getElementById('statusSelect').value;

        fetch(routes.updateStatus(activeMessageId), {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ status }),
        })
            .then(res => res.json())
            .then(payload => {
                messageModal.hide();
                showToast(payload.message ?? 'Status updated.', 'success');
                loadMessages(currentPage);
            })
            .catch(() => showToast('Could not update status.', 'error'));
    });

    document.getElementById('btnDeleteFromModal').addEventListener('click', () => {
        if (!activeMessageId) return;
        pendingDeleteId = activeMessageId;
        messageModal.hide();
        deleteModal.show();
    });

    document.getElementById('btnConfirmDelete').addEventListener('click', () => {
        if (!pendingDeleteId) return;
        const btn = document.getElementById('btnConfirmDelete');
        const spinner = document.getElementById('deleteSpinner');
        btn.disabled = true;
        spinner.classList.remove('d-none');

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
                showToast(payload.message ?? 'Message deleted.', 'success');
                loadMessages(currentPage);
            })
            .catch(err => showToast(err.message ?? 'Could not delete message.', 'error'))
            .finally(() => {
                btn.disabled = false;
                spinner.classList.add('d-none');
                pendingDeleteId = null;
            });
    });

    loadMessages();
})();
</script>
@endpush