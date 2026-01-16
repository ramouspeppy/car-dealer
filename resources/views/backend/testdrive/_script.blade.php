<script>
    $(function () {
        
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
                    name: 'name'
                },
                {
                    data: 'product',
                    name: 'product',
                    
                },
                {
                    data: 'schedule_date',
                    name: 'schedule_date',
                },
                {
                    data: 'wa',
                    name: 'wa',
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
                [4, 'desc']
            ],
        });
    });

</script>