@extends('backend.layouts.app')
@section('title', 'Edit Photo Delivery - '.config('settings.site_name'))
@section('breadcrumb')
<div class="nb">
    <div class="nb-header">
        <div class="nb-header-back">
            <a href="{{ route('backend.photo-delivery.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Edit Photo Delivery</h1>
        <div class="nb-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('backend.photo-delivery.index') }}">Photo Delivery</a></div>
            <div class="breadcrumb-item">Edit Photo Delivery</div>
        </div>
    </div>
</div>
@endsection
@section('content')
<section class="section">
    <div class="section-body">
        <form action="{{ route('backend.photo-delivery.update', $photo_delivery ) }}" enctype="multipart/form-data"
            method="post">
            @method('put')
            @csrf
            <div class="row justify-content-center">
                @include('backend.photo-delivery._form')
            </div>
        </form>
    </div>
</section>
@endsection