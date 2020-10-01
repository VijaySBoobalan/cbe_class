<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var SubjectTable= $('#SubjectTable').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        autoWidth: false,
        ajax: '{{ route("QuestionIndex") }}',
        "columns": [
            { data: 'DT_RowIndex' },
            { data: 'class' },
            { data: 'subjects' },
            { data: 'action', orderable: false, searchable: false },
        ]
    });

    var ViewSubjectTable= $('#ViewSubjectTable').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        autoWidth: false,
        ajax: '{{ route("QuestionSubjects") }}',
        "columns": [
            { data: 'DT_RowIndex' },
            { data: 'class' },
            { data: 'subjects' },
            { data: 'action', orderable: false, searchable: false },
        ]
    });

    dataTable();
    function dataTable() {
        QuestionTable= $('#QuestionTable').DataTable({
            dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
            processing: true,
            serverSide: false,
            responsive: true,
            autoWidth: false,
            "bDestroy": true,
            buttons: [
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: [':visible:not(:last-child)']
                    },
                    className: 'btn btn-primary'
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [':visible:not(:last-child)']
                    },
                    className: 'btn btn-primary'
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [':visible:not(:last-child)']
                    },
                    className: 'btn btn-primary'
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [':visible:not(:last-child)']
                    },
                    className: 'btn btn-primary'
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [':visible:not(:last-child)']
                    },
                    className: 'btn btn-primary'
                }
            ],
        });
    }

    // $(document).ready(function() {
    //     $('.chosen-select').chosen({
    //         placeholder_text_single: "Select Project/Initiative...",
    //         no_results_text: "Oops, nothing found!"
    //     });
    // });


</script>
