@extends('backend.layouts.app')
@section('title', 'Create New user - '.config('settings.site_name'))
@section('breadcrumb')
<div class="nb">
    <div class="nb-header">
        <div class="nb-header-back">
            <a href="{{ route('backend.user.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Create New user</h1>
        <div class="nb-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('backend.user.index') }}">user</a></div>
            <div class="breadcrumb-item">Create New user</div>
        </div>
    </div>
</div>
@endsection
@section('content')
<section class="section">
    @include('backend.layouts._notif')
    <div class="section-body">
        <form action="{{ route('backend.user.store') }}" enctype="multipart/form-data" method="post" id="form-user">
            @csrf
            <div class="row justify-content-center">
                @include('backend.user._form')
            </div>
        </form>
    </div>
</section>
@endsection