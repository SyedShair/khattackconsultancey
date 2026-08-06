@extends('layouts.admin')

@section('title', 'Edit Vacancy')
@section('page_title', 'Edit Vacancy')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('vacancies.index') }}">Vacancies</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')

    <form action="{{ route('vacancies.update', $vacancy) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Edit Vacancy</h5>
                @if(\Illuminate\Support\Facades\Route::has('vacancies.public.show'))
                    <a href="{{ route('vacancies.public.show', $vacancy) }}" target="_blank" class="small">
                        View public page <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                @endif
            </div>
            <div class="card-body">
                @include('vacancies._form')
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('vacancies.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </div>

    </form>

@endsection