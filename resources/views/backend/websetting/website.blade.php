@extends('backend.layouts.app')
@section('title', 'Web Setting - ' . config('settings.site_name'))
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Web Setting</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Web Setting</div>
            </div>
        </div>
    
        @include('backend.layouts._notif')
        <div class="section-body">
            <form action="{{ route('backend.setting.update') }}" method="POST" enctype="multipart/form-data" id="setting-form">
                @csrf
                <input name="website" type="hidden" value="true">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary" id="website-card">
                            <div class="card-header sticky-top bg-white">
                                <h4>Welcome Form</h4>
                                <div class="card-header-action">
                                    <button class="btn btn-icon btn-primary" onclick="$(this).addClass('btn-progress'); $.simpleCardProgress('#website-card')"><i class="fas fa-save"></i> Update</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="site_name">Site Name</label>
                                            <input type="text" class="form-control @error('site_name') is-invalid @enderror" id="site_name" name="site_name" value="{{ old('site_name', $website->findValue('site_name')) }}">
                                            @error('site_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="site_brand">Site Brand</label>
                                            <input type="text" class="form-control @error('site_brand') is-invalid @enderror" id="site_brand" name="site_brand" value="{{ old('site_brand', $website->findValue('site_brand')) }}">
                                            @error('site_brand')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="site_title">Site Title</label>
                                            <input type="text" class="form-control @error('site_title') is-invalid @enderror" id="site_title" name="site_title" value="{{ old('site_title', $website->findValue('site_title')) }}">
                                            @error('site_title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="site_desc">Site Desc</label>
                                            <input type="text" class="form-control @error('site_desc') is-invalid @enderror" id="site_desc" name="site_desc" value="{{ old('site_desc', $website->findValue('site_desc')) }}">
                                            @error('site_desc')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="g_verif">Google Verification</label>
                                            <input type="text" class="form-control @error('g_verif') is-invalid @enderror" id="g_verif" name="g_verif" value="{{ old('g_verif', $website->findValue('g_verif')) }}">
                                            @error('g_verif')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="g_tag">Google Tag</label>
                                            <textarea type="text" class="form-control @error('g_tag') is-invalid @enderror" id="g_tag" name="g_tag">{{ old('g_tag', $website->findValue('g_tag')) }}</textarea>
                                            @error('g_tag')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="script">Script</label>
                                            <input type="text" class="form-control @error('script') is-invalid @enderror" id="script" name="script" value="{{ old('script', $website->findValue('script')) }}">
                                            @error('script')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3 text-center">
                                        <div class="form-group">
                                            <label class="form-control-label">Site Logo</label>
                                            <x-jasni-bootstrap name="site_logo" :model="asset(config('settings.site_logo'))" />
                                        </div>

                                    </div>
                                    <div class="col-12 col-md-3 text-center">
                                        <div class="form-group">
                                            <label class="form-control-label">Favicon</label>
                                            <x-jasni-bootstrap name="favicon" :model="asset(config('settings.favicon'))" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3 text-center">
                                        <div class="form-group">
                                            <label class="form-control-label">Open Graph Image</label>
                                            <x-jasni-bootstrap name="og_image" :model="asset(config('settings.og_image'))" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3 text-center">
                                        <div class="form-group">
                                            <label class="form-control-label">Footer Background</label>
                                            <x-jasni-bootstrap name="bg_footer" :model="asset(config('settings.bg_footer'))" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card card-primary" id="frontend-visibility-card">
                                        <div class="card-header sticky-top bg-white">
                                            <h4>Tayangan Frontend</h4>
                                            <div class="card-header-action">
                                                <button type="submit" class="btn btn-icon btn-primary" onclick="$(this).addClass('btn-progress'); $.simpleCardProgress('#frontend-visibility-card')"><i class="fas fa-save"></i> Simpan</button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p class="text-muted">Atur halaman yang dapat diakses dan section yang ditampilkan di frontend. Perubahan langsung disimpan ke web settings.</p>
                                            <h6>Halaman</h6>
                                            <div class="row">
                                                @foreach ($frontendPages as $key => $label)
                                                    @php($field = "frontend_page_{$key}")
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group form-check">
                                                            <input type="hidden" name="{{ $field }}" value="0">
                                                            <input type="checkbox" class="form-check-input" id="{{ $field }}" name="{{ $field }}" value="1" @if (filter_var(old($field, config("settings.{$field}", '1')), FILTER_VALIDATE_BOOLEAN)) checked @endif>
                                                            <label class="form-check-label" for="{{ $field }}">{{ $label }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <h6 class="mt-3">Section halaman utama dan footer</h6>
                                            <div class="row">
                                                @foreach ($frontendSections as $key => $label)
                                                    @php($field = "frontend_section_{$key}")
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group form-check">
                                                            <input type="hidden" name="{{ $field }}" value="0">
                                                            <input type="checkbox" class="form-check-input" id="{{ $field }}" name="{{ $field }}" value="1" @if (filter_var(old($field, config("settings.{$field}", '1')), FILTER_VALIDATE_BOOLEAN)) checked @endif>
                                                            <label class="form-check-label" for="{{ $field }}">{{ $label }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(function() {
            $.myCodeMirror('g_tag', 150);
            $.myCodeMirror('script', 150);
        });
    </script>
@endsection
