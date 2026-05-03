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
                    data: 'title',
                    name: 'title',
                    class: 'font-weight-bold'
                },
                {
                    data: 'author.username',
                    name: 'author.username'
                },
                {
                    data: 'post_category.title',
                    name: 'post_category.title'
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
                [4, 'desc']
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
                    $.cardProgress('#card-post', {
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
                        $.cardProgress('#card-post', {
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

        // force delete
        $(document.body).on('click', '.force-delete-btn', function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id')

            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.cardProgress('#card-post', {
                        dismiss: false
                    });
                    forceDeleteRow(id);
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal.fire(
                        'Cancelled',
                        'Your data is safe :)',
                        'info'
                    )
                }
            })
        });

        $('#forceDeleteAll').on('click', function (e) {
            e.preventDefault();

            if ($('#myTable input[type="checkbox"]:checked').length) {
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.cardProgress('#card-post', {
                            dismiss: false
                        });
                        forceDeleteDataAll();
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
        $('#restoreAll').on('click', function (e) {
            e.preventDefault();

            if ($('#myTable input[type="checkbox"]:checked').length) {
                swal.fire({
                    title: 'Are you sure?',
                    text: "Want to restore this data ?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, of course !',
                    cancelButtonText: 'No, cancel !',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.cardProgress('#card-post', {
                            dismiss: false
                        });
                        restoreAll();
                    } else if (result.dismiss === swal.DismissReason
                        .cancel) {
                        swal.fire(
                            'Cancelled',
                            'Your data its belongs where it should be',
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

        // restore 
        $(document.body).on('click', '.restore-btn', function (e) {
            e.preventDefault();
            var dataId = $(this).attr('data-id')

            swal.fire({
                title: 'Are you sure?',
                text: "Want to restore this data ?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, of course !',
                cancelButtonText: 'No, cancel !',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.cardProgress('#card-post', {
                        dismiss: false
                    });
                    restore(dataId);
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal.fire(
                        'Cancelled',
                        'Your data its belongs where it should be',
                        'info'
                    )
                }
            })
        });

        function deleteDataRow(dataId) {

            $.ajax({
                type: "POST",
                url: "{{ route('backend.post.destroy') }}",
                data: {
                    _method: "DELETE",
                    data: dataId
                },
                success: function (data) {
                    $.cardProgressDismiss('#card-post');
                    table.draw(false);
                    checkStatus();
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
                url: "{{ route('backend.post.destroy') }}",
                data: {
                    _method: "DELETE",
                    data: array_data
                },
                success: function (data) {
                    $.cardProgressDismiss('#card-post');
                    table.draw(false);
                    checkStatus();
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

        function forceDeleteRow(id) {

            $.ajax({
                type: "POST",
                url: "{{ route('backend.post.forceDestroy') }}",
                data: {
                    _method: "DELETE",
                    data: id
                },
                success: function (data) {
                    $.cardProgressDismiss('#card-post');
                    table.draw(false);
                    checkStatus();
                    if (data.msg) {
                        swal.fire({
                            title: 'Info !',
                            html: data.msg,
                            icon: 'info',
                        });
                    } else {
                        swal.fire({
                            title: 'Success !',
                            text: "Your data has been deleted for good !!",
                            icon: 'success',
                        });
                    }
                },
            });
        }

        function forceDeleteDataAll() {
            const form = this;
            const rows_selected = table.column(0).checkboxes.selected();
            const new_selection = rows_selected.join(",");
            const array_data = new_selection.split(',')
            $.ajax({
                type: "POST",
                url: "{{ route('backend.post.forceDestroy') }}",
                data: {
                    _method: "DELETE",
                    data: array_data
                },
                success: function (data) {
                    $.cardProgressDismiss('#card-post');
                    table.draw(false);
                    checkStatus();
                    if (data.msg) {
                        swal.fire({
                            title: 'Info !',
                            html: data.msg,
                            icon: 'info',
                        });
                    } else {
                        swal.fire({
                            title: 'Success !',
                            text: "Your data has been deleted for good !!",
                            icon: 'success',
                        });
                    }

                },
            });
        }

        function restore(data) {
            $.ajax({
                type: "POST",
                url: "{{ route('backend.post.restore') }}",
                data: {
                    data: data
                },
                success: function () {
                    $.cardProgressDismiss('#card-post');
                    table.draw(false);
                    checkStatus();
                    if (data.msg) {
                        swal.fire({
                            title: 'Info !',
                            html: data.msg,
                            icon: 'info',
                        });
                    } else {
                        swal.fire(
                            'Restored',
                            'Your data has been restored.',
                            'success'
                        );
                    }

                },
            });
        }

        function restoreAll() {
            const form = this;
            const rows_selected = table.column(0).checkboxes.selected();
            const new_selection = rows_selected.join(",");
            const array_data = new_selection.split(',')
            $.ajax({
                type: "POST",
                url: "{{ route('backend.post.restore') }}",
                data: {
                    data: array_data
                },
                success: function (data) {
                    $.cardProgressDismiss('#card-post');
                    table.draw(false);
                    checkStatus();
                    if (data.msg) {
                        swal.fire({
                            title: 'Info !',
                            html: data.msg,
                            icon: 'info',
                        });
                    } else {
                        swal.fire(
                            'Restored',
                            'Your data has been restored.',
                            'success'
                        );
                    }
                },
            });
        }

        function checkStatus() {
            $.get("{{ route('backend.post.checkStatus') }}",
                function (data) {
                    $('#statusAll').html(data.all);
                    $('#statusOwn').html(data.own);
                    $('#statusPublished').html(data.published);
                    $('#statusDraft').html(data.draft);
                    $('#statusScheduled').html(data.scheduled);
                    $('#statusTrash').html(data.trash);
                }
            );
        }

    });

</script>