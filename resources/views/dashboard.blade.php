@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Welcome, {{ auth()->user()->name }}</h5>
                    <p class="card-text text-muted mb-0">
                        Your roles:
                        @foreach(auth()->user()->roles as $role)
                            <span class="badge text-bg-info">{{ $role->name }}</span>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="fs-3 mb-0">{{ \App\Models\User::count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Roles</h5>
                    <p class="fs-3 mb-0">{{ \Spatie\Permission\Models\Role::count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Vacancies</h5>
                    <p class="fs-3 mb-0">{{ \App\Models\Vacancy::count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Open Vacancies</h5>
                    <p class="fs-3 mb-0 text-success">{{ \App\Models\Vacancy::open()->count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Applicants</h5>
                    <p class="fs-3 mb-0">{{ \App\Models\Application::count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pending Review</h5>
                    <p class="fs-3 mb-0 text-warning">{{ \App\Models\Application::where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('users.index') }}" class="btn btn-primary">Manage Users</a>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Manage Roles</a>
        <a href="{{ route('vacancies.index') }}" class="btn btn-info text-white">Manage Vacancies</a>
        <a href="{{ route('applications.index') }}" class="btn btn-outline-dark text-white">View Applicants</a>
    </div>

@endsection