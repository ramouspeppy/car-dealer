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
                    data: 'name',
                    name: 'name',
                    class: 'font-weight-bold'
                },
                {
                    data: 'product.name',
                    name: 'product.name',
                },
                {
                    data: 'payment_type',
                    name: 'payment_type',
                    class: 'fit'
                },

                {
                    data: 'phone',
                    name: 'phone',
                    class: 'fit'

                },
                {
                    data: 'source',
                    name: 'source',
                    class: 'fit'
                },
                {

                    data: 'status',
                    name: 'status',
                    class: 'fit'
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
                    class: 'fit'
                }
            ],
            'order': [
                [6, 'desc']
            ],
        });
    });
</script>
