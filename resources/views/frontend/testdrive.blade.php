@extends('frontend.layouts.app')

@section('content')
    <div class="page-title dark-background" data-builder="page-title">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">TestDrive</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="current">TestDrive</li>
                </ol>
            </nav>
        </div>
    </div>

    <section id="tesdrive-section" class="tesdrive-section section">

        <slot type="section-title"></slot>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="testdrive-wrapper">
                <div class="row align-items-center">
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="testdrive-content">
                            <h2>Testdrive bikin keputusan jadi lebih mudah.</h2>
                            <p>Kami tahu membeli mobil bukan keputusan kecil. Karena itu, kami ingin Anda benar-benar yakin.
                                Melalui test drive, Anda dapat merasakan performa dan kenyamanan secara langsung, tanpa
                                tekanan, tanpa terburu-buru.</p>
                            <div class="testdrive-stats">
                                <div class="stat-item">
                                    <span class="number"><span data-purecounter-start="0" data-purecounter-end="{{ $profile->project_number }}" data-purecounter-duration="1" class="purecounter"></span>+</span>
                                    <span class="text">Delivery Order</span>
                                </div>
                                <div class="stat-item">
                                    <span class="number"><span data-purecounter-start="0" data-purecounter-end="{{ $profile->client_number }}" data-purecounter-duration="1" class="purecounter">98</span>%</span>
                                    <span class="text">Pelanggan Puas</span>
                                </div>
                                <div class="stat-item">
                                    <span class="number"><span data-purecounter-start="0" data-purecounter-end="{{ $profile->experience_number }}" data-purecounter-duration="1" class="purecounter">10</span>+</span>
                                    <span class="text">Tahun Pengalaman</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="testdrive-form">
                            <h3>Yuk, Jadwalkan Test Drive Anda</h3>
                            <p>Isi formulir di bawah ini, dan saya akan bantu atur jadwal test drive sesuai waktu yang
                                nyaman untuk Anda.</p>
                            <form action="{{ route('testdrive.store') }}" method="post" id="testdrive-form">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Nama" id="name">
                                    <div class="invalid-feedback" id="error-name"></div>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="text" class="form-control" name="email" placeholder="Email (opsional)" id="email">
                                    <div class="invalid-feedback" id="error-email"></div>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="text" class="form-control" name="wa" placeholder="Nomor Whatsapp" id="wa">
                                    <div class="invalid-feedback" id="error-wa"></div>
                                </div>
                                <div class="form-group mt-3">
                                    <select class="form-control select2" name="product" id="product" data-placeholder="Pilih Mobil TestDrive">
                                        <option value=""></option> <!-- harus ada & kosong -->
                                        @foreach ($products as $product)
                                            <option value="{{ $product->slug }}" {{ old('product') == $product->slug ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="error-product"></div>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="text" class="form-control datepicker" datepicker-min="today" datepicker-body="modal" datepicker-closeonblur="true" datepicker-format="DD MMM YYYY" name="schedule_date" placeholder="Jadwal Testdrive" id="schedule_date">
                                    <div class="invalid-feedback" id="error-schedule_date"></div>
                                </div>
                                <div class="form-group mt-3">
                                    <textarea name="note" class="form-control" id="note" cols="30" rows="10" placeholder="Catatan" id="note"></textarea>
                                    <div class="invalid-feedback" id="error-note"></div>
                                </div>
                                <div class="text-center mt-3">
                                    <button type="submit">Get Started</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="services" class="services section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Kenapa Harus Memilih Saya Sebagai Sales Suzuki Anda?</h2>
            <p>Saya percaya membeli mobil bukan hanya soal transaksi, tapi tentang kepercayaan, kenyamanan, dan pengalaman
                terbaik untuk Anda.</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="service-header">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <div class="service-intro">
                            <h2 class="service-heading">
                                <div>Solusi Lengkap untuk Beli Mobil Suzuki</div>
                            </h2>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="service-summary">
                            <p>
                                Saya selalu berkomitmen memberikan layanan menyeluruh untuk memastikan Anda mendapatkan
                                mobil Suzuki impian dengan pengalaman pembelian yang mudah, cepat, dan menyenangkan.
                            </p>
                            <a href="" class="service-btn">
                                View All Products
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                @foreach ($services as $service)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-card position-relative z-1">
                            <div class="service-icon">
                                <i class="bi {{ $service->icon }}"></i>
                            </div>
                            <span class="card-action d-flex align-items-center justify-content-center rounded-circle">
                                <i class="bi bi-check-lg"></i>
                            </span>
                            <h3>
                                <span>
                                    {{ $service->title }}
                                </span>
                            </h3>
                            <p>{{ $service->desc }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section><!-- /Services Section -->

    @push('scripts')
        <script>
            $(function() {
                $("#testdrive-form").on('submit', function(e) {
                    e.preventDefault();

                    let form = $(this);
                    let formData = new FormData(this);

                    // clear error dulu
                    form.find('.form-control').removeClass('is-invalid');
                    form.find('.invalid-feedback').text('');
                    cardProgress('.testdrive-form');

                    $.ajax({
                        url: form.attr('action'),
                        method: form.attr('method'),
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(data) {
                            if (data.status == 0) {
                                $.each(data.errors, function(key, val) {
                                    $("#" + key).addClass('is-invalid'); // tambahkan bootstrap class
                                    $("#error-" + key).text(val[0]); // tampilkan pesan error
                                });
                                cardProgressDismiss('.testdrive-form');
                            } else {
                                form[0].reset();
                                cardProgressDismiss('.testdrive-form');
                                swalGlass({
                                    title: 'Berhasil!',
                                    html: 'Terimakasih telah mengisi formulir, <i class="d-block mt-2 white">Ingin melanjutkan konfirmasi melalui WhatsApp agar proses lebih cepat?</i>',
                                    icon: 'success',
                                    cancelButtonText: 'Nanti saja',
                                    confirmButtonText: 'Ya, Kirim ke WhatsApp',
                                    showCancelButton: true
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.open(data.url, '_blank');
                                    }
                                });
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
