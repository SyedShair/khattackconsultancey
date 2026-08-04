@extends('layouts.admin')

@section('title', 'Roles')
@section('page_title', 'Roles')

@section('breadcrumb')
    <li class="breadcrumb-item active">Roles</li>
@endsection

@section('content')

    <div class="card">

        <div class="card-header d-flex justify-content-end">
            <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg"></i> New Role
            </a>
        </div>

        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Permissions</th>
                        <th>Users</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->permissions_count }}</td>
                            <td>{{ $role->users_count }}</td>
                            <td class="text-end">
                                <a href="{{ route('roles.edit', $role) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($role->name !== 'admin')
                                    <form action="{{ route('roles.destroy', $role) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this role?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No roles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $roles->links() }}
        </div>

    </div>

@endsection
