@extends('backend.layouts.app')
@section('title', 'Edit Gallery - '.config('settings.site_name'))
@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('backend.gallery.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Edit Gallery</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('backend.gallery.index') }}">Gallery</a></div>
            <div class="breadcrumb-item">Edit Gallery</div>
        </div>
    </div>

    <div class="section-body">
        <form action="{{ route('backend.gallery.update', $gallery ) }}" enctype="multipart/form-data" method="post">
            @method('put')
            @csrf
            <div class="row justify-content-center">
                @include('backend.gallery._form')
            </div>
        </form>
    </div>
</section>
@endsection