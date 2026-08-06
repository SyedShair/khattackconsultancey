@extends('layouts.admin')

@section('title', 'Vacancies')
@section('page_title', 'Vacancies')

@section('breadcrumb')
    <li class="breadcrumb-item active">Vacancies</li>
@endsection

@section('content')

    <div class="card">

        <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">

            <div class="d-flex gap-2">
                <input type="text" id="searchInput" class="form-control form-control-sm"
                       placeholder="Search title, department, location..." style="width: 260px;">

                <select id="statusFilter" class="form-select form-select-sm" style="width: 140px;">
                    <option value="">All statuses</option>
                    <option value="open">Open</option>
                    <option value="closed">Closed</option>
                </select>
            </div>

            <a href="{{ route('vacancies.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg"></i> New Vacancy
            </a>

        </div>

        <div class="card-body p-0 position-relative">

            @if(session('status'))
                <div class="alert alert-success m-3">{{ session('status') }}</div>
            @endif

            <div id="tableLoading" class="text-center py-5 d-none">
                <div class="spinner-border text-primary"></div>
            </div>

            <table class="table table-hover mb-0" id="vacanciesTable">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Department</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Deadline</th>
                        <th>Applicants</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody id="vacanciesTableBody"></tbody>
            </table>

            <div class="text-center text-muted py-4 d-none" id="emptyState">No vacancies found.</div>

        </div>

        <div class="card-footer">
            <nav>
                <ul class="pagination pagination-sm mb-0 justify-content-end" id="pagination"></ul>
            </nav>
        </div>

    </div>


    <!-- =========================
         DELETE CONFIRMATION MODAL
    ========================== -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle text-danger me-1"></i> Delete Vacancy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete <strong id="deleteVacancyTitle"></strong>?
                    <div class="text-muted small mt-1">This will also remove its link to any submitted applications. This cannot be undone.</div>
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


    <!-- =========================
         TOAST CONTAINER
    ========================== -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1080;" id="toastContainer"></div>

@endsection

@push('scripts')
<script>
(function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const routes = {
        data: "{{ route('vacancies.data') }}",
        destroy: id => `{{ url('admin/vacancies') }}/${id}`,
        toggleStatus: id => `{{ url('admin/vacancies') }}/${id}/toggle-status`,
    };

    const tableBody = document.getElementById('vacanciesTableBody');
    const tableLoading = document.getElementById('tableLoading');
    const emptyState = document.getElementById('emptyState');
    const pagination = document.getElementById('pagination');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');

    const deleteModalEl = document.getElementById('deleteModal');
    const deleteModal = new bootstrap.Modal(deleteModalEl);
    const deleteVacancyTitle = document.getElementById('deleteVacancyTitle');
    const btnConfirmDelete = document.getElementById('btnConfirmDelete');
    const deleteSpinner = document.getElementById('deleteSpinner');
    let pendingDeleteId = null;

    let searchTimer = null;
    let currentPage = 1;

    // ── Toast helper ────────────────────────────────────────────────
    function showToast(message, type = 'success') {
        const colors = {
            success: 'text-bg-success',
            error: 'text-bg-danger',
            info: 'text-bg-primary',
        };
        const icons = {
            success: 'bi-check-circle',
            error: 'bi-x-circle',
            info: 'bi-info-circle',
        };

        const toastEl = document.createElement('div');
        toastEl.className = `toast align-items-center ${colors[type] ?? colors.info} border-0`;
        toastEl.setAttribute('role', 'alert');
        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi ${icons[type] ?? icons.info} me-2"></i>${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;

        document.getElementById('toastContainer').appendChild(toastEl);
        const toast = new bootstrap.Toast(toastEl, { delay: 3500 });
        toast.show();
        toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
    }

    function statusBadge(status) {
        return status === 'open'
            ? '<span class="badge text-bg-success">open</span>'
            : '<span class="badge text-bg-secondary">closed</span>';
    }

    function loadVacancies(page = 1) {
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
                    payload.data.forEach(v => {
                        tableBody.insertAdjacentHTML('beforeend', `
                            <tr>
                                <td>
                                    ${v.public_url ? `<a href="${v.public_url}" target="_blank">${v.title}</a>` : v.title}
                                </td>
                                <td>${v.department ?? '—'}</td>
                                <td>${v.location ?? '—'}</td>
                                <td>${v.type}</td>
                                <td>
                                    <button class="btn btn-sm p-0 border-0 btn-toggle-status" data-id="${v.id}" title="Click to toggle">
                                        ${statusBadge(v.status)}
                                    </button>
                                </td>
                                <td>${v.deadline ?? '—'}</td>
                                <td><span class="badge text-bg-info">${v.applications_count}</span></td>
                                <td class="text-end">
                                    <a class="btn btn-sm btn-outline-primary" href="${v.edit_url}" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${v.id}" data-title="${v.title}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                }

                renderPagination(payload);
            })
            .catch(() => showToast('Could not load vacancies. Please try again.', 'error'))
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
        if (page) loadVacancies(Number(page));
    });

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => loadVacancies(1), 350);
    });
    statusFilter.addEventListener('change', () => loadVacancies(1));

    tableBody.addEventListener('click', e => {
        const toggleBtn = e.target.closest('.btn-toggle-status');
        const delBtn = e.target.closest('.btn-delete');

        if (toggleBtn) {
            const id = toggleBtn.dataset.id;
            toggleBtn.disabled = true;

            fetch(routes.toggleStatus(id), {
                method: 'POST',
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
                    showToast(payload.message ?? 'Status updated.', 'success');
                    loadVacancies(currentPage);
                })
                .catch(err => showToast(err.message ?? 'Could not update status.', 'error'))
                .finally(() => toggleBtn.disabled = false);
        }

        if (delBtn) {
            pendingDeleteId = delBtn.dataset.id;
            deleteVacancyTitle.textContent = delBtn.dataset.title;
            deleteModal.show();
        }
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
                showToast(payload.message ?? 'Vacancy deleted.', 'success');
                loadVacancies(currentPage);
            })
            .catch(err => showToast(err.message ?? 'Could not delete vacancy.', 'error'))
            .finally(() => {
                btnConfirmDelete.disabled = false;
                deleteSpinner.classList.add('d-none');
                pendingDeleteId = null;
            });
    });

    loadVacancies();
})();
</script>
@endpush