@extends('backend.layouts.app')
@section('title', 'Photo Delivery - ' . config('settings.site_name'))
@section('content')
    <section class="section photo-delivery-page">
        <div class="section-header">
            <h1>Photo Delivery</h1>
            <div class="section-header-button">
                <a href="{{ route('backend.photo-delivery.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                    Add New
                </a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Photo Delivery</a></div>
            </div>
        </div>
    
        @include('backend.layouts._notif')
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary" id="card-photo-delivery">
                        <div class="card-header sticky-top bg-white">
                            <div class="position-relative">
                                <button type="button" class="btn btn-danger" id="deleteAll">
                                    <i class="fas fa-trash"></i> Delete Selected
                                </button>
                            </div>
                            <div class="position-relative checkbox-container">
                                <div class="checkbox-wrapper-12">
                                    <div class="cbx">
                                        <input type="checkbox" id="chkCheckAll" />
                                        <label for="chkCheckAll"></label>
                                        <svg width="15" height="14" viewBox="0 0 15 14" fill="none">
                                            <path d="M2 8.36364L6.23077 12L13 2"></path>
                                        </svg>
                                    </div>
                                </div>
                                <label for="chkCheckAll" class="checkbox-label">Select All</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('backend.photo-delivery.index') }}" method="GET" class="photo-delivery-filter">
                                <div class="photo-delivery-filter-heading">
                                    <span class="photo-delivery-filter-icon"><i class="fas fa-sliders-h"></i></span>
                                    <div>
                                        <strong>Filter Foto</strong>
                                        <small>Kelompokkan berdasarkan produk</small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="filter-product-id">Produk</label>
                                    <select name="product_id" id="filter-product-id" class="form-control select2" aria-label="Filter by product">
                                        <option value="">Semua produk</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" {{ (string) $selectedProductId === (string) $product->id ? 'selected' : '' }}>
                                                {{ $product->name }} ({{ $product->photo_delivery_count }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="photo-delivery-filter-actions">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter"></i> Terapkan
                                    </button>
                                    @if ($selectedProductId)
                                        <a href="{{ route('backend.photo-delivery.index') }}" class="btn btn-light" aria-label="Reset filter" title="Reset filter">
                                            <i class="fas fa-undo"></i>
                                        </a>
                                    @endif
                                </div>
                            </form>
                            <div class="photo-delivery-filter-result">
                                <span>
                                    @if ($selectedProductId)
                                        Filter aktif: <strong>{{ $products->firstWhere('id', $selectedProductId)->name ?? 'Produk' }}</strong>
                                    @else
                                        Semua produk
                                    @endif
                                </span>
                                <span><strong>{{ number_format($deliveries->total()) }}</strong> foto</span>
                            </div>
                            <div class="row" id="photo-gallery">
                                @forelse ($deliveries as $delivery)
                                    @php $imageUrl = $delivery->getFirstMediaUrl('images'); @endphp
                                    <div class="col-6 col-sm-4 col-md-3 photo-delivery-container">
                                        <div class="photo-delivery">
                                            <img class="photo-delivery-image" src="{{ $imageUrl }}" alt="Photo delivery #{{ $delivery->id }}" loading="lazy">
                                            <a class="photo-delivery-lightbox" data-gallery="photo-delivery" href="{{ $imageUrl }}" title="Photo delivery #{{ $delivery->id }}" aria-label="Open photo delivery #{{ $delivery->id }}">
                                                <i class="fas fa-expand mg-icon-dv"></i>
                                            </a>
                                            <div class="checkbox-wrapper-12 checkbox-right">
                                                <div class="cbx">
                                                    <input type="checkbox" name="idDeliveries" class="checkbox-delivery" value="{{ $delivery->id }}" aria-label="Select photo delivery #{{ $delivery->id }}" />
                                                    <label></label>
                                                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none">
                                                        <path d="M2 8.36364L6.23077 12L13 2"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 photo-delivery-empty">
                                        <i class="fas fa-images"></i>
                                        <div>Belum ada foto delivery.</div>
                                    </div>
                                @endforelse
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Flip.min.js"></script>
    @include('backend.photo-delivery._script')
@endsection
