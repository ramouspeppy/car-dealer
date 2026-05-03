<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            data: {
                _token: "{{ csrf_token() }}"
            }
        });
        var table = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! url()->full() !!}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'type',
                    name: 'type',
                    class: 'font-weight-bold'
                },
                {
                    data: 'product.name',
                    name: 'product.name'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'status',
                    name: 'status',
                    class: 'fit text-center',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    class: 'fit'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    class: "fit"
                }
            ],

            'columnDefs': [{
                'targets': 0,
                'render': function (data, type, row, meta) {
                    if (type === 'display') {
                        data =
                            '<div class="custom-checkbox custom-control"><input type="checkbox" class="dt-checkboxes custom-control-input"><label class="custom-control-label"></label></div>';
                    }
                    return data;
                },
                'checkboxes': {
                    'selectAll': true,
                    'selectAllRender': '<div class="custom-checkbox custom-control"><input type="checkbox" class="dt-checkboxes custom-control-input"><label class="custom-control-label"></label></div>'
                }
            }],
            'order': [
                [5, 'desc']
            ],
        });

        $(document.body).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            var dataId = $(this).attr('data-id')

            swal.fire({
                title: 'Are you sure?',
                text: "Move this data to the trash ?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, do it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.cardProgress('#card-product-type', {
                        dismiss: false
                    });
                    deleteDataRow(dataId);
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal.fire(
                        'Cancelled',
                        'Your data is safe :)',
                        'info'
                    )
                }
            })
        });

        $('#deleteAll').on('click', function (e) {
            e.preventDefault();

            if ($('#myTable input[type="checkbox"]:checked').length) {
                swal.fire({
                    title: 'Are you sure?',
                    text: "Move these data to the trash !",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.cardProgress('#card-product-type', {
                            dismiss: false
                        });
                        deleteDataAll();
                    } else if (result.dismiss === swal.DismissReason
                        .cancel) {
                        swal.fire(
                            'Cancelled',
                            'Your data is safe :)',
                            'info'
                        )
                    }
                })

            } else {
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'At least choose one data..!!',
                });
            }
        });


        function deleteDataRow(dataId) {

            $.ajax({
                type: "POST",
                url: "{{ route('backend.product-type.destroy') }}",
                data: {
                    _method: "DELETE",
                    data: dataId
                },
                success: function (data) {
                    $.cardProgressDismiss('#card-product-type');
                    table.draw(false);
                    if (data.msg) {
                        swal.fire({
                            title: 'Info !',
                            html: data.msg,
                            icon: 'info',
                        });
                    } else {
                        swal.fire({
                            title: 'Success !',
                            text: 'data hasbeen deleted',
                            icon: 'success',
                        });
                    }
                },

            });
        }

        function deleteDataAll() {
            const form = this;
            const rows_selected = table.column(0).checkboxes.selected();
            const new_selection = rows_selected.join(",");
            const array_data = new_selection.split(',')
            $.ajax({
                type: "POST",
                url: "{{ route('backend.product-type.destroy') }}",
                data: {
                    _method: "DELETE",
                    data: array_data
                },
                success: function (data) {
                    table.draw(false);
                    $.cardProgressDismiss('#card-product-type');
                    if (data.msg) {
                        swal.fire({
                            title: 'Info !',
                            html: data.msg,
                            icon: 'info',
                        });
                    } else {
                        table.draw(false);
                        swal.fire({
                            title: 'Success !',
                            text: 'data hasbeen deleted',
                            icon: 'success',
                        });
                    }

                },
            });
        }
    });

</script>