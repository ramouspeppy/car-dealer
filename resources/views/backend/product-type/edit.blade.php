@extends('backend.layouts.app')
@section('title', 'Edit Product Type - '.config('settings.site_name'))
@section('breadcrumb')
<div class="nb">
    <div class="nb-header">
        <div class="nb-header-back">
            <a href="{{ route('backend.product-type.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Edit Product Type</h1>
        <div class="nb-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('backend.product-type.index') }}">Product Categories</a></div>
            <div class="breadcrumb-item">Edit Product Type</div>
        </div>
    </div>
</div>
@endsection
@section('content')
@include('backend.layouts._notif')
<section class="section">
    <div class="section-body">
        <form action="{{ route('backend.product-type.update', $product_type ) }}" method="POST">
            @method('put')
            @csrf
            <div class="row justify-content-center">
                @include('backend.product-type._form')
            </div>
        </form>
    </div>
</section>
@endsection