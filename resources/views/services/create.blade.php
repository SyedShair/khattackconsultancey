@extends('layouts.admin')

@section('title', 'New Service')
@section('page_title', 'New Service')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Services</a></li>
    <li class="breadcrumb-item active">New</li>
@endsection

@section('content')

    <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">New Service</h5></div>
            <div class="card-body">
                @include('services._form')
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Service</button>
            </div>
        </div>

    </form>

@endsection