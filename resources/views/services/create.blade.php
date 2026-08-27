@extends('layouts.admin')

@section('title', 'Add Service')
@section('page_title', 'Add Service')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Services</a></li>
    <li class="breadcrumb-item active">Add</li>
@endsection

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">New Service</h3>
    </div>

    <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            @include('services._form')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create Service</button>
            <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection