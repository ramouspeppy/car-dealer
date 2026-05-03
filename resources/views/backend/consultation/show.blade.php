@extends('backend.layouts.app')
@section('title', 'Konsultasi - '.config('settings.site_name'))
@section('breadcrumb')
<div class="nb">
    <div class="nb-header">
        <div class="nb-header-back">
            <a href="{{ route('backend.consultation.index') }}" class="btn btn-icon"><i
                    class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Konsultasi</h1>
        <div class="nb-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('backend.consultation.index') }}">Konsultasi</a></div>
            <div class="breadcrumb-item">Konsultasi</div>
        </div>
    </div>
</div>
@endsection
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card card-primary" id="consultation-card">
                    <div class="card-header">
                        <h4>Status :
                            <span
                                class="badge badge-{{ $consultation->status === 'new' ? 'success' : ($consultation->status === 'contacted' ? 'primary' : 'dark') }}"
                                id="status-badge">
                                {{ ucfirst($consultation->status) }}
                            </span>
                        </h4>
                        <div class="card-header-action">
                            <button class="btn btn-success btn-status" data-status="new">
                                <i class="fas fa-star me-1"></i> New
                            </button>
                            <button class="btn btn-primary btn-status" data-status="contacted">
                                <i class="fas fa-phone me-1"></i> Contacted
                            </button>
                            <button class="btn btn-dark btn-status" data-status="closed">
                                <i class="fas fa-check me-1"></i> Closed
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">Name</label>
                                    <input type="text" readonly class="form-control-plaintext border-bottom" id="name"
                                        name="name" value="{{  $consultation->name }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="phone">Phone / Whatsapp</label>
                                    <input type="text" readonly class="form-control-plaintext border-bottom" id="phone"
                                        name="phone" value="{{  $consultation->phone }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="city">Kota</label>
                                    <input type="text" readonly class="form-control-plaintext border-bottom" id="city"
                                        name="city" value="{{  $consultation->city }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="product">Product</label>
                                    <input type="text" readonly class="form-control-plaintext border-bottom"
                                        id="product" name="product" value="{{  $consultation->product->name ?? '-' }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="budget">Budget</label>
                                    <input type="text" readonly class="form-control-plaintext border-bottom" id="budget"
                                        name="budget" value="{{  $consultation->budget }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="budget">Budget</label>
                                    <input type="text" readonly class="form-control-plaintext border-bottom" id="budget"
                                        name="budget" value="{{  $consultation->budget }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="message">Pesan</label>
                                    <textarea type="text" readonly class="form-control-plaintext border-bottom"
                                        id="message" name="message">{{ $consultation->message }}</textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="source">Sumber</label>
                                    <input type="text" readonly class="form-control-plaintext border-bottom" id="source"
                                        name="source" value="{{  $consultation->source }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="ip_address">Alamat IP</label>
                                    <input type="text" readonly class="form-control-plaintext border-bottom"
                                        id="ip_address" name="ip_address" value="{{  $consultation->ip_address }}">
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
<div class="position-fixed p-3" style="z-index: 9999; right: 0; bottom: 0;">
    <div id="statusToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
        <div class="toast-header bg-success text-white" id="toast-header">
            <i class="fas fa-check-circle mr-2" id="toast-icon"></i>
            <strong class="mr-auto" id="toast-title">Notifikasi</strong>
            <small class="text-white">Baru saja</small>
            <button type="button" class="ml-2 mb-1 close text-white" onclick="$('#statusToast').toast('hide')" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
        </div>
        <div class="toast-body font-weight-bold" id="toast-message"></div>
    </div>
</div>
@endsection
@push('scripts')

<script>
    
    const statusUrl = '{{ route('backend.consultation.updateStatus', $consultation->id) }}';
    const csrfToken = '{{ csrf_token() }}';
    const badge     = document.getElementById('status-badge');

    const badgeColors = {
        new       : 'badge-success',
        contacted : 'badge-primary',
        closed    : 'badge-dark',
    };

    function showToast(message, success = true) {
        const header = document.getElementById('toast-header');
        const icon   = document.getElementById('toast-icon');

        header.className = 'toast-header text-white ' + (success ? 'bg-success' : 'bg-danger');
        icon.className   = 'fas mr-2 ' + (success ? 'fa-check-circle' : 'fa-times-circle');

        $('#toast-title').text(success ? 'Berhasil' : 'Gagal');
        $('#toast-message').text(message);
        $('#statusToast').toast('show');
    }

    document.querySelectorAll('.btn-status').forEach(btn => {
        btn.addEventListener('click', function () {
            const status = this.dataset.status;

            fetch(statusUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN' : csrfToken,
                    'Accept'       : 'application/json',
                    'Content-Type' : 'application/json',
                },
                body: JSON.stringify({ status }),
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    badge.className   = 'badge ' + (badgeColors[data.status] || 'badge-secondary');
                    badge.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                    showToast(data.message, true);
                }
            })
            .catch(() => {
                showToast('Gagal mengubah status, coba lagi.', false);
            });
        });
    });
</script>
@endpush