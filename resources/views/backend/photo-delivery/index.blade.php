@extends('backend.layouts.app')
@section('title', 'Photo Delivery - '.config('settings.site_name'))
@section('breadcrumb')
<div class="nb">
    <div class="nb-header">
        <h1>Photo Delivery</h1>
        <div class="nb-header-button">
            <a href="{{ route('backend.photo-delivery.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i>
                Add New
            </a>
        </div>
        <div class="nb-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Photo Delivery</a></div>
        </div>
    </div>
</div>
@endsection
@section('content')
<section class="section">
    @include('backend.layouts._notif')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary" id="card-photo-delivery">
                    <div class="card-header sticky-top bg-white">
                        <div class="position-relative">
                            <btn href="#" class="btn btn-danger" id="deleteAll">
                                <i class="fas fa-trash"></i> Delete All
                            </btn>
                        </div>
                        <div class="position-relative checkbox-container">
                            <div class="checkbox-wrapper-12">
                                <div class="cbx">
                                    <input type="checkbox" id="chkCheckAll" />
                                    <label for="chkCheckAll"></label>
                                    <svg width="15" height="14" viewbox="0 0 15 14" fill="none">
                                        <path d="M2 8.36364L6.23077 12L13 2"></path>
                                    </svg>
                                </div>
                            </div>
                            <label for="chkCheckAll" class="checkbox-label" for>Check All</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row" id="photo-gallery">
                            @foreach ($deliveries as $delivery)
                            <div class="col-6 col-sm-4 col-md-3 nopad photo-delivery-container">
                                <div class="photo-delivery"
                                    style="background-image: url('{{ $delivery->getFirstMediaUrl('images') }}')">
                                    <a class="chocolat-image" href="{{ $delivery->getFirstMediaUrl('images') }}"
                                        title="caption image 2">
                                        <i class="fas fa-expand mg-icon-dv"></i>
                                    </a>
                                    <div class="checkbox-wrapper-12 checkbox-right">
                                        <div class="cbx">
                                            <input type="checkbox" name="idDeliveries" class="checkbox-delivery"
                                                value="{{ $delivery->id }}" />
                                            <label for="cbx-12"></label>
                                            <svg width="15" height="14" viewbox="0 0 15 14" fill="none">
                                                <path d="M2 8.36364L6.23077 12L13 2"></path>
                                            </svg>
                                        </div>
                                        <!-- Gooey-->
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
                                            <defs>
                                                <filter id="goo-12">
                                                    <fegaussianblur in="SourceGraphic" stddeviation="4" result="blur">
                                                    </fegaussianblur>
                                                    <fecolormatrix in="blur" mode="matrix"
                                                        values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 22 -7"
                                                        result="goo-12"></fecolormatrix>
                                                    <feblend in="SourceGraphic" in2="goo-12"></feblend>
                                                </filter>
                                            </defs>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $deliveries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
@include('backend.photo-delivery._script')
@endsection