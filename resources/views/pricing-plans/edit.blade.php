@extends('layouts.admin')

@section('title', 'Edit Pricing Plan')
@section('page_title', 'Edit Pricing Plan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pricing-plans.index') }}">Pricing Plans</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')

    <form action="{{ route('pricing-plans.update', $plan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">Edit Pricing Plan</h5></div>
            <div class="card-body">
                @include('pricing-plans._form')
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('pricing-plans.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </div>

    </form>

@endsection
