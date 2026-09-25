@php
    $usp = $landingPage->usp_items ?? [];
    $faqs = $landingPage->faqs ?? [];
    $trustBadgesRaw = implode("\n", $landingPage->trust_badges ?? []);
@endphp

<div class="col-12">
    <div class="card" id="landing-page-card">
        <div class="card-header sticky-top bg-white">
            <h4>
                Landing Page Form
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
                    onclick="$(this).addClass('btn-progress'); $.simpleCardProgress('#landing-page-card')">
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
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-usp" role="tab">
                        <div class="tabs-title-wrap"><span class="fas fa-shield-alt"></span><strong>Kenapa Pilih Kami</strong></div>
                    </a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-produk" role="tab">
                        <div class="tabs-title-wrap"><span class="fas fa-car"></span><strong>Produk &amp; Testimoni</strong></div>
                    </a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-faq" role="tab">
                        <div class="tabs-title-wrap"><span class="fas fa-question-circle"></span><strong>FAQ</strong></div>
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
                                    name="hero_badge" placeholder="Contoh: Promo Spesial Bulan Ini"
                                    value="{{ old('hero_badge', $landingPage->hero_badge) }}">
                                @error('hero_badge')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="form-group">
                                <label class="form-control-label">Headline (Judul Utama) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('headline') is-invalid @enderror"
                                    name="headline" required
                                    value="{{ old('headline', $landingPage->headline) }}">
                                @error('headline')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">Subheadline</label>
                                <textarea class="form-control" name="subheadline" rows="2"
                                    placeholder="Kalimat pendukung di bawah headline, buat 1-2 kalimat yang menjual">{{ old('subheadline', $landingPage->subheadline) }}</textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Teks Tombol CTA Utama</label>
                                <input type="text" class="form-control" name="hero_cta_label"
                                    placeholder="Chat Sekarang via WhatsApp"
                                    value="{{ old('hero_cta_label', $landingPage->hero_cta_label) }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Gambar Hero (mobil unggulan)</label>
                                <x-jasni-bootstrap name="hero_image" :model="$landingPage->hero_image_url" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB USP / TRUST --}}
                <div class="tab-pane fade p-4" id="tab-usp" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">Trust Badges (satu baris satu badge)</label>
                                <textarea class="form-control" name="trust_badges_raw" rows="3"
                                    placeholder="1000+ Unit Terjual&#10;Bergaransi Resmi&#10;Proses Cepat 1 Hari">{{ old('trust_badges_raw', $trustBadgesRaw) }}</textarea>
                                <small class="text-muted">Tampil sebagai baris kepercayaan di bawah tombol CTA hero.</small>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr>
                            <label class="form-control-label d-flex justify-content-between align-items-center">
                                <span>Poin Keunggulan (USP)</span>
                                <button type="button" class="btn btn-sm btn-primary" id="add-usp"><i class="fas fa-plus"></i> Tambah</button>
                            </label>
                            <div id="usp-wrapper">
                                @forelse($usp as $item)
                                <div class="row usp-row align-items-center mb-2">
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="usp_icon[]" placeholder="bi bi-check-circle" value="{{ $item['icon'] ?? '' }}">
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="usp_title[]" placeholder="Judul singkat" value="{{ $item['title'] ?? '' }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="usp_desc[]" placeholder="Deskripsi singkat" value="{{ $item['desc'] ?? '' }}">
                                    </div>
                                    <div class="col-1">
                                        <button type="button" class="btn btn-icon btn-danger remove-row"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                                @empty
                                <div class="row usp-row align-items-center mb-2">
                                    <div class="col-2"><input type="text" class="form-control" name="usp_icon[]" placeholder="bi bi-check-circle"></div>
                                    <div class="col-3"><input type="text" class="form-control" name="usp_title[]" placeholder="Judul singkat"></div>
                                    <div class="col-6"><input type="text" class="form-control" name="usp_desc[]" placeholder="Deskripsi singkat"></div>
                                    <div class="col-1"><button type="button" class="btn btn-icon btn-danger remove-row"><i class="fas fa-trash"></i></button></div>
                                </div>
                                @endforelse
                            </div>
                            <small class="text-muted">Icon pakai kelas Bootstrap Icons (yang dipakai di halaman publik), contoh: <code>bi bi-shield-check</code>, <code>bi bi-lightning-charge</code>, <code>bi bi-tags</code>. Cari nama lengkapnya di <a href="https://icons.getbootstrap.com/" target="_blank">icons.getbootstrap.com</a>.</small>
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
                                <small class="text-muted">Urutan pilih = urutan tampil. Kosongkan untuk otomatis pakai produk aktif prioritas teratas.</small>
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
                                <small class="text-muted">Kosongkan untuk otomatis tampilkan testimoni secara acak.</small>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Banner Promo (opsional)</label>
                                <select class="form-control select2" name="promo_id" data-placeholder="Tanpa promo">
                                    <option value="">Tanpa promo</option>
                                    @foreach($promos as $promo)
                                    <option value="{{ $promo->id }}" {{ old('promo_id', $landingPage->promo_id) == $promo->id ? 'selected' : '' }}>
                                        {{ $promo->promo }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB FAQ --}}
                <div class="tab-pane fade p-4" id="tab-faq" role="tabpanel">
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

                {{-- TAB FORM LEAD --}}
                <div class="tab-pane fade p-4" id="tab-form" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">Judul Section Form</label>
                                <input type="text" class="form-control" name="form_title"
                                    placeholder="Konsultasi Gratis, Dapatkan Penawaran Terbaik"
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
                                Nomor WhatsApp yang menerima chat diambil otomatis dari menu <strong>Profile</strong>. Semua lead yang masuk dari form ini otomatis tersimpan di menu <strong>Konsultasi</strong> dengan sumber "Landing Page".
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
                                <textarea class="form-control" style="font-family: monospace; font-size: 12px;" name="tracking_head_script" rows="4"
                                    placeholder="<!-- Tempel di sini script gtag.js / Meta Pixel dari Google Ads atau Meta Ads Manager -->">{{ old('tracking_head_script', $landingPage->tracking_head_script) }}</textarea>
                                <small class="text-muted">Dipasang otomatis di bagian &lt;head&gt; halaman landing page.</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">Script Event Konversi (dijalankan saat form lead sukses terkirim)</label>
                                <textarea class="form-control" style="font-family: monospace; font-size: 12px;" name="tracking_conversion_script" rows="4"
                                    placeholder="<!-- Contoh: gtag('event', 'conversion', {...}); atau fbq('track', 'Lead'); -->">{{ old('tracking_conversion_script', $landingPage->tracking_conversion_script) }}</textarea>
                                <small class="text-muted">Dipakai untuk melacak konversi Google Ads / Meta Ads setiap ada lead baru masuk.</small>
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
                if ($(this).closest('#usp-wrapper, #faq-wrapper').find('.usp-row, .faq-row').length > 1) {
                    $(this).closest('.usp-row, .faq-row').remove();
                } else {
                    $(this).closest('.usp-row, .faq-row').find('input, textarea').val('');
                }
            });
        }
        bindRemove();

        $('#add-usp').on('click', function () {
            const row = $('#usp-wrapper .usp-row').first().clone();
            row.find('input').val('');
            $('#usp-wrapper').append(row);
            bindRemove();
        });

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
