<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var QuestionModelTable= $('#QuestionModelTable').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        autoWidth: false,
        ajax: '{{ route("QuestionModelIndex") }}',
        "columns": [
            { data: 'DT_RowIndex' },
            { data: 'question_model' },
            { data: 'action', orderable: false, searchable: false },
        ]
    });

    var QuestionModelId="";
    $( document ).ready(function() {
        $('.AddQuestionModel').on('click',function (e) {
            var form = $( "#AddQuestionModelForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("QuestionModelstore") }}',
                    data:$('#AddQuestionModelForm').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if(data.status == 'error'){
                            $("#AddQuestionModelForm").valid().showErrors(data.errors);
                        }else{
                            $('#AddQuestionModelModal').modal('hide');
                            QuestionModelTable.ajax.reload();
                            $("#AddQuestionModelForm")[0].reset();
                        }
                    }
                });
            }
        });

        $('body').on('click','.EditQuestionModel',function (e) {
            e.preventDefault();
            var question_model_id = $(this).attr('id');
            if(question_model_id != ''){
                $.ajax({
                    type: "get",
                    url: '{{ route("QuestionModeledit") }}',
                    data:{question_model_id:question_model_id},
                    success: function(data) {
                        if(data.status == 'success'){
                            $('.question_model_id').val(data.QuestionModel.id);
                            $('.question_model').val(data.QuestionModel.question_model);
                        }else{
                            $('#editQuestionModelModal').modal('hide');
                        }
                    }
                });
            }
        });


        $('body').on('click','.UpdateQuestionModel',function (e) {
            var form = $( "#UpdateQuestionModelForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();

            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("QuestionModelUpdate") }}',
                    data:$('#UpdateQuestionModelForm').serialize(),
                    success: function(data) {
                        if(data.status == 'error'){
                            $("#UpdateQuestionModelForm").valid().showErrors(data.errors);
                        }else{
                            $("#UpdateQuestionModelForm")[0].reset();
                            $('#editQuestionModelModal').modal('hide');
                            QuestionModelTable.ajax.reload();
                        }
                    }
                });
            }
        });

        $('body').on('click','.DeleteQuestionModel',function (e) {
            e.preventDefault();
            var question_model_id = $(this).attr('id');
            QuestionModelId = question_model_id;
        });

        $(".DeleteConfirmed").click(function(e) {
            e.preventDefault();
            if (QuestionModelId != '') {
                $.ajax({
                    type: "delete",
                    url: '{{ route("QuestionModelDelete") }}',
                    data: {question_model_id: QuestionModelId},
                    success: function (data) {
                        if(data.status == 'error'){
                            toastr.error("Something went wrong");
                            QuestionModelTable.ajax.reload();
                        }else{
                            $('#DeleteModel').modal('hide');
                            QuestionModelTable.ajax.reload();
                        }
                    }
                });
            }
        });
    });

</script>
