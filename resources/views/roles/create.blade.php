@extends('layouts.admin')

@section('title', 'Create Role')
@section('page_title', 'Create Role')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')

    <div class="card">
        <div class="card-body">

            <form method="POST" action="{{ route('roles.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Role Name</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Permissions</label>

                    @forelse($permissions as $group => $items)
                        <div class="mb-2">
                            <strong class="text-capitalize">{{ $group }}</strong><br>
                            @foreach($items as $permission)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox"
                                           class="form-check-input"
                                           name="permissions[]"
                                           id="perm-{{ $permission->name }}"
                                           value="{{ $permission->name }}"
                                           {{ collect(old('permissions'))->contains($permission->name) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm-{{ $permission->name }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <p class="text-muted">No permissions exist yet — run the seeder first.</p>
                    @endforelse
                </div>

                <button type="submit" class="btn btn-primary">Create Role</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>

            </form>

        </div>
    </div>

@endsection
