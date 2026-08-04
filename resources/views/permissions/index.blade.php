@extends('layouts.admin')

@section('title', 'Permissions')
@section('page_title', 'Permissions')

@section('breadcrumb')
    <li class="breadcrumb-item active">Permissions</li>
@endsection

@section('content')

    <div class="card">

        <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">

            <div class="d-flex gap-2">
                <input type="text" id="searchInput" class="form-control form-control-sm"
                       placeholder="Search name, guard..." style="width: 220px;">

                <select id="guardFilter" class="form-select form-select-sm" style="width: 140px;">
                    <option value="">All guards</option>
                    @foreach($guards as $guard)
                        <option value="{{ $guard }}">{{ $guard }}</option>
                    @endforeach
                </select>
            </div>

            <button type="button" class="btn btn-sm btn-primary" id="btnNewPermission">
                <i class="bi bi-plus-lg"></i> New Permission
            </button>

        </div>

        <div class="card-body p-0 position-relative">

            <div id="tableLoading" class="text-center py-5 d-none">
                <div class="spinner-border text-primary"></div>
            </div>

            <table class="table table-hover mb-0" id="permissionsTable">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>guard_name</th>
                        <th>created_at</th>
                        <th>updated_at</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody id="permissionsTableBody"></tbody>
            </table>

            <div class="text-center text-muted py-4 d-none" id="emptyState">No permissions found.</div>

        </div>

        <div class="card-footer">
            <nav>
                <ul class="pagination pagination-sm mb-0 justify-content-end" id="pagination"></ul>
            </nav>
        </div>

    </div>


    <!-- =========================
         CREATE / EDIT MODAL
    ========================== -->
    <div class="modal fade" id="permissionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form id="permissionForm" novalidate>
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="permission_id" id="permissionId">

                    <div class="modal-header">
                        <h5 class="modal-title" id="permissionModalTitle">New Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div id="formErrors" class="alert alert-danger d-none"></div>

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                   placeholder="e.g. users.view">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Guard</label>
                            <select name="guard_name" id="guard_name" class="form-select">
                                @foreach($guards as $guard)
                                    <option value="{{ $guard }}">{{ $guard }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btnSubmit">
                            <span class="spinner-border spinner-border-sm d-none" id="submitSpinner"></span>
                            Save
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
(function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const routes = {
        data: "{{ route('permissions.data') }}",
        store: "{{ route('permissions.store') }}",
        show: id => `{{ url('permissions') }}/${id}`,
        update: id => `{{ url('permissions') }}/${id}`,
        destroy: id => `{{ url('permissions') }}/${id}`,
        duplicate: id => `{{ url('permissions') }}/${id}/duplicate`,
    };

    const tableBody = document.getElementById('permissionsTableBody');
    const tableLoading = document.getElementById('tableLoading');
    const emptyState = document.getElementById('emptyState');
    const pagination = document.getElementById('pagination');
    const searchInput = document.getElementById('searchInput');
    const guardFilter = document.getElementById('guardFilter');

    const permissionModalEl = document.getElementById('permissionModal');
    const permissionModal = new bootstrap.Modal(permissionModalEl);
    const permissionForm = document.getElementById('permissionForm');
    const formErrors = document.getElementById('formErrors');
    const submitSpinner = document.getElementById('submitSpinner');

    let searchTimer = null;
    let currentPage = 1;

    function loadPermissions(page = 1) {
        currentPage = page;
        tableLoading.classList.remove('d-none');
        emptyState.classList.add('d-none');

        const params = new URLSearchParams({
            page,
            search: searchInput.value,
            guard: guardFilter.value,
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
                    payload.data.forEach(permission => {
                        tableBody.insertAdjacentHTML('beforeend', `
                            <tr>
                                <td>${permission.id}</td>
                                <td>${permission.name}</td>
                                <td><span class="badge text-bg-info">${permission.guard_name}</span></td>
                                <td>${permission.created_at}</td>
                                <td>${permission.updated_at}</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary btn-edit" data-id="${permission.id}" title="Edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary btn-copy" data-id="${permission.id}" title="Copy">
                                        <i class="bi bi-copy"></i> Copy
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${permission.id}" data-name="${permission.name}" title="Delete">
                                        <i class="bi bi-trash"></i> Delete
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
        if (page) loadPermissions(Number(page));
    });

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => loadPermissions(1), 350);
    });
    guardFilter.addEventListener('change', () => loadPermissions(1));

    function resetForm() {
        permissionForm.reset();
        document.getElementById('permissionId').value = '';
        document.getElementById('formMethod').value = 'POST';
        formErrors.classList.add('d-none');
        formErrors.innerHTML = '';
    }

    document.getElementById('btnNewPermission').addEventListener('click', () => {
        resetForm();
        document.getElementById('permissionModalTitle').textContent = 'New Permission';
        permissionModal.show();
    });

    tableBody.addEventListener('click', e => {
        const editBtn = e.target.closest('.btn-edit');
        const copyBtn = e.target.closest('.btn-copy');
        const delBtn = e.target.closest('.btn-delete');

        if (editBtn) {
            const id = editBtn.dataset.id;
            fetch(routes.show(id), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.json())
                .then(permission => {
                    resetForm();
                    document.getElementById('permissionModalTitle').textContent = 'Edit Permission';
                    document.getElementById('permissionId').value = permission.id;
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('name').value = permission.name;
                    document.getElementById('guard_name').value = permission.guard_name;
                    permissionModal.show();
                });
        }

        if (copyBtn) {
            const id = copyBtn.dataset.id;
            copyBtn.disabled = true;

            fetch(routes.duplicate(id), {
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
                    loadPermissions(currentPage);
                })
                .catch(err => {
                    alert(err.message || 'Could not copy permission.');
                })
                .finally(() => copyBtn.disabled = false);
        }

        if (delBtn) {
            const id = delBtn.dataset.id;
            const name = delBtn.dataset.name;
            if (!confirm(`Delete permission "${name}"? This cannot be undone.`)) return;

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
                    loadPermissions(currentPage);
                });
        }
    });

    permissionForm.addEventListener('submit', e => {
        e.preventDefault();
        formErrors.classList.add('d-none');
        formErrors.innerHTML = '';
        submitSpinner.classList.remove('d-none');

        const id = document.getElementById('permissionId').value;
        const isEdit = !!id;
        const url = isEdit ? routes.update(id) : routes.store;
        const formData = new FormData(permissionForm);
        if (!isEdit) formData.delete('_method');

        fetch(url, {
            method: 'POST', // Laravel method-spoofing via _method for PUT
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: formData,
        })
            .then(async res => {
                const payload = await res.json();
                if (!res.ok) throw payload;
                return payload;
            })
            .then(payload => {
                permissionModal.hide();
                loadPermissions(currentPage);
            })
            .catch(err => {
                if (err.errors) {
                    const messages = Object.values(err.errors).flat();
                    formErrors.innerHTML = messages.join('<br>');
                } else {
                    formErrors.innerHTML = err.message || 'Something went wrong.';
                }
                formErrors.classList.remove('d-none');
            })
            .finally(() => submitSpinner.classList.add('d-none'));
    });

    loadPermissions();
})();
</script>
@endpush