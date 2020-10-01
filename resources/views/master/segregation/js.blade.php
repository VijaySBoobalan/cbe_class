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
        ajax: '{{ route("SegregationIndex") }}',
        "columns": [
            { data: 'DT_RowIndex' },
            { data: 'question_name' },
            { data: 'segregation' },
            { data: 'action', orderable: false, searchable: false },
        ]
    });

    var SegregationTable= $('#SegregationTable').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        autoWidth: false,
        ajax: '{{ route("SegregationIndex") }}',
        "columns": [
            { data: 'DT_RowIndex' },
            { data: 'question_type' },
            { data: 'segregation' },
            { data: 'action', orderable: false, searchable: false },
        ]
    });

    var SegregationId="";
    $( document ).ready(function() {
        $('.AddSegregation').on('click',function (e) {
            var form = $( "#AddSegregationForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("Segregationstore") }}',
                    data:$('#AddSegregationForm').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if(data.status == 'error'){
                            $("#AddSegregationForm").valid().showErrors(data.errors);
                        }else{
                            $('#AddSegregationModal').modal('hide');
                            $('.question_type_id').val('').trigger("chosen:updated");
                            SegregationTable.ajax.reload();
                            $("#AddSegregationForm")[0].reset();
                        }
                    }
                });
            }
        });

        $('body').on('click','.EditSegregation',function (e) {
            e.preventDefault();
            var segregation_id = $(this).attr('id');
            if(segregation_id != ''){
                $.ajax({
                    type: "get",
                    url: '{{ route("Segregationedit") }}',
                    data:{segregation_id:segregation_id},
                    success: function(data) {
                        if(data.status == 'success'){
                            $('.segregation_id').val(data.Segregation.id);
                            $('.question_type_id').val(data.Segregation.question_type_id).trigger("chosen:updated");
                            $('.segregation').val(data.Segregation.segregation);
                        }else{
                            $('#editSegregationModal').modal('hide');
                        }
                    }
                });
            }
        });


        $('body').on('click','.UpdateSegregation',function (e) {
            var form = $( "#UpdateSegregationForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();

            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("SegregationUpdate") }}',
                    data:$('#UpdateSegregationForm').serialize(),
                    success: function(data) {
                        if(data.status == 'error'){
                            $("#UpdateSegregationForm").valid().showErrors(data.errors);
                        }else{
                            $("#UpdateSegregationForm")[0].reset();
                            $('#editSegregationModal').modal('hide');
                            SegregationTable.ajax.reload();
                        }
                    }
                });
            }
        });

        $('body').on('click','.DeleteSegregation',function (e) {
            e.preventDefault();
            var segregation_id = $(this).attr('id');
            SegregationId = segregation_id;
        });

        $(".DeleteConfirmed").click(function(e) {
            e.preventDefault();
            if (SegregationId != '') {
                $.ajax({
                    type: "delete",
                    url: '{{ route("SegregationDelete") }}',
                    data: {segregation_id: SegregationId},
                    success: function (data) {
                        if(data.status == 'error'){
                            toastr.error("Something went wrong");
                            SegregationTable.ajax.reload();
                        }else{
                            $('#DeleteModel').modal('hide');
                            SegregationTable.ajax.reload();
                        }
                    }
                });
            }
        });
    });

</script>
