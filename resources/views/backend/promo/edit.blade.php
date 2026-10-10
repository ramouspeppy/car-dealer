@extends('backend.layouts.app')
@section('title', 'Edit Promo - '.config('settings.site_name'))
@section('content')
@include('backend.layouts._notif')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('backend.promo.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Edit Promo</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('backend.promo.index') }}">Promo</a></div>
            <div class="breadcrumb-item">Edit Promo</div>
        </div>
    </div>

    <div class="section-body">
        <form action="{{ route('backend.promo.update', $promo ) }}" class="needs-validation" enctype="multipart/form-data"
            method="POST">
            @method('put')
            @csrf
            <div class="row justify-content-center">
                @include('backend.promo._form')
            </div>
        </form>
    </div>
</section>
@endsection