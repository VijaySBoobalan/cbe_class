<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var PreparationTypeTable= $('#PreparationTypeTable').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        autoWidth: false,
        ajax: '{{ route("PreparationTypeIndex") }}',
        "columns": [
            { data: 'DT_RowIndex' },
            { data: 'preparation_type' },
            { data: 'action', orderable: false, searchable: false },
        ]
    });

    var preparationTypeid="";
    $( document ).ready(function() {
        $('.AddPreparationType').on('click',function (e) {
            var form = $( "#AddPreparationTypeForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("PreparationTypestore") }}',
                    data:$('#AddPreparationTypeForm').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if(data.status == 'error'){
                            $("#AddPreparationTypeForm").valid().showErrors(data.errors);
                        }else{
                            $('#AddPreparationTypeModal').modal('hide');
                            PreparationTypeTable.ajax.reload();
                            $("#AddPreparationTypeForm")[0].reset();
                        }
                    }
                });
            }
        });

        $('body').on('click','.EditPreparationType',function (e) {
            e.preventDefault();
            var preparation_type_id = $(this).attr('id');
            if(preparation_type_id != ''){
                $.ajax({
                    type: "get",
                    url: '{{ route("PreparationTypeedit") }}',
                    data:{preparation_type_id:preparation_type_id},
                    success: function(data) {
                        console.log(data);
                        if(data.status == 'success'){
                            $('.preparation_type_id').val(data.PreparationTypes.id);
                            $('.preparation_type').val(data.PreparationTypes.preparation_type);
                        }else{
                            $('#editPreparationTypeModal').modal('hide');
                        }
                    }
                });
            }
        });


        $('body').on('click','.UpdatePreparationType',function (e) {
            var form = $( "#UpdatePreparationTypeForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();

            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("PreparationTypeUpdate") }}',
                    data:$('#UpdatePreparationTypeForm').serialize(),
                    success: function(data) {
                        if(data.status == 'error'){
                            $("#UpdatePreparationTypeForm").valid().showErrors(data.errors);
                        }else{
                            $('#editPreparationTypeModal').modal('hide');
                            PreparationTypeTable.ajax.reload();
                            $("#UpdatePreparationTypeForm")[0].reset();
                        }
                    }
                });
            }
        });

        $('body').on('click','.DeletePreparationType',function (e) {
            e.preventDefault();
            var preparation_type_id = $(this).attr('id');
            preparationTypeid = preparation_type_id;
        });

        $(".DeleteConfirmed").click(function(e) {
            e.preventDefault();
            if (preparationTypeid != '') {
                $.ajax({
                    type: "delete",
                    url: '{{ route("PreparationTypeDelete") }}',
                    data: {preparation_type_id: preparationTypeid},
                    success: function (data) {
                        if(data.status == 'error'){
                            toastr.error("Something went wrong");
                            PreparationTypeTable.ajax.reload();
                        }else{
                            $('#DeleteModel').modal('hide');
                            PreparationTypeTable.ajax.reload();
                        }
                    }
                });
            }
        });
    });

</script>
