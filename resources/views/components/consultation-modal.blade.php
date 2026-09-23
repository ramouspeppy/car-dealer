{{-- resources/views/components/ --}}

<!-- Consultation Modal -->
<div class="modal fade" id="consultationModal" tabindex="-1" aria-labelledby="consultationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header border-0 pb-0">

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body pt-2">
                <section id="consultation-form" class="consultation-form section" data-builder="section">

                    <slot type="section-title"></slot>

                    <div class="container">

                        <div class="row justify-content-between gy-4">

                            <div class="col-lg-4 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="100">
                                <div class="content">
                                    <h3>Konsultasi Mobil Gratis.</h3>
                                    <hr>
                                    <h4>Bingung pilih mobil yang cocok? Saya siap bantu</h4>
                                    <p>Ceritakan kebutuhan Anda—mulai dari budget, tipe mobil, hingga rencana cash atau
                                        kredit.
                                        Saya akan bantu rekomendasikan mobil terbaik sesuai kebutuhan Anda, tanpa ribet.
                                    </p>

                                </div>
                            </div>

                            <div class="col-lg-8" data-aos="zoom-out" data-aos-delay="200">
                                <form action="{{ route('consultation.store') }}" id="ask-question" method="POST" class=class="needs-validation @if ($errors->any()) was-validated @endif" novalidate>
                                    @csrf

                                    <div class="row gy-3">
                                        <div class="col-sm-6">
                                            <div class="field-wrap">
                                                <label>Nama <span class="text-danger">*</span></label>
                                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama sesuai KTP" class="form-control @error('name') is-invalid @enderror">
                                                <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i>
                                                    <span class="error-text"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="field-wrap">
                                                <label>Nomor Whatsapp <span class="text-danger">*</span></label>
                                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Nomor Whatsapp aktif" class="form-control @error('phone') is-invalid @enderror">
                                                <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i>
                                                    <span class="error-text"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="field-wrap">
                                                <label>Kota <span class="text-danger">*</span></label>
                                                <input type="text" name="city" value="{{ old('city') }}" placeholder="Kota Anda" class="form-control @error('city') is-invalid @enderror">
                                                <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i>
                                                    <span class="error-text"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="field-wrap">
                                                <label>Budget <span class="text-danger">*</span></label>
                                                <select name="budget" class="form-control selectric @error('budget') is-invalid @enderror">
                                                    <option value="">-- Pilih Budget --</option>
                                                    <option value="< 100 juta" {{ old('budget') == '< 100 juta' ? 'selected' : '' }}>
                                                        < 100 juta</option>
                                                    <option value="100 - 200 juta" {{ old('budget') == '100 - 200 juta' ? 'selected' : '' }}>100 - 200 juta</option>
                                                    <option value="200 - 300 juta" {{ old('budget') == '200 - 300 juta' ? 'selected' : '' }}>200 - 300 juta</option>
                                                    <option value="> 300 juta" {{ old('budget') == '> 300 juta' ? 'selected' : '' }}> >
                                                        300 juta</option>
                                                </select>
                                                <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i>
                                                    <span class="error-text"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="field-wrap">
                                                <label>Mobil yang diminati <span class="text-danger">*</span></label>
                                                <select name="product_id" data-in-modal data-placeholder="Pilih Mobil..." class="form-control select2 @error('product_id') is-invalid @enderror">
                                                    <option value="">-- Pilih Mobil --</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                            {{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i>
                                                    <span class="error-text"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="field-wrap">
                                                <label>Metode Pembayaran</label>
                                                <select name="payment_type" id="payment_type" class="form-control selectric @error('payment_type') is-invalid @enderror">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="cash" {{ old('payment_type') == 'cash' ? 'selected' : '' }}>Cash
                                                    </option>
                                                    <option value="credit" {{ old('payment_type') == 'credit' ? 'selected' : '' }}>Kredit
                                                    </option>
                                                </select>
                                                <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i>
                                                    <span class="error-text"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12" id="tenorField">
                                            <div class="field-wrap">
                                                <label>Tenor</label>
                                                <select name="tenor" class="form-control selectric @error('tenor') is-invalid @enderror">
                                                    <option value="">-- Pilih Tenor --</option>
                                                    <option value="12" {{ old('tenor') == '12' ? 'selected' : '' }}>12
                                                        bulan</option>
                                                    <option value="24" {{ old('tenor') == '24' ? 'selected' : '' }}>24
                                                        bulan</option>
                                                    <option value="36" {{ old('tenor') == '36' ? 'selected' : '' }}>36
                                                        bulan</option>
                                                    <option value="48" {{ old('tenor') == '48' ? 'selected' : '' }}>48
                                                        bulan</option>
                                                    <option value="60" {{ old('tenor') == '60' ? 'selected' : '' }}>60
                                                        bulan</option>
                                                </select>
                                                <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i>
                                                    <span class="error-text"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="field-wrap">
                                                <label>Pesan <span class="text-danger">*</span></label>
                                                <textarea name="message" rows="4" placeholder="Contoh: Butuh mobil keluarga, irit BBM" class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                                                <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i>
                                                    <span class="error-text"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit"><i class="bi bi-send"></i> Kirim Permintaan</button>
                                        </div>

                                    </div>
                                </form>
                            </div><!-- End Quote Form -->

                        </div>

                    </div>

                </section>
            </div>

        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(function() {

            const $tenorField = $('#tenorField');

            // setup awal
            if ($('#payment_type').val() !== 'credit') {
                $tenorField.hide();
            }

            let lastValue = $('#payment_type').val();

            setInterval(function() {
                let currentValue = $('#payment_type').val();

                if (currentValue !== lastValue) {
                    lastValue = currentValue;

                    if (currentValue === 'credit') {

                        // 🔥 DI SINI PERUBAHANNYA
                        $tenorField.stop(true, true).slideDown(250, function() {

                            const $tenorSelect = $(this).find('select');

                            if ($tenorSelect.data('selectric')) {
                                $tenorSelect.selectric('refresh');
                            }

                        });

                    } else {

                        $tenorField.stop(true, true).slideUp(200);
                    }
                }
            }, 200);

        });
    </script>
    <script>
        $(document).ready(function() {

            $('#ask-question').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let btn = form.find('button[type="submit"]');

                // 🔥 RESET SEMUA ERROR
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.selectric').removeClass('is-invalid');
                form.find('.error-text').text('');
                form.find('.invalid-feedback').hide();

                btn.text('Mengirim...').prop('disabled', true);

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),

                    success: function(res) {

                        form[0].reset();

                        resetAllSelects(form[0]);
                        $('#tenorField').stop(true, true).hide();

                        let url = res.wa_text;
                        window.open(url, '_blank');

                        setTimeout(() => {
                            btn.text('Kirim Permintaan').prop('disabled', false);
                        }, 2000);

                    },

                    error: function(xhr) {

                        btn.text('Kirim Permintaan').prop('disabled', false);

                        if (xhr.status === 422) {

                            let errors = xhr.responseJSON.errors;

                            $.each(errors, function(key, value) {

                                let input = form.find(`[name="${key}"]`);
                                let wrapper = input.closest('.field-wrap');

                                // 🔥 kasih invalid ke input asli
                                input.addClass('is-invalid');

                                // 🔥 tampilkan pesan
                                let feedback = wrapper.find('.invalid-feedback');

                                // kalau belum ada span, isi langsung
                                if (feedback.find('.error-text').length) {
                                    feedback.find('.error-text').text(value[0]);
                                } else {
                                    feedback.text(value[0]);
                                }

                                feedback.show();

                                // 🔥 FIX SELECTRIC (INI KUNCI UTAMA)
                                if (input.hasClass('selectric')) {
                                    wrapper.find('.selectric').addClass('is-invalid');
                                }

                                // 🔥 FIX SELECT2 (kalau ada)
                                if (input.hasClass('select2')) {
                                    wrapper.find('.select2-selection').addClass('is-invalid');
                                }

                            });

                        } else {
                            alert('Terjadi kesalahan, coba lagi');
                        }
                    }
                });

            });

        });
    </script>
@endpush
