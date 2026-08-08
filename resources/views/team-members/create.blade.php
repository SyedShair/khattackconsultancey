@extends('layouts.admin')

@section('title', 'New Team Member')
@section('page_title', 'New Team Member')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('team-members.index') }}">Team Members</a></li>
    <li class="breadcrumb-item active">New</li>
@endsection

@section('content')

    <form action="{{ route('team-members.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">New Team Member</h5></div>
            <div class="card-body">
                @include('team-members._form')
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('team-members.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Member</button>
            </div>
        </div>

    </form>

@endsection
@