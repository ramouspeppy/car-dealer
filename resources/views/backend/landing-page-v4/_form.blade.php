@php
    $faqs = $landingPage->faqs ?? [];
    $trustBadgesRaw = implode("\n", $landingPage->trust_badges ?? []);
@endphp

<div class="col-12">
    <div class="card" id="landing-page-v4-card">
        <div class="card-header sticky-top bg-white">
            <h4>
                Landing Page V2 Form
                <span class="badge {{ $landingPage->is_active ? 'badge-success' : 'badge-secondary' }} ml-2" id="active-badge">
                    {{ $landingPage->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </h4>
            <div class="card-header-action d-flex align-items-center">
                <label class="custom-switch mr-3 mb-0">
                    <input type="checkbox" class="custom-switch-input" id="is_active" name="is_active" value="1"
                        {{ old('is_active', $landingPage->is_active) ? 'checked' : '' }}>
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description ml-1">Tayangkan Halaman</span>
                </label>
                <button type="submit" class="btn btn-icon btn-primary"
                    onclick="$(this).addClass('btn-progress'); $.simpleCardProgress('#landing-page-v4-card')">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </div>

        <div class="card-body m-0 p-0">
            <nav>
                <div class="nav nav-tabs nav-justified" role="tablist">
                    <a class="nav-item nav-link border-left-0 active" data-toggle="tab" href="#tab-hero" role="tab">
                        <div class="tabs-title-wrap"><span class="fas fa-bullhorn"></span><strong>Hero &amp; CTA</strong></div>
                    </a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-promo-galeri" role="tab">
                        <div class="tabs-title-wrap"><span class="fas fa-images"></span><strong>Promo &amp; Galeri</strong></div>
                    </a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-produk" role="tab">
                        <div class="tabs-title-wrap"><span class="fas fa-car"></span><strong>Produk &amp; Testimoni</strong></div>
                    </a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-faq" role="tab">
                        <div class="tabs-title-wrap"><span class="fas fa-question-circle"></span><strong>FAQ &amp; Trust</strong></div>
                    </a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-form" role="tab">
                        <div class="tabs-title-wrap"><span class="fas fa-edit"></span><strong>Form Lead</strong></div>
                    </a>
                    <a class="nav-item nav-link border-right-0" data-toggle="tab" href="#tab-seo" role="tab">
                        <div class="tabs-title-wrap"><span class="fas fa-chart-line"></span><strong>SEO &amp; Tracking</strong></div>
                    </a>
                </div>
            </nav>

            <div class="tab-content">

                {{-- TAB HERO --}}
                <div class="tab-pane fade show active p-4" id="tab-hero" role="tabpanel">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Badge Kecil di Atas Judul</label>
                                <input type="text" class="form-control @error('hero_badge') is-invalid @enderror"
                                    name="hero_badge" placeholder="Contoh: Digital Showroom Premium"
                                    value="{{ old('hero_badge', $landingPage->hero_badge) }}">
                                @error('hero_badge')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="form-group">
                                <label class="form-control-label">Headline (Judul Utama) <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('headline') is-invalid @enderror"
                                    name="headline" rows="2" required>{{ old('headline', $landingPage->headline) }}</textarea>
                                <small class="text-muted">Boleh 2 baris (tekan Enter). Bungkus kata dengan <code>*tanda bintang*</code> untuk memberi warna hijau-lime menyala, contoh: <code>Beli Mobil Jadi *Lebih Cerdas*</code></small>
                                @error('headline')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">Subheadline</label>
                                <textarea class="form-control" name="subheadline" rows="2">{{ old('subheadline', $landingPage->subheadline) }}</textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Teks Tombol CTA Utama</label>
                                <input type="text" class="form-control" name="hero_cta_label"
                                    value="{{ old('hero_cta_label', $landingPage->hero_cta_label) }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Gambar Hero (opsional, kosongkan untuk pakai foto mobil unggulan)</label>
                                <x-jasni-bootstrap name="hero_image" :model="$landingPage->hero_image_url" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB PROMO & GALERI --}}
                <div class="tab-pane fade p-4" id="tab-promo-galeri" role="tabpanel">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Promo yang Ditampilkan (dengan countdown)</label>
                                <select class="form-control select2" name="promo_ids[]" multiple data-placeholder="Pilih promo (kosongkan = otomatis promo aktif)">
                                    @foreach($promos as $promo)
                                    <option value="{{ $promo->id }}" {{ in_array($promo->id, old('promo_ids', $landingPage->promo_ids ?? [])) ? 'selected' : '' }}>
                                        {{ $promo->promo }}
                                    </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Promo perlu isi <strong>Tanggal Efektif</strong> di menu Promo supaya countdown-nya tampil.</small>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Galeri yang Ditampilkan</label>
                                <select class="form-control select2" name="gallery_ids[]" multiple data-placeholder="Pilih galeri (kosongkan = otomatis galeri terbaru)">
                                    @foreach($galleries as $gallery)
                                    <option value="{{ $gallery->id }}" {{ in_array($gallery->id, old('gallery_ids', $landingPage->gallery_ids ?? [])) ? 'selected' : '' }}>
                                        {{ $gallery->title }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-secondary mb-0">
                                <i class="fas fa-info-circle mr-1"></i>
                                Section <strong>Layanan</strong> di halaman publik otomatis menampilkan SEMUA data dari menu
                                <strong>Service</strong> (urut sesuai priority), dan section <strong>Serah Terima Terbaru</strong>
                                otomatis menampilkan data terbaru dari menu <strong>Photo Delivery</strong>. Tidak perlu diatur di sini.
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB PRODUK & TESTIMONI --}}
                <div class="tab-pane fade p-4" id="tab-produk" role="tabpanel">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Produk Unggulan yang Ditampilkan</label>
                                <select class="form-control select2" name="featured_product_ids[]" multiple data-placeholder="Pilih produk (kosongkan = otomatis)">
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ in_array($product->id, old('featured_product_ids', $landingPage->featured_product_ids ?? [])) ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Item pertama jadi mobil utama (spotlight), sisanya jadi jajaran eksplorasi.</small>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Testimoni yang Ditampilkan</label>
                                <select class="form-control select2" name="testimony_ids[]" multiple data-placeholder="Pilih testimoni (kosongkan = otomatis)">
                                    @foreach($testimonies as $testimony)
                                    <option value="{{ $testimony->id }}" {{ in_array($testimony->id, old('testimony_ids', $landingPage->testimony_ids ?? [])) ? 'selected' : '' }}>
                                        {{ $testimony->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB FAQ & TRUST --}}
                <div class="tab-pane fade p-4" id="tab-faq" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">Trust Badges (satu baris satu badge)</label>
                                <textarea class="form-control" name="trust_badges_raw" rows="3"
                                    placeholder="1000+ Unit Terjual&#10;Bergaransi Resmi&#10;Proses Cepat 1 Hari">{{ old('trust_badges_raw', $trustBadgesRaw) }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr>
                            <label class="form-control-label d-flex justify-content-between align-items-center">
                                <span>Pertanyaan yang Sering Ditanyakan</span>
                                <button type="button" class="btn btn-sm btn-primary" id="add-faq"><i class="fas fa-plus"></i> Tambah</button>
                            </label>
                            <div id="faq-wrapper">
                                @forelse($faqs as $faq)
                                <div class="row faq-row align-items-start mb-2">
                                    <div class="col-4">
                                        <input type="text" class="form-control" name="faq_question[]" placeholder="Pertanyaan" value="{{ $faq['question'] ?? '' }}">
                                    </div>
                                    <div class="col-7">
                                        <textarea class="form-control" name="faq_answer[]" rows="1" placeholder="Jawaban">{{ $faq['answer'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-1">
                                        <button type="button" class="btn btn-icon btn-danger remove-row"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                                @empty
                                <div class="row faq-row align-items-start mb-2">
                                    <div class="col-4"><input type="text" class="form-control" name="faq_question[]" placeholder="Pertanyaan"></div>
                                    <div class="col-7"><textarea class="form-control" name="faq_answer[]" rows="1" placeholder="Jawaban"></textarea></div>
                                    <div class="col-1"><button type="button" class="btn btn-icon btn-danger remove-row"><i class="fas fa-trash"></i></button></div>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB FORM LEAD --}}
                <div class="tab-pane fade p-4" id="tab-form" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">Judul Section Form</label>
                                <input type="text" class="form-control" name="form_title"
                                    value="{{ old('form_title', $landingPage->form_title) }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">Subjudul Section Form</label>
                                <textarea class="form-control" name="form_subtitle" rows="2">{{ old('form_subtitle', $landingPage->form_subtitle) }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-secondary mb-0">
                                Nomor WhatsApp diambil otomatis dari menu <strong>Profile</strong>. Lead yang masuk dari form ini
                                otomatis tersimpan di menu <strong>Konsultasi</strong> (sama seperti Landing Page V1).
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB SEO & TRACKING --}}
                <div class="tab-pane fade p-4" id="tab-seo" role="tabpanel">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Meta Title</label>
                                <input type="text" class="form-control" name="meta_title"
                                    value="{{ old('meta_title', $landingPage->meta_title) }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Gambar OG (share ke sosmed)</label>
                                <x-jasni-bootstrap name="og_image" :model="$landingPage->og_image_url" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">Meta Description</label>
                                <textarea class="form-control" name="meta_description" rows="2">{{ old('meta_description', $landingPage->meta_description) }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">Tracking Script (Google Tag / Meta Pixel base code)</label>
                                <textarea class="form-control" style="font-family: monospace; font-size: 12px;" name="tracking_head_script" rows="4">{{ old('tracking_head_script', $landingPage->tracking_head_script) }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">Script Event Konversi (dijalankan saat form lead sukses terkirim)</label>
                                <textarea class="form-control" style="font-family: monospace; font-size: 12px;" name="tracking_conversion_script" rows="4">{{ old('tracking_conversion_script', $landingPage->tracking_conversion_script) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@section('script')
<script type="module">
    $(function () {
        function bindRemove() {
            $('.remove-row').off('click').on('click', function () {
                if ($('#faq-wrapper').find('.faq-row').length > 1) {
                    $(this).closest('.faq-row').remove();
                } else {
                    $(this).closest('.faq-row').find('input, textarea').val('');
                }
            });
        }
        bindRemove();

        $('#add-faq').on('click', function () {
            const row = $('#faq-wrapper .faq-row').first().clone();
            row.find('input, textarea').val('');
            $('#faq-wrapper').append(row);
            bindRemove();
        });

        $('#is_active').on('change', function () {
            const badge = $('#active-badge');
            if (this.checked) {
                badge.removeClass('badge-secondary').addClass('badge-success').text('Aktif');
            } else {
                badge.removeClass('badge-success').addClass('badge-secondary').text('Nonaktif');
            }
        });
    });
</script>
@endsection
