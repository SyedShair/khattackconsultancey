@extends('layouts.admin')

@section('title', 'Add Course')
@section('page_title', 'Add Course')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses</a></li>
    <li class="breadcrumb-item active">Add</li>
@endsection

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">New Course</h3>
    </div>

    <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            @include('courses._form')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create Course</button>
            <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
