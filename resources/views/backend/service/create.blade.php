@extends('backend.layouts.app')
@section('title', 'Create New Service - ' . config('settings.site_name'))
@section('content')
    @include('backend.layouts._notif')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('backend.service.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Create New Service</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('backend.service.index') }}">Service</a></div>
                <div class="breadcrumb-item">Create New Service</div>
            </div>
        </div>
    
        <div class="section-body">
            <form action="{{ route('backend.service.store') }}" class="needs-validation" enctype="multipart/form-data" method="POST" id="form-service">
                @csrf
                <div class="row justify-content-center">
                    @include('backend.service._form')
                </div>
            </form>
        </div>
    </section>
@endsection
