<script>
    $(function() {
        var table = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! url()->full() !!}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    class: 'fit'
                },
                {
                    data: 'title',
                    name: 'title',
                    class: 'font-weight-bold'
                },
                {
                    data: 'icon',
                    name: 'icon',
                    class: 'fit'
                },
                {
                    data: 'priority',
                    name: 'priority',
                    class: 'fit'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    class: 'fit text-center'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    class: 'fit'
                }
            ],
            'order': [
                [4, 'desc']
            ]
        });

        $(document.body).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var $form = $(this).closest('form');
            swal.fire({
                title: 'Are you sure?',
                html: "<p> You won't be able to revert this !</br>" +
                    "All your post will be move to Uncategorized </p>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, do it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.cardProgress('#card-post-category', {
                        dismiss: false
                    });
                    $form.submit();
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal.fire(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })

        });
    });
</script>
