<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('settings.site_name'))</title>
    <!-- Popperjs -->

    <link rel="stylesheet" href="{{ mix('backend/css/app.css') }}">
    @yield('css')


    <link rel="icon" href="{{ url(config('settings.favicon')) }}" type="image/png">

</head>

<body>
    <div id="app">
        @auth
            <div class="main-wrapper">
                <div class="navbar-bg "></div>
                @include('backend.layouts._nav')
                <div class="main-sidebar">
                    @include('backend.layouts._sidebar')
                </div>
                <!-- Main Content -->
                <div class="main-content">
                    @yield('content')
                </div>
                <footer class="main-footer">
                    <div class="footer-left">
                        Copyright &copy; 2021 <div class="bullet"></div> Design By Azza
                    </div>
                    <div class="footer-right">
                        2.3.0
                    </div>
                </footer>
            </div>
        @endauth

        @guest
            <div id="app">
                @yield('content')
            </div>
        @endguest

    </div>

    <script src="{{ mix('backend/js/app.js') }}"></script>
    <div class="position-fixed p-3" style="z-index: 9999; right: 0; bottom: 0;">
        <div id="frontendVisibilityToast" class="toast hide" role="status" aria-live="polite" aria-atomic="true" data-delay="3000">
            <div class="toast-header bg-success text-white">
                <i class="fas fa-check-circle mr-2 frontend-visibility-toast-icon"></i>
                <strong class="mr-auto frontend-visibility-toast-title">Berhasil</strong>
                <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body font-weight-bold frontend-visibility-toast-message"></div>
        </div>
    </div>
    <script>
        $(function() {
            function toSlug(value) {
                return value
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }

            $(document).on('input', '[data-slug-target]', function() {
                var $slug = $($(this).data('slug-target'));

                if (!$slug.length || ($slug.data('slug-manual') && $slug.val().trim() !== '')) {
                    return;
                }

                $slug.val(toSlug(this.value));
            });

            $(document).on('input', '[data-auto-slug]', function() {
                var source = document.querySelector($(this).data('auto-slug'));

                if (source) {
                    $(this).data('slug-manual', this.value !== toSlug(source.value));
                }
            });
        });

        $(function() {
            var $toast = $('#frontendVisibilityToast');
            $toast.toast({ delay: 3000 });

            function showVisibilityToast(message, success) {
                var $header = $toast.find('.toast-header');

                $header.toggleClass('bg-success', success).toggleClass('bg-danger', !success);
                $toast.find('.frontend-visibility-toast-icon')
                    .toggleClass('fa-check-circle', success)
                    .toggleClass('fa-times-circle', !success);
                $toast.find('.frontend-visibility-toast-title').text(success ? 'Berhasil' : 'Gagal');
                $toast.find('.frontend-visibility-toast-message').text(message);
                $toast.toast('show');
            }

            function updateVisibilityStatus($row, active) {
                var $status = $row.find('.frontend-visibility-status');

                $status.text($status.data(active ? 'active-text' : 'inactive-text') || (active ? 'Tayangan aktif' : 'Tayangan nonaktif'));
                if ($status.hasClass('badge')) {
                    $status.toggleClass('badge-success', active).toggleClass('badge-secondary', !active);
                }
                $row.find('.frontend-visibility-label').text(active ? 'Aktif' : 'Nonaktif');
            }

            $(document).on('change', '.frontend-visibility-toggle', function() {
                var toggle = this;
                var $toggle = $(toggle);
                var isActive = toggle.checked;
                var previousValue = !isActive;
                var $row = $toggle.closest('.frontend-visibility-row');

                toggle.disabled = true;
                $row.find('.frontend-visibility-status').text('Menyimpan...');

                fetch($toggle.data('url'), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        key: $toggle.data('setting-key'),
                        active: isActive,
                    }),
                })
                    .then(function(response) {
                        return response.json().then(function(data) {
                            if (!response.ok || !data.success) {
                                throw new Error(data.message || 'Gagal menyimpan pengaturan tayang.');
                            }

                            return data;
                        });
                    })
                    .then(function(data) {
                        updateVisibilityStatus($row, data.active);
                        showVisibilityToast(data.message, true);
                    })
                    .catch(function(error) {
                        toggle.checked = previousValue;
                        updateVisibilityStatus($row, previousValue);
                        showVisibilityToast(error.message || 'Terjadi kesalahan saat menyimpan pengaturan.', false);
                    })
                    .then(function() {
                        toggle.disabled = false;
                    });
            });
        });
    </script>

    @yield('script')
    @stack('scripts')


    <!-- Page Specific JS File -->
</body>

</html>
