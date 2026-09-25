@extends('backend.layouts.app')
@section('title', 'Landing Page - '.config('settings.site_name'))
@section('breadcrumb')
<div class="nb">
    <div class="nb-header">
        <h1>Landing Page (Ads)</h1>
        <div class="nb-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Landing Page</div>
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
            Halaman ini tayang publik di <a href="{{ url('/promo-mobil') }}" target="_blank" class="font-weight-bold">{{ url('/promo-mobil') }}</a>
            &mdash; arahkan iklan Google Ads / Meta Ads / platform lain ke URL ini.
            Semua lead yang masuk dari form di halaman ini otomatis muncul di menu <a href="{{ route('backend.consultation.index') }}">Konsultasi</a>.
        </div>

        <form action="{{ route('backend.landing-page.update') }}" method="POST" enctype="multipart/form-data" id="landing-page-form">
            @csrf
            <div class="row">
                @include('backend.landing-page._form')
            </div>
        </form>
    </div>
</section>
@endsection
