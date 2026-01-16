@extends('backend.layouts.app')
@section('title', 'Create New Testimony - '.config('settings.site_name'))
@section('breadcrumb')
<div class="nb">
    <div class="nb-header">
        <div class="nb-header-back">
            <a href="{{ route('backend.testimony.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Create New Testimony</h1>
        <div class="nb-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('backend.testimony.index') }}">Testimony</a></div>
            <div class="breadcrumb-item">Create New Testimony</div>
        </div>
    </div>
</div>
@endsection
@section('content')
<section class="section">
    <div class="section-body">
        <form action="{{ route('backend.testimony.store') }}" enctype="multipart/form-data" method="post" id="form-testimony">
            @csrf
            <div class="row justify-content-center">
                @include('backend.testimony._form')
            </div>
        </form>
    </div>
</section>
@endsection