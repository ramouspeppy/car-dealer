@extends('backend.layouts.app')
@section('title', 'Product Type - ' . config('settings.site_name'))
@section('breadcrumb')
<div class="nb">
    <div class="nb-header">
        <h1>Product Type</h1>
        <div class="nb-header-button">
            <a href="{{ route('backend.product-type.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i>
                Add New
            </a>
        </div>
        <div class="nb-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Product Type</a></div>
        </div>
    </div>
</div>
@endsection
@section('content')
<section class="section">
    @if (session()->has('flash_notification'))
    <div class="alert alert-{{ session()->get('flash_notification.level') }} alert-has-icon" id="alert">
        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
        <div class="alert-body">
            <button class="close" data-dismiss="#alert">
                <span>&times;</span>
            </button>
            <div class="alert-title">Info</div>
            {{ session()->get('flash_notification.message') }}
        </div>
    </div>
    @endif
    <div class="section-body">
        <div class="row mt-4">
            <div class="col-12">
                <div class="card" id="card-product-type">
                    <div class="card-header sticky-top bg-white">
                        <button href="#" class="btn btn-danger" id="deleteAll">
                            <i class="fas fa-trash"></i> Delete All
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped dt-responsive nowrap" style="width:100%" id="myTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Type</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
@include('backend.product-type._script')
@endsection