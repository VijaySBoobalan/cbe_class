<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var YearTable= $('#YearTable').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        autoWidth: false,
        ajax: '{{ route("YearIndex") }}',
        "columns": [
            { data: 'DT_RowIndex' },
            { data: 'year' },
            { data: 'action', orderable: false, searchable: false },
        ]
    });

    var yearId="";
    $( document ).ready(function() {
        $('.AddYear').on('click',function (e) {
            var form = $( "#AddYearForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("Yearstore") }}',
                    data:$('#AddYearForm').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if(data.status == 'error'){
                            $("#AddYearForm").valid().showErrors(data.errors);
                        }else{
                            $("#AddYearForm")[0].reset();
                            $('#AddYearModal').modal('hide');
                            YearTable.ajax.reload();
                        }
                    }
                });
            }
        });

        $('body').on('click','.EditYear',function (e) {
            e.preventDefault();
            var year_id = $(this).attr('id');
            if(year_id != ''){
                $.ajax({
                    type: "get",
                    url: '{{ route("Yearedit") }}',
                    data:{year_id:year_id},
                    success: function(data) {
                        console.log(data);
                        if(data.status == 'success'){
                            $('.year_id').val(data.Years.id);
                            $('.year').val(data.Years.year);
                        }else{
                            $('#editYearModal').modal('hide');
                        }
                    }
                });
            }
        });


        $('body').on('click','.UpdateYear',function (e) {
            var form = $( "#UpdateYearForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("YearUpdate") }}',
                    data:$('#UpdateYearForm').serialize(),
                    success: function(data) {
                        if(data.status == 'error'){
                            $("#UpdateYearForm").valid().showErrors(data.errors);
                        }else{
                            $("#UpdateYearForm")[0].reset();
                            $('#editYearModal').modal('hide');
                            YearTable.ajax.reload();
                        }
                    }
                });
            }
        });

        $('body').on('click','.DeleteYear',function (e) {
            e.preventDefault();
            var year_id = $(this).attr('id');
            yearId = year_id;
        });

        $(".DeleteConfirmed").click(function(e) {
            e.preventDefault();
            if (yearId != '') {
                $.ajax({
                    type: "delete",
                    url: '{{ route("YearDelete") }}',
                    data: {year_id: yearId},
                    success: function (data) {
                        if(data.status == 'error'){
                            toastr.error("Something went wrong");
                            YearTable.ajax.reload();
                        }else{
                            $('#DeleteModel').modal('hide');
                            YearTable.ajax.reload();
                        }
                    }
                });
            }
        });
    });

</script>
