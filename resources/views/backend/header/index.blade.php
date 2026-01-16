@extends('backend.layouts.app')
@section('title', 'Header - '.config('settings.site_name'))
@section('breadcrumb')
<div class="nb">
    <div class="nb-header">
        <div class="nb-header-back">
            <a href="#" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Header</h1>
        <div class="nb-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Header</div>
        </div>
    </div>
</div>
@endsection
@section('content')
<section class="section">
    @include('backend.layouts._notif')
    <div class="section-body">
        <div class="card card-primary" id="header-card">
            <div class="card-body m-0 p-0">
                <nav>
                    <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link border-left-0 active" id="nav-main-header-tab" data-toggle="tab"
                            href="#main-header" role="tab" aria-controls="nav-main-header" aria-selected="true">
                            <div class="tabs-title-wrap">
                                <span class="fas fa-edit"></span>
                                <strong>Main Header</strong>
                            </div>
                        </a>
                        <a class="nav-item border-right-0 nav-link" id="nav-other-header-tab" data-toggle="tab"
                            href="#other-header" role="tab" aria-controls="nav-other-header" aria-selected="false">
                            <div class="tabs-title-wrap">
                                <span class="fas fa-edit"></span>
                                <strong>Other Page Background</strong>
                            </div>
                        </a>
                    </div>
                </nav>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="main-header" role="tabpanel"
                        aria-labelledby="main-header-tab">
                        <form action="{{ route('backend.header.update') }}" method="POST" enctype="multipart/form-data"
                            id="header-form">
                            @csrf
                            <div class="row">
                                @include('backend.header._form')
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="other-header" role="tabpanel" aria-labelledby="other-header-tab">
                        <form action="{{ route('backend.setting.update') }}" method="POST" enctype="multipart/form-data"
                            id="header-form">
                            @csrf
                            <input name="header" type="hidden" value="true">

                            <div class="row">
                                @include('backend.header._form_other')
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection