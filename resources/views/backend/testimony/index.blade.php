@extends('backend.layouts.app')
@section('title', 'Testimony - '.config('settings.site_name'))
@section('breadcrumb')
<div class="nb">
    <div class="nb-header">
        <h1>Testimony</h1>
        <div class="nb-header-button">
            <a href="{{ route('backend.testimony.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i>
                Add New
            </a>
        </div>
        <div class="nb-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Testimony</a></div>
        </div>
    </div>
</div>
@endsection
@section('content')
<section class="section">
    @include('backend.layouts._notif')
    <div class="section-body">

        <div class="card card-primary" id="testimony-card">
            <div class="card-body m-0 p-0">
                <nav>
                    <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link border-left-0 active" id="nav-testimony-tab" data-toggle="tab"
                            href="#testimony" role="tab" aria-controls="nav-testimony" aria-selected="true">
                            <div class="tabs-title-wrap">
                                <span class="fas fa-edit"></span>
                                <strong>Main Header</strong>
                            </div>
                        </a>
                        <a class="nav-item border-right-0 nav-link" id="nav-testimony-bg-tab" data-toggle="tab"
                            href="#testimony-bg" role="tab" aria-controls="nav-testimony-bg" aria-selected="false">
                            <div class="tabs-title-wrap">
                                <span class="fas fa-edit"></span>
                                <strong>Testimony Background</strong>
                            </div>
                        </a>
                    </div>
                </nav>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="testimony" role="tabpanel"
                        aria-labelledby="testimony-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped dt-responsive nowrap" style="width:100%"
                                                id="myTable">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Name</th>
                                                        <th>Job</th>
                                                        <th>Rating</th>
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
                    <div class="tab-pane fade" id="testimony-bg" role="tabpanel" aria-labelledby="testimony-bg-tab">
                        <form action="{{ route('backend.setting.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input name="testimony" type="hidden" value="true">
                            <div class="row">
                                @include('backend.testimony._form_bg')
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
@include('backend.testimony._script')
@endsection