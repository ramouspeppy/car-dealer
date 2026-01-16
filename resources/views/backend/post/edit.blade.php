@extends('backend.layouts.app')
@section('title', 'Edit Post - '.config('settings.site_name'))
@section('breadcrumb')
<div class="nb">
    <div class="nb-header">
        <div class="nb-header-back">
            <a href="{{ route('backend.post.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Edit Post</h1>
        <div class="nb-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('backend.post.index') }}">Posts</a></div>
            <div class="breadcrumb-item">Edit Post</div>
        </div>
    </div>
</div>
@endsection
@section('content')
<section class="section">
    <div class="section-body">
        <h2 class="section-title">Edit Post</h2>
        <p class="section-lead">
            On this page you can edit a post and fill in all fields.
        </p>
        <form action="{{ route('backend.post.update',$post->id) }}" method="POST" id="post-form" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="row">
                @include('backend.post._form')
            </div>
        </form>
    </div>
</section>
@endsection