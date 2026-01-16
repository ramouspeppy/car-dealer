@extends('backend.layouts.app')
@section('title', 'Edit Testimony - '.config('settings.site_name'))
@section('breadcrumb')
<div class="nb">
    <div class="nb-header">
        <div class="nb-header-back">
            <a href="{{ route('backend.testimony.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Edit Testimony</h1>
        <div class="nb-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>Testimony</a>
        </div>
        <div class="breadcrumb-item">Edit Testimony</div>
    </div>
</div>
</div>
@endsection
@section('content')
<section class="section">
    <div class="section-body">
        <form action="{{ route('backend.testimony.update', $testimony ) }}" enctype="multipart/form-data" method="post">
            @method('put')
            @csrf
            <div class="row justify-content-center">
                @include('backend.testimony._form')
            </div>
        </form>
    </div>
</section>
@endsection