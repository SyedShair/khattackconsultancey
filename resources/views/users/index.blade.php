@extends('layouts.admin')

@section('title', 'Users')
@section('page_title', 'Users')

@section('breadcrumb')
    <li class="breadcrumb-item active">Users</li>
@endsection

@section('content')

    <div class="card">

        <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">

            <div class="d-flex gap-2">
                <input type="text" id="searchInput" class="form-control form-control-sm"
                       placeholder="Search name, email, phone..." style="width: 220px;">

                <select id="statusFilter" class="form-select form-select-sm" style="width: 140px;">
                    <option value="">All statuses</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <button type="button" class="btn btn-sm btn-primary" id="btnNewUser">
                <i class="bi bi-plus-lg"></i> New User
            </button>

        </div>

        <div class="card-body p-0 position-relative">

            <div id="tableLoading" class="text-center py-5 d-none">
                <div class="spinner-border text-primary"></div>
            </div>

            <table class="table table-hover mb-0" id="usersTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Roles</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody"></tbody>
            </table>

            <div class="text-center text-muted py-4 d-none" id="emptyState">No users found.</div>

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
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form id="userForm" enctype="multipart/form-data" novalidate>
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="user_id" id="userId">

                    <div class="modal-header">
                        <h5 class="modal-title" id="userModalTitle">New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div id="formErrors" class="alert alert-danger d-none"></div>

                        <div class="mb-3 text-center">
                            <img id="avatarPreview" src="{{ asset('adminlte/img/user2-160x160.jpg') }}"
                                 class="rounded-circle mb-2" width="80" height="80" style="object-fit: cover;">
                            <input type="file" name="avatar" id="avatarInput" class="form-control form-control-sm" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password <span class="text-muted small" id="passwordHint"></span></label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <div class="mb-1">
                            <label class="form-label d-block">Roles</label>
                            @foreach($roles as $role)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input role-checkbox"
                                           name="roles[]" id="role-{{ $role }}" value="{{ $role }}">
                                    <label class="form-check-label" for="role-{{ $role }}">{{ $role }}</label>
                                </div>
                            @endforeach
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
        data: "{{ route('users.data') }}",
        store: "{{ route('users.store') }}",
        show: id => `/users/${id}`,
        update: id => `/users/${id}`,
        destroy: id => `/users/${id}`,
    };

    const tableBody = document.getElementById('usersTableBody');
    const tableLoading = document.getElementById('tableLoading');
    const emptyState = document.getElementById('emptyState');
    const pagination = document.getElementById('pagination');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');

    const userModalEl = document.getElementById('userModal');
    const userModal = new bootstrap.Modal(userModalEl);
    const userForm = document.getElementById('userForm');
    const formErrors = document.getElementById('formErrors');
    const submitSpinner = document.getElementById('submitSpinner');

    let searchTimer = null;
    let currentPage = 1;

    function statusBadge(status) {
        return status === 'active'
            ? '<span class="badge text-bg-success">active</span>'
            : '<span class="badge text-bg-secondary">inactive</span>';
    }

    function rolesBadges(roles) {
        if (!roles.length) return '<span class="text-muted">—</span>';
        return roles.map(r => `<span class="badge text-bg-info me-1">${r}</span>`).join('');
    }

    function loadUsers(page = 1) {
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
                    payload.data.forEach(user => {
                        const avatar = user.avatar
                            ? `<img src="${user.avatar}" class="rounded-circle" width="32" height="32" style="object-fit:cover;">`
                            : `<div class="rounded-circle bg-secondary-subtle d-flex align-items-center justify-content-center" style="width:32px;height:32px;">${user.name.charAt(0)}</div>`;

                        tableBody.insertAdjacentHTML('beforeend', `
                            <tr>
                                <td>${avatar}</td>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>${user.phone ?? '—'}</td>
                                <td>${statusBadge(user.status)}</td>
                                <td>${rolesBadges(user.roles)}</td>
                                <td>${user.created_at}</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary btn-edit" data-id="${user.id}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${user.id}" data-name="${user.name}">
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
        if (page) loadUsers(Number(page));
    });

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => loadUsers(1), 350);
    });
    statusFilter.addEventListener('change', () => loadUsers(1));

    function resetForm() {
        userForm.reset();
        document.getElementById('userId').value = '';
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('avatarPreview').src = "{{ asset('adminlte/img/user2-160x160.jpg') }}";
        document.getElementById('passwordHint').textContent = '';
        document.getElementById('password').required = true;
        document.querySelectorAll('.role-checkbox').forEach(cb => cb.checked = false);
        formErrors.classList.add('d-none');
        formErrors.innerHTML = '';
    }

    document.getElementById('btnNewUser').addEventListener('click', () => {
        resetForm();
        document.getElementById('userModalTitle').textContent = 'New User';
        userModal.show();
    });

    document.getElementById('avatarInput').addEventListener('change', function () {
        if (this.files[0]) {
            document.getElementById('avatarPreview').src = URL.createObjectURL(this.files[0]);
        }
    });

    tableBody.addEventListener('click', e => {
        const editBtn = e.target.closest('.btn-edit');
        const delBtn = e.target.closest('.btn-delete');

        if (editBtn) {
            const id = editBtn.dataset.id;
            fetch(routes.show(id), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.json())
                .then(user => {
                    resetForm();
                    document.getElementById('userModalTitle').textContent = 'Edit User';
                    document.getElementById('userId').value = user.id;
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('name').value = user.name;
                    document.getElementById('email').value = user.email;
                    document.getElementById('phone').value = user.phone ?? '';
                    document.getElementById('status').value = user.status;
                    document.getElementById('password').required = false;
                    document.getElementById('passwordHint').textContent = '(leave blank to keep current)';
                    if (user.avatar) document.getElementById('avatarPreview').src = user.avatar;
                    user.roles.forEach(r => {
                        const cb = document.getElementById(`role-${r}`);
                        if (cb) cb.checked = true;
                    });
                    userModal.show();
                });
        }

        if (delBtn) {
            const id = delBtn.dataset.id;
            const name = delBtn.dataset.name;
            if (!confirm(`Delete user "${name}"? This cannot be undone.`)) return;

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
                    loadUsers(currentPage);
                });
        }
    });

    userForm.addEventListener('submit', e => {
        e.preventDefault();
        formErrors.classList.add('d-none');
        formErrors.innerHTML = '';
        submitSpinner.classList.remove('d-none');

        const id = document.getElementById('userId').value;
        const isEdit = !!id;
        const url = isEdit ? routes.update(id) : routes.store;
        const formData = new FormData(userForm);
        if (!isEdit) formData.delete('_method');

        fetch(url, {
            method: 'POST', // Laravel method-spoofing via _method for PUT + file upload
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
                userModal.hide();
                loadUsers(currentPage);
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

    loadUsers();
})();
</script>
@endpush
