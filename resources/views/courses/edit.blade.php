@extends('layouts.admin')

@section('title', 'Edit Course')
@section('page_title', 'Edit Course')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Edit Course</h3>
    </div>

    <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            @include('courses._form')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update Course</button>
            <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
