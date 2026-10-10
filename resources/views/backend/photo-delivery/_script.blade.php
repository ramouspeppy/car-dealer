<script>
    $(function() {
        let photoDeliveryLightbox = null;

        function initPhotoDeliveryLightbox() {
            if (typeof window.GLightbox !== 'function') {
                console.error('GLightbox is not loaded.');
                return;
            }

            photoDeliveryLightbox = window.GLightbox({
                selector: '.photo-delivery-lightbox',
                loop: true,
                touchNavigation: true
            });
        }

        function refreshPhotoDeliveryLightbox() {
            if (photoDeliveryLightbox) {
                photoDeliveryLightbox.reload();
            } else {
                initPhotoDeliveryLightbox();
            }
        }

        if (window.gsap && window.Flip) {
            window.gsap.registerPlugin(window.Flip);
        }

        initPhotoDeliveryLightbox();

        $('#chkCheckAll').on('change', function() {
            $('.checkbox-delivery').prop('checked', $(this).prop('checked'));
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            data: {
                _token: "{{ csrf_token() }}"
            }
        });

        $('#deleteAll').on('click', function(e) {
            e.preventDefault();

            if (!$('input:checkbox[name=idDeliveries]:checked').length) {
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'At least choose one data..!!'
                });
                return;
            }

            swal.fire({
                title: 'Are you sure?',
                text: 'Move these data to the trash!',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.cardProgress('#card-photo-delivery', {
                        dismiss: false
                    });
                    deleteDataAll();
                }
            });
        });

        function deleteDataAll() {
            const allIds = [];

            $('input:checkbox[name=idDeliveries]:checked').each(function() {
                allIds.push($(this).val());
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('backend.photo-delivery.destroy') }}",
                data: {
                    _method: 'DELETE',
                    data: allIds
                },
                success: function(data) {
                    $.cardProgressDismiss('#card-photo-delivery');

                    if (data.msg) {
                        swal.fire({
                            title: 'Info!',
                            html: data.msg,
                            icon: 'info'
                        });
                        return;
                    }

                    const state = window.Flip && window.gsap ?
                        window.Flip.getState('.photo-delivery-container') :
                        null;

                    if (photoDeliveryLightbox) {
                        photoDeliveryLightbox.close();
                    }

                    $('.checkbox-delivery:checked').each(function() {
                        $(this).closest('.photo-delivery-container').remove();
                    });

                    $('#chkCheckAll').prop('checked', false);

                    const gallery = document.querySelector('#photo-gallery');
                    if (!gallery.querySelector('.photo-delivery-container')) {
                        const emptyState = document.createElement('div');
                        emptyState.className = 'col-12 photo-delivery-empty';
                        emptyState.innerHTML = '<i class="fas fa-images"></i><div>Belum ada foto delivery.</div>';
                        gallery.appendChild(emptyState);
                    }

                    if (state) {
                        window.Flip.from(state, {
                            duration: 0.5,
                            ease: 'power1.inOut',
                            stagger: 0.05,
                            onComplete: refreshPhotoDeliveryLightbox
                        });
                    } else {
                        refreshPhotoDeliveryLightbox();
                    }
                },
                error: function() {
                    $.cardProgressDismiss('#card-photo-delivery');
                    swal.fire({
                        title: 'Error!',
                        html: 'Gagal menghapus data. Silakan coba lagi.',
                        icon: 'error'
                    });
                }
            });
        }
    });
</script>
