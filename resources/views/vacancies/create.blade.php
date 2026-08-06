@extends('layouts.admin')

@section('title', 'New Vacancy')
@section('page_title', 'New Vacancy')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('vacancies.index') }}">Vacancies</a></li>
    <li class="breadcrumb-item active">New</li>
@endsection

@section('content')

    <form action="{{ route('vacancies.store') }}" method="POST">
        @csrf

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">New Vacancy</h5>
            </div>
            <div class="card-body">
                @include('vacancies._form')
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('vacancies.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Vacancy</button>
            </div>
        </div>

    </form>

@endsection