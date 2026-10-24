@extends('backend.layouts.app')
@section('title', 'Gallery - '.config('settings.site_name'))
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Contact</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Contact</a></div>
        </div>
        <div class="section-header-button d-flex align-items-center">
            @include('backend.websetting._frontend-toggle', ['toggles' => [
                ['key' => 'frontend_page_contact', 'label' => 'Tayangkan halaman Kontak'],
                ['key' => 'frontend_section_contact', 'label' => 'Tayangkan section Kontak di Beranda'],
            ]])
        </div>
    </div>

    @include('backend.layouts._notif')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card" id="card-contact">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped dt-responsive nowrap" style="width:100%" id="myTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Name</th>
                                        <th>Subject</th>
                                        <th>Email</th>
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
@include('backend.contact._script')
@endsection