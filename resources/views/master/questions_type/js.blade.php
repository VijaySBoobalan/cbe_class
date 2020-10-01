<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var QuestionTypesTable= $('#QuestionTypesTable').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        autoWidth: false,
        ajax: '{{ route("QuestionTypeIndex") }}',
        "columns": [
            { data: 'DT_RowIndex' },
            { data: 'question_name' },
            { data: 'action', orderable: false, searchable: false },
        ]
    });

    var QuestionTypeId="";
    $( document ).ready(function() {
        $('.AddQuestionTypes').on('click',function (e) {
            var form = $( "#AddQuestionTypesForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("QuestionTypestore") }}',
                    data:$('#AddQuestionTypesForm').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if(data.status == 'error'){
                            $("#AddQuestionTypesForm").valid().showErrors(data.errors);
                        }else{
                            $('#AddQuestionTypesModal').modal('hide');
                            QuestionTypesTable.ajax.reload();
                            $("#AddQuestionTypesForm")[0].reset();
                        }
                    }
                });
            }
        });

        $('body').on('click','.EditQuestionTypes',function (e) {
            e.preventDefault();
            var question_type_id = $(this).attr('id');
            if(question_type_id != ''){
                $.ajax({
                    type: "get",
                    url: '{{ route("QuestionTypeedit") }}',
                    data:{question_type_id:question_type_id},
                    success: function(data) {
                        console.log(data);
                        if(data.status == 'success'){
                            $('.question_type_id').val(data.QuestionTypes.id);
                            $('.question_type').val(data.QuestionTypes.question_type);
                        }else{
                            $('#editQuestionTypesModal').modal('hide');
                        }
                    }
                });
            }
        });


        $('body').on('click','.UpdateQuestionTypes',function (e) {
            var form = $( "#UpdateQuestionTypesForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();

            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("QuestionTypeUpdate") }}',
                    data:$('#UpdateQuestionTypesForm').serialize(),
                    success: function(data) {
                        if(data.status == 'error'){
                            $("#UpdateQuestionTypesForm").valid().showErrors(data.errors);
                        }else{
                            $('#editQuestionTypesModal').modal('hide');
                            QuestionTypesTable.ajax.reload();
                            $("#UpdateQuestionTypesForm")[0].reset();
                        }
                    }
                });
            }
        });

        $('body').on('click','.DeleteQuestionTypes',function (e) {
            e.preventDefault();
            var question_type_id = $(this).attr('id');
            QuestionTypeId = question_type_id;
        });

        $(".DeleteConfirmed").click(function(e) {
            e.preventDefault();
            if (QuestionTypeId != '') {
                $.ajax({
                    type: "delete",
                    url: '{{ route("QuestionTypeDelete") }}',
                    data: {question_type_id: QuestionTypeId},
                    success: function (data) {
                        if(data.status == 'error'){
                            toastr.error("Something went wrong");
                            QuestionTypesTable.ajax.reload();
                        }else{
                            $('#DeleteModel').modal('hide');
                            QuestionTypesTable.ajax.reload();
                        }
                    }
                });
            }
        });
    });

    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)){
            $('.Error').html('Allow only Letters');
            return false;
        }else{
            $('.Error').html("");
            return true;
        }
    }

</script>
