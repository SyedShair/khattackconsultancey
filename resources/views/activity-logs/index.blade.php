@extends('layouts.admin')

@section('title', 'Activity Log')
@section('page_title', 'Activity Log')

@section('breadcrumb')
    <li class="breadcrumb-item active">Activity Log</li>
@endsection

@section('content')

    <div class="card">

        <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">
            <div class="d-flex gap-2 flex-wrap">
                <input type="text" id="searchInput" class="form-control form-control-sm"
                       placeholder="Search description, user..." style="width: 240px;">

                <select id="userFilter" class="form-select form-select-sm" style="width: 170px;">
                    <option value="">All users</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                    @endforeach
                </select>

                <select id="actionFilter" class="form-select form-select-sm" style="width: 140px;">
                    <option value="">All actions</option>
                    @foreach(\App\Models\ActivityLog::ACTIONS as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-body p-0 position-relative">

            <div id="tableLoading" class="text-center py-5 d-none">
                <div class="spinner-border text-primary"></div>
            </div>

            <table class="table table-hover mb-0" id="logsTable">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>Subject</th>
                        <th>IP Address</th>
                        <th>When</th>
                    </tr>
                </thead>
                <tbody id="logsTableBody"></tbody>
            </table>

            <div class="text-center text-muted py-4 d-none" id="emptyState">No activity recorded yet.</div>

        </div>

        <div class="card-footer">
            <nav>
                <ul class="pagination pagination-sm mb-0 justify-content-end" id="pagination"></ul>
            </nav>
        </div>

    </div>

@endsection

@push('scripts')
<script>
(function () {
    const routes = { data: "{{ route('activity-logs.data') }}" };

    const tableBody = document.getElementById('logsTableBody');
    const tableLoading = document.getElementById('tableLoading');
    const emptyState = document.getElementById('emptyState');
    const pagination = document.getElementById('pagination');
    const searchInput = document.getElementById('searchInput');
    const userFilter = document.getElementById('userFilter');
    const actionFilter = document.getElementById('actionFilter');

    let searchTimer = null;
    let currentPage = 1;

    function actionBadge(action) {
        const map = { login: 'success', logout: 'secondary', created: 'primary', updated: 'warning', deleted: 'danger' };
        return `<span class="badge text-bg-${map[action] ?? 'secondary'}">${action}</span>`;
    }

    function loadLogs(page = 1) {
        currentPage = page;
        tableLoading.classList.remove('d-none');
        emptyState.classList.add('d-none');

        const params = new URLSearchParams({
            page,
            search: searchInput.value,
            user_id: userFilter.value,
            action: actionFilter.value,
        });

        fetch(`${routes.data}?${params.toString()}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.json())
            .then(payload => {
                tableBody.innerHTML = '';

                if (payload.data.length === 0) {
                    emptyState.classList.remove('d-none');
                } else {
                    payload.data.forEach(log => {
                        tableBody.insertAdjacentHTML('beforeend', `
                            <tr>
                                <td class="fw-semibold">${log.user_name}</td>
                                <td>${actionBadge(log.action)}</td>
                                <td>${log.description}</td>
                                <td class="text-muted small">${log.subject_label ?? '—'}</td>
                                <td class="text-muted small">${log.ip_address ?? '—'}</td>
                                <td class="text-muted small" title="${log.created_at}">${log.created_human}</td>
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
                <li class="page-item ${active}"><a class="page-link" href="#" data-page="${p}">${p}</a></li>
            `);
        }
    }

    pagination.addEventListener('click', e => {
        e.preventDefault();
        const page = e.target.closest('[data-page]')?.dataset.page;
        if (page) loadLogs(Number(page));
    });

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => loadLogs(1), 350);
    });
    userFilter.addEventListener('change', () => loadLogs(1));
    actionFilter.addEventListener('change', () => loadLogs(1));

    loadLogs();
})();
</script>
@endpush