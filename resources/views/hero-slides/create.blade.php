@extends('layouts.admin')

@section('title', 'New Hero Slide')
@section('page_title', 'New Hero Slide')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('hero-slides.index') }}">Hero Slides</a></li>
    <li class="breadcrumb-item active">New</li>
@endsection

@section('content')

    <form action="{{ route('hero-slides.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">New Hero Slide</h5></div>
            <div class="card-body">
                @include('hero-slides._form')
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('hero-slides.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Slide</button>
            </div>
        </div>

    </form>

@endsection