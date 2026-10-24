@extends('backend.layouts.app')
@section('title', 'Promo - '.config('settings.site_name'))
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Promo</h1>
        <div class="section-header-button">
            <a href="{{ route('backend.promo.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i>
                Add New
            </a>
        </div>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Promo</a></div>
        </div>
        @include('backend.websetting._frontend-toggle', ['toggles' => [
            ['key' => 'frontend_page_promos', 'label' => 'Tayangkan halaman Promo'],
            ['key' => 'frontend_section_promo_list', 'label' => 'Tayangkan section Promo di Beranda'],
        ]])
    </div>

    @include('backend.layouts._notif')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card" id="card-promo">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped dt-responsive nowrap" style="width:100%" id="myTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Promo</th>
                                        <th>Priority</th>
                                        <th>Effective Date</th>
                                        <th>Effective Status</th>
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
@include('backend.promo._script')
@endsection