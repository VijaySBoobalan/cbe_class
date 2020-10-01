<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var BatchTable= $('#BatchTable').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        autoWidth: false,
        ajax: '{{ route("BatchIndex") }}',
        "columns": [
            { data: 'DT_RowIndex' },
            { data: 'batch_name' },
            { data: 'total_students' },
            { data: 'action', orderable: false, searchable: false },
        ]
    });

    var batchId="";
    $( document ).ready(function() {
        $('.AddBatch').on('click',function (e) {
            var form = $( "#AddBatchForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("Batchstore") }}',
                    data:$('#AddBatchForm').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if(data.status == 'error'){
                            toastr.success(data.error);
                            $("#AddBatchForm").valid().showErrors(data.errors);
                        }else{
                            toastr.success(data.message);
                            $("#AddBatchForm")[0].reset();
                            $('#AddBatchModal').modal('hide');
                            BatchTable.ajax.reload();
                        }
                    }
                });
            }
        });

        $('body').on('click','.EditBatch',function (e) {
            e.preventDefault();
            var batch_id = $(this).attr('id');
            if(batch_id != ''){
                $.ajax({
                    type: "get",
                    url: '{{ route("Batchedit") }}',
                    data:{batch_id:batch_id},
                    success: function(data) {
                        console.log(data);
						$('.appendEditDatas').html(data);
                    }
                });
            }
        });


        $('body').on('click','.UpdateBatch',function (e) {
            var form = $( "#UpdateBatchForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("BatchUpdate") }}',
                    data:$('#UpdateBatchForm').serialize(),
                    success: function(data) {
                        console.log(data);
                        if(data.status == 'error'){
                            toastr.error(data.error);
                            $("#UpdateBatchForm").valid().showErrors(data.errors);
                        }else{                            
                            toastr.success(data.message);
                            $("#UpdateBatchForm")[0].reset();
                            $('#editBatchModal').modal('hide');
                            BatchTable.ajax.reload();
                        }
                    }
                });
            }
        });

        $('body').on('click','.DeleteBatch',function (e) {
            e.preventDefault();
            var batch_id = $(this).attr('id');
            batchId = batch_id;
        });

        $(".DeleteConfirmed").click(function(e) {
            e.preventDefault();
            if (batchId != '') {
                $.ajax({
                    type: "delete",
                    url: '{{ route("BatchDelete") }}',
                    data: {batchId: batchId},
                    success: function (data) {
                        if(data.status == 'error'){
                            toastr.error(data.message);
                            BatchTable.ajax.reload();
                        }else{
                            $('#DeleteModel').modal('hide');
                            toastr.success(data.message);
                            BatchTable.ajax.reload();
                        }
                    }
                });
            }
        });
    });

</script>
