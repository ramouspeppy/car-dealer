@extends('backend.layouts.app')
@section('title', 'Create New Product - ' . config('settings.site_name'))
@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('backend.product.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Create New Product</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('backend.product.index') }}">Product</a></div>
                <div class="breadcrumb-item">Create New Product</div>
            </div>
        </div>
        @include('backend.layouts._notif')

        <div class="section-body">
            <form action="{{ route('backend.product.store') }}" class="needs-validation" enctype="multipart/form-data" method="post" id="form-product">
                @csrf
                <div class="row justify-content-center">
                    @include('backend.product._form')
                </div>
            </form>
        </div>
    </section>
@endsection
