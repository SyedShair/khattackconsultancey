@extends('layouts.admin')

@section('title', 'Edit Team Member')
@section('page_title', 'Edit Team Member')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('team-members.index') }}">Team Members</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')

    <form action="{{ route('team-members.update', $teamMember) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">Edit Team Member</h5></div>
            <div class="card-body">
                @include('team-members._form')
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('team-members.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </div>

    </form>

@endsection
