@extends('layouts.admin')

@section('title', 'Consultation Bookings')
@section('page_title', 'Consultation Bookings')

@section('breadcrumb')
    <li class="breadcrumb-item active">Consultation Bookings</li>
@endsection

@section('content')

    <div class="card">

        <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">
            <div class="d-flex gap-2 flex-wrap">
                <input type="text" id="searchInput" class="form-control form-control-sm"
                       placeholder="Search name, email, phone..." style="width: 240px;">

                <select id="statusFilter" class="form-select form-select-sm" style="width: 150px;">
                    <option value="">All statuses</option>
                    @foreach(\App\Models\ConsultationBooking::STATUSES as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-body p-0 position-relative">

            <div id="tableLoading" class="text-center py-5 d-none">
                <div class="spinner-border text-primary"></div>
            </div>

            <table class="table table-hover mb-0" id="bookingsTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Query</th>
                        <th>Slot</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody id="bookingsTableBody"></tbody>
            </table>

            <div class="text-center text-muted py-4 d-none" id="emptyState">No bookings found.</div>

        </div>

        <div class="card-footer">
            <nav>
                <ul class="pagination pagination-sm mb-0 justify-content-end" id="pagination"></ul>
            </nav>
        </div>

    </div>


    <!-- =========================
         BOOKING DETAIL MODAL
    ========================== -->
    <div class="modal fade" id="bookingModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Booking Details</h5>
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

                        <dt class="col-4">Slot</dt>
                        <dd class="col-8" id="dSlot"></dd>

                        <dt class="col-4">Query</dt>
                        <dd class="col-8" id="dQuery" style="white-space: pre-line;"></dd>
                    </dl>
                </div>

                <div class="modal-footer">
                    <select id="statusSelect" class="form-select form-select-sm w-auto">
                        @foreach(\App\Models\ConsultationBooking::STATUSES as $key => $label)
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
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle text-danger me-1"></i> Delete Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">Are you sure you want to delete this booking? This cannot be undone.</div>
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
        data: "{{ route('consultation-bookings.data') }}",
        show: id => `{{ url('admin/consultation-bookings') }}/${id}`,
        updateStatus: id => `{{ url('admin/consultation-bookings') }}/${id}/status`,
        destroy: id => `{{ url('admin/consultation-bookings') }}/${id}`,
    };

    const tableBody = document.getElementById('bookingsTableBody');
    const tableLoading = document.getElementById('tableLoading');
    const emptyState = document.getElementById('emptyState');
    const pagination = document.getElementById('pagination');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');

    const bookingModal = new bootstrap.Modal(document.getElementById('bookingModal'));
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    let activeId = null;
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
        const map = { confirmed: 'success', cancelled: 'danger', completed: 'secondary' };
        return `<span class="badge text-bg-${map[status] ?? 'secondary'}">${status}</span>`;
    }

    function loadBookings(page = 1) {
        currentPage = page;
        tableLoading.classList.remove('d-none');
        emptyState.classList.add('d-none');

        const params = new URLSearchParams({ page, search: searchInput.value, status: statusFilter.value });

        fetch(`${routes.data}?${params.toString()}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.json())
            .then(payload => {
                tableBody.innerHTML = '';

                if (payload.data.length === 0) {
                    emptyState.classList.remove('d-none');
                } else {
                    payload.data.forEach(b => {
                        tableBody.insertAdjacentHTML('beforeend', `
                            <tr>
                                <td>${b.name}</td>
                                <td>${b.email}</td>
                                <td>${b.phone}</td>
                                <td>${b.query}</td>
                                <td>${b.slot}</td>
                                <td>${statusBadge(b.status)}</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary btn-view" data-id="${b.id}" title="View">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${b.id}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                }

                renderPagination(payload);
            })
            .catch(() => showToast('Could not load bookings.', 'error'))
            .finally(() => tableLoading.classList.add('d-none'));
    }

    function renderPagination(payload) {
        pagination.innerHTML = '';
        if (!payload.last_page || payload.last_page <= 1) return;

        for (let p = 1; p <= payload.last_page; p++) {
            const active = p === payload.current_page ? 'active' : '';
            pagination.insertAdjacentHTML('beforeend', `
                <li class="page-item ${active}"><a class="page-link" href="#" data-page="${p}">${p}</a></li>
            `);
        }
    }

    pagination.addEventListener('click', e => {
        e.preventDefault();
        const page = e.target.closest('[data-page]')?.dataset.page;
        if (page) loadBookings(Number(page));
    });

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => loadBookings(1), 350);
    });
    statusFilter.addEventListener('change', () => loadBookings(1));

    tableBody.addEventListener('click', e => {
        const viewBtn = e.target.closest('.btn-view');
        const delBtn = e.target.closest('.btn-delete');

        if (viewBtn) {
            const id = viewBtn.dataset.id;
            fetch(routes.show(id), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.json())
                .then(b => {
                    activeId = b.id;
                    document.getElementById('dName').textContent = b.name;
                    document.getElementById('dEmail').textContent = b.email;
                    document.getElementById('dEmail').href = `mailto:${b.email}`;
                    document.getElementById('dPhone').textContent = b.phone;
                    document.getElementById('dSlot').textContent = b.slot;
                    document.getElementById('dQuery').textContent = b.query || '—';
                    document.getElementById('statusSelect').value = b.status;
                    bookingModal.show();
                });
        }

        if (delBtn) {
            pendingDeleteId = delBtn.dataset.id;
            deleteModal.show();
        }
    });

    document.getElementById('btnSaveStatus').addEventListener('click', () => {
        if (!activeId) return;
        const status = document.getElementById('statusSelect').value;

        fetch(routes.updateStatus(activeId), {
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
                bookingModal.hide();
                showToast(payload.message ?? 'Status updated.', 'success');
                loadBookings(currentPage);
            })
            .catch(() => showToast('Could not update status.', 'error'));
    });

    document.getElementById('btnDeleteFromModal').addEventListener('click', () => {
        if (!activeId) return;
        pendingDeleteId = activeId;
        bookingModal.hide();
        deleteModal.show();
    });

    document.getElementById('btnConfirmDelete').addEventListener('click', () => {
        if (!pendingDeleteId) return;
        const btn = document.getElementById('btnConfirmDelete');
        const spinner = btn.querySelector('.spinner-border');
        btn.disabled = true;
        spinner.classList.remove('d-none');

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
                showToast(payload.message ?? 'Booking deleted.', 'success');
                loadBookings(currentPage);
            })
            .catch(err => showToast(err.message ?? 'Could not delete booking.', 'error'))
            .finally(() => {
                btn.disabled = false;
                spinner.classList.add('d-none');
                pendingDeleteId = null;
            });
    });

    loadBookings();
})();
</script>
@endpush