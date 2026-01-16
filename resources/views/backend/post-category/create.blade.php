@extends('backend.layouts.app')
@section('title', 'Create New Post Category - '.config('settings.site_name'))
@section('breadcrumb')
<div class="nb">
    <div class="nb-header">
        <div class="nb-header-back">
            <a href="{{ route('backend.post-category.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Create New Post Category</h1>
        <div class="nb-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('backend.post-category.index') }}">Post Categories</a></div>
            <div class="breadcrumb-item">Create New Post Category</div>
        </div>
    </div>
</div>
@endsection
@section('content')
<section class="section">
    <div class="section-body">
        <form action="{{ route('backend.post-category.store') }}" method="POST" id="form-post-category">
            @csrf
            <div class="row justify-content-center">
                @include('backend.post-category._form')
            </div>
        </form>
    </div>
</section>
@endsection