@extends('backend.layouts.app')
@section('title', 'Profile - '.config('settings.site_name'))
@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="#" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Profile</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Profile</div>
        </div>
    </div>

    @include('backend.layouts._notif')
    <div class="section-body">
        <div class="row">
            @include('backend.profile._form')
        </div>
    </div>
</section>
@endsection