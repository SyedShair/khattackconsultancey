@extends('layouts.admin')

@section('title', 'Edit Project')
@section('page_title', 'Edit Project')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')

    <form action="{{ route('projects.update', $project) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">Edit Project</h5></div>
            <div class="card-body">
                @include('projects._form')
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </div>

    </form>

@endsection
