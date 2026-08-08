@extends('layouts.admin')

@section('title', 'New Project')
@section('page_title', 'New Project')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
    <li class="breadcrumb-item active">New</li>
@endsection

@section('content')

    <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">New Project</h5></div>
            <div class="card-body">
                @include('projects._form')
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Project</button>
            </div>
        </div>

    </form>

@endsection
