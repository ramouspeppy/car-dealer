@extends('backend.layouts.app')
@section('title', 'Landing Page V4 - '.config('settings.site_name'))
@section('breadcrumb')
<div class="nb">
    <div class="nb-header">
        <h1>Landing Page V4</h1>
        <div class="nb-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Landing Page V4</div>
        </div>
    </div>
</div>
@endsection
@section('content')
<section class="section">
    @include('backend.layouts._notif')

    <div class="section-body">
        <div class="alert alert-primary">
            <i class="fas fa-info-circle mr-1"></i>
            Halaman ini CMS terpisah dari menu <strong>Landing Page</strong> (V1), <strong>Landing Page V2</strong>, dan <strong>Landing Page V3</strong>. Tayang publik di
            <a href="{{ url('/promo-mobil-v4') }}" target="_blank" class="font-weight-bold">{{ url('/promo-mobil-v4') }}</a>.
            Section Layanan otomatis ambil semua data dari menu <strong>Service</strong>, dan section "Serah Terima Terbaru"
            otomatis ambil dari menu <strong>Photo Delivery</strong>, jadi tidak perlu dipilih manual di sini.
        </div>

        <form action="{{ route('backend.landing-page-v4.update') }}" method="POST" enctype="multipart/form-data" id="landing-page-v4-form">
            @csrf
            <div class="row">
                @include('backend.landing-page-v4._form')
            </div>
        </form>
    </div>
</section>
@endsection
