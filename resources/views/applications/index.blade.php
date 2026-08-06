@extends('layouts.admin')

@section('title', 'Applications')
@section('page_title', 'Applications')

@section('breadcrumb')
    <li class="breadcrumb-item active">Applications</li>
@endsection

@section('content')

    <div class="card">

        <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">

            <div class="d-flex gap-2 flex-wrap">
                <input type="text" id="searchInput" class="form-control form-control-sm"
                       placeholder="Search name, email, phone..." style="width: 240px;">

                <select id="vacancyFilter" class="form-select form-select-sm" style="width: 200px;">
                    <option value="">All vacancies</option>
                    <option value="general">General applications</option>
                    @foreach($vacancies as $v)
                        <option value="{{ $v->id }}">{{ $v->title }}</option>
                    @endforeach
                </select>

                <select id="statusFilter" class="form-select form-select-sm" style="width: 150px;">
                    <option value="">All statuses</option>
                    @foreach(\App\Models\Application::STATUSES as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="card-body p-0 position-relative">

            <div id="tableLoading" class="text-center py-5 d-none">
                <div class="spinner-border text-primary"></div>
            </div>

            <table class="table table-hover mb-0" id="applicationsTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Applied For</th>
                        <th>Status</th>
                        <th>Applied</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody id="applicationsTableBody"></tbody>
            </table>

            <div class="text-center text-muted py-4 d-none" id="emptyState">No applications found.</div>

        </div>

        <div class="card-footer">
            <nav>
                <ul class="pagination pagination-sm mb-0 justify-content-end" id="pagination"></ul>
            </nav>
        </div>

    </div>


    <!-- =========================
         APPLICATION DETAIL MODAL
    ========================== -->
    <div class="modal fade" id="applicationModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Application Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <dl class="row mb-0">
                        <dt class="col-4">Name</dt>
                        <dd class="col-8" id="dName"></dd>

                        <dt class="col-4">Email</dt>
                        <dd class="col-8" id="dEmail"></dd>

                        <dt class="col-4">Phone</dt>
                        <dd class="col-8" id="dPhone"></dd>

                        <dt class="col-4">Applied For</dt>
                        <dd class="col-8" id="dVacancy"></dd>

                        <dt class="col-4">Applied At</dt>
                        <dd class="col-8" id="dAppliedAt"></dd>

                        <dt class="col-4">Cover Letter</dt>
                        <dd class="col-8" id="dCoverLetter"></dd>

                        <dt class="col-4">Resume</dt>
                        <dd class="col-8">
                            <a id="dResumeLink" href="#" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-file-earmark-arrow-down"></i> Download Resume
                            </a>
                        </dd>
                    </dl>
                </div>

                <div class="modal-footer">
                    <select id="statusSelect" class="form-select form-select-sm w-auto">
                        @foreach(\App\Models\Application::STATUSES as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-primary btn-sm" id="btnSaveStatus">Update Status</button>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
(function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const routes = {
        data: "{{ url('admin/applications/data') }}",
        show: id => `{{ url('admin/applications') }}/${id}`,
        updateStatus: id => `{{ url('admin/applications') }}/${id}/status`,
        destroy: id => `{{ url('admin/applications') }}/${id}`,
    };

    const tableBody = document.getElementById('applicationsTableBody');
    const tableLoading = document.getElementById('tableLoading');
    const emptyState = document.getElementById('emptyState');
    const pagination = document.getElementById('pagination');
    const searchInput = document.getElementById('searchInput');
    const vacancyFilter = document.getElementById('vacancyFilter');
    const statusFilter = document.getElementById('statusFilter');

    const applicationModalEl = document.getElementById('applicationModal');
    const applicationModal = new bootstrap.Modal(applicationModalEl);
    let activeApplicationId = null;

    let searchTimer = null;
    let currentPage = 1;

    function statusBadge(status) {
        const map = {
            pending: 'secondary', reviewed: 'info', shortlisted: 'primary',
            rejected: 'danger', hired: 'success',
        };
        return `<span class="badge text-bg-${map[status] ?? 'secondary'}">${status}</span>`;
    }

    function loadApplications(page = 1) {
        currentPage = page;
        tableLoading.classList.remove('d-none');
        emptyState.classList.add('d-none');

        const params = new URLSearchParams({
            page,
            search: searchInput.value,
            vacancy_id: vacancyFilter.value,
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
                    payload.data.forEach(a => {
                        tableBody.insertAdjacentHTML('beforeend', `
                            <tr>
                                <td>${a.name}</td>
                                <td>${a.email}</td>
                                <td>${a.phone}</td>
                                <td>${a.vacancy}</td>
                                <td>${statusBadge(a.status)}</td>
                                <td>${a.applied_at}</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary btn-view" data-id="${a.id}" title="View">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <a class="btn btn-sm btn-outline-secondary" href="${a.resume_url}" title="Download Resume">
                                        <i class="bi bi-file-earmark-arrow-down"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${a.id}" data-name="${a.name}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                }

                renderPagination(payload);
            })
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
        if (page) loadApplications(Number(page));
    });

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => loadApplications(1), 350);
    });
    vacancyFilter.addEventListener('change', () => loadApplications(1));
    statusFilter.addEventListener('change', () => loadApplications(1));

    tableBody.addEventListener('click', e => {
        const viewBtn = e.target.closest('.btn-view');
        const delBtn = e.target.closest('.btn-delete');

        if (viewBtn) {
            const id = viewBtn.dataset.id;
            fetch(routes.show(id), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.json())
                .then(a => {
                    activeApplicationId = a.id;
                    document.getElementById('dName').textContent = a.name;
                    document.getElementById('dEmail').textContent = a.email;
                    document.getElementById('dPhone').textContent = a.phone;
                    document.getElementById('dVacancy').textContent = a.vacancy;
                    document.getElementById('dAppliedAt').textContent = a.applied_at;
                    document.getElementById('dCoverLetter').textContent = a.cover_letter || '—';
                    document.getElementById('dResumeLink').href = a.resume_url;
                    document.getElementById('statusSelect').value = a.status;
                    applicationModal.show();
                });
        }

        if (delBtn) {
            const id = delBtn.dataset.id;
            const name = delBtn.dataset.name;
            if (!confirm(`Delete application from "${name}"? This also removes their resume file. This cannot be undone.`)) return;

            fetch(routes.destroy(id), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
                .then(res => res.json())
                .then(payload => {
                    if (payload.message) alert(payload.message);
                    loadApplications(currentPage);
                });
        }
    });

    document.getElementById('btnSaveStatus').addEventListener('click', () => {
        if (!activeApplicationId) return;
        const status = document.getElementById('statusSelect').value;

        fetch(routes.updateStatus(activeApplicationId), {
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
            .then(() => {
                applicationModal.hide();
                loadApplications(currentPage);
            });
    });

    loadApplications();
})();
</script>
@endpush