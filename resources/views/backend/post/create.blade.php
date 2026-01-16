@extends('backend.layouts.app')
@section('title', 'Create New Post - '.config('settings.site_name'))
@section('breadcrumb')
<div class="nb">
    <div class="nb-header">
        <div class="nb-header-back">
            <a href="{{ route('backend.post.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Create New Post</h1>
        <div class="nb-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('backend.post.index') }}">Posts</a></div>
            <div class="breadcrumb-item">Create New Post</div>
        </div>
    </div>
</div>
@endsection
@section('content')
<section class="section">
    <div class="section-body">
        <h2 class="section-title">Create New Post</h2>
        <p class="section-lead">
            On this page you can create a new post and fill in all fields.
        </p>

        <form action="{{ route('backend.post.store') }}" method="POST" enctype="multipart/form-data" id="post-form">
            @csrf
            <div class="row">
                @include('backend.post._form')
            </div>
        </form>
    </div>
</section>
@endsection