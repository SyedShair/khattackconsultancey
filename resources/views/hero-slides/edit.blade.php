@extends('layouts.admin')

@section('title', 'Edit Hero Slide')
@section('page_title', 'Edit Hero Slide')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('hero-slides.index') }}">Hero Slides</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')

    <form action="{{ route('hero-slides.update', $slide) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">Edit Hero Slide</h5></div>
            <div class="card-body">
                @include('hero-slides._form')
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('hero-slides.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </div>

    </form>

@endsection