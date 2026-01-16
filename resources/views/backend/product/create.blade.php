@extends('backend.layouts.app')
@section('title', 'Create New Product - '.config('settings.site_name'))
@section('breadcrumb')
<div class="nb">
    <div class="nb-header">
        <div class="nb-header-back">
            <a href="{{ route('backend.product.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Create New Product</h1>
        <div class="nb-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('backend.product.index') }}">Product</a></div>
            <div class="breadcrumb-item">Create New Product</div>
        </div>
    </div>
</div>
@endsection
@section('content')
@include('backend.layouts._notif')
<section class="section">
    <div class="section-body">
        <form action="{{ route('backend.product.store') }}" class="needs-validation" enctype="multipart/form-data" method="post"
            id="form-product">
            @csrf
            <div class="row justify-content-center">
                @include('backend.product._form')
            </div>
        </form>
    </div>
</section>
@endsection