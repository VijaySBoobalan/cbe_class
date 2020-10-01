<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var OnlineTestTable= $('#OnlineTestTable').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        autoWidth: false,
        ajax: '{{ route("OnlineTestIndex") }}',
        "columns": [
            { data: 'DT_RowIndex' },
            { data: 'exam_name' },
            { data: 'class_id' },
            { data: 'section' },
            { data: 'from_time' },
            { data: 'to_time' },
            { data: 'from_date' },
            { data: 'to_date' },
            { data: 'action', orderable: false, searchable: false },
        ]
    });

    var testId="";
    $( document ).ready(function() {
        $('.AddOnlineTest').on('click',function (e) {
            var form = $( "#AddOnlineTestForm" );
            console.log($('#AddOnlineTestForm').serialize());
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("OnlineTeststore") }}',
                    data:$('#AddOnlineTestForm').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if(data.status == 'error'){
                            toastr.success(data.message);
                            $("#AddOnlineTestForm").valid().showErrors(data.errors);
                        }else{
                            toastr.success(data.message);
                            $("#AddOnlineTestForm")[0].reset();
                            $('#AddOnlineTestModal').modal('hide');
                            OnlineTestTable.ajax.reload();
                        }
                    }
                });
            }
        });

        $('body').on('click','.EditOnlineTest',function (e) {
            e.preventDefault();
            var test_id = $(this).attr('id');
            if(test_id != ''){
                $.ajax({
                    type: "get",
                    url: '{{ route("OnlineTestedit") }}',
                    data:{test_id:test_id},
                    success: function(data) {
                        console.log(data);
                        if(data.status == 'success'){
                            $('.test_id').val(data.OnlineTests.id);
                            $('.edit_exam_name').val(data.OnlineTests.exam_name);
                            $('.edit_student_class').val(data.OnlineTests.class_id);
                            $('.edit_section_id').val(data.OnlineTests.section_id);
                            $('.edit_from_time').val(data.OnlineTests.from_time);
                            $('.edit_to_time').val(data.OnlineTests.to_time);
                            $('.edit_from_date').val(data.OnlineTests.from_date);
                            $('.edit_to_date').val(data.OnlineTests.to_date);
                            $('.edit_topic').val(data.OnlineTests.topic);
                        }else{
                            $('#editYearModal').modal('hide');
                        }
                    }
                });
            }
        });


        $('body').on('click','.UpdateOnlineTest',function (e) {
            var form = $( "#UpdateOnlineTestForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("OnlineTestUpdate") }}',
                    data:$('#UpdateOnlineTestForm').serialize(),
                    success: function(data) {
                        console.log(data);
                        if(data.status == 'error'){
                            toastr.error(data.error);
                            $("#UpdateOnlineTestForm").valid().showErrors(data.errors);
                        }else{                            
                            toastr.success(data.message);
                            $("#UpdateOnlineTestForm")[0].reset();
                            $('#editOnlineTestModal').modal('hide');
                            OnlineTestTable.ajax.reload();
                        }
                    }
                });
            }
        });

        $('body').on('click','.DeleteOnlineTest',function (e) {
            e.preventDefault();
            var test_id = $(this).attr('id');
            testId = test_id;
        });

        $(".DeleteConfirmed").click(function(e) {
            e.preventDefault();
            if (testId != '') {
                $.ajax({
                    type: "delete",
                    url: '{{ route("OnlineTestDelete") }}',
                    data: {testId: testId},
                    success: function (data) {
                        if(data.status == 'error'){
                            toastr.error(data.message);
                            OnlineTestTable.ajax.reload();
                        }else{
                            $('#DeleteModel').modal('hide');
                            toastr.success(data.message);
                            OnlineTestTable.ajax.reload();
                        }
                    }
                });
            }
        });
    });

</script>

