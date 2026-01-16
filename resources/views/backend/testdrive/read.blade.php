@extends('backend.layouts.app')
@section('title', 'Read Testdrive Detail - '.config('settings.site_name'))
@section('breadcrumb')
<div class="nb">
    <div class="nb-header">
        <div class="nb-header-back">
            <a href="{{ route('backend.testdrive.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Read Testdrive Detail</h1>
        <div class="nb-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('backend.testdrive.index') }}">Testdrive</a></div>
            <div class="breadcrumb-item">Read Testdrive Detail</div>
        </div>
    </div>
</div>
@endsection
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card card-primary" id="testdrive-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="title">Name</label>
                                    <input type="text" readonly class="form-control-plaintext border-bottom" id="name"
                                        name="title" value="{{  $testdrive->name }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="title">Whatsapp</label>
                                    <input type="text" readonly class="form-control-plaintext border-bottom" id="wa"
                                        name="title" value="{{  $testdrive->wa }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="product">Product</label>
                                    <input type="text" readonly class="form-control-plaintext border-bottom"
                                        id="product" name="product" value="{{  $testdrive->product }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="schedule_date">Jadwal</label>
                                    <input type="text" readonly class="form-control-plaintext border-bottom"
                                        id="schedule_date" name="schedule_date" value="{{  $testdrive->schedule_date }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="note">Catatan</label>
                                    <input type="text" readonly class="form-control-plaintext border-bottom"
                                        id="note" name="note" value="{{  $testdrive->note }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection