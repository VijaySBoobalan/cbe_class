
<script>

    var SelectSection = "";

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
        ajax: '{{ action('master\SubjectController@index') }}',
        "columns": [
            { data: 'DT_RowIndex' },
            { data: 'class' },
            { data: 'section_id' },
            { data: 'subject_name' },
            { data: 'action', orderable: false, searchable: false },
        ]
    });

    $.validator.setDefaults({
        errorElement: "span",
        errorClass: "help-block",
        highlight: function (element, errorClass, validClass) {
            // Only validation controls
            if (!$(element).hasClass('novalidation')) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            if (!$(element).hasClass('novalidation')) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        },
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            }
            else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
                error.insertAfter(element.parent().parent());
            }
            else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                error.appendTo(element.parent().parent());
            }
            else {
                error.insertAfter(element);
            }
        }
    });

    $( document ).ready(function() {
        $('.AddSubject').on('click',function (e) {
            var form = $( "#AddSubjectForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ action('master\SubjectController@store') }}',
                    data:$('#AddSubjectForm').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if(data.status == 'error'){
                            $("#AddSubjectForm").valid().showErrors(data.errors);
                        }else{
                            SubjectTable.ajax.reload();
                            $('#AddSubjectsModal').modal('hide');
                            $('.subject_id').val("").trigger("chosen:updated");
                            $('.section_id').val("").trigger("chosen:updated");
                            $('#class').val("").trigger("chosen:updated");
                            $("#AddSubjectForm")[0].reset();
                        }
                    },
                    error: function (err) {
                        if (err.status == 422) {
                            $.each(err.responseJSON.errors, function (i, error) {
                                toastr.error(error[0]);
                            });
                        }
                    }
                });
            }
        });

        $('body').on('click','.EditSubject',function (e) {
            e.preventDefault();
            var subject_id = $(this).attr('id');
            if(subject_id != ''){
                $.ajax({
                    type: "get",
                    url: '{{ action('master\SubjectController@create') }}',
                    data:{subject_id:subject_id},
                    success: function(data) {
                        if(data.status == 'success'){
                            $('.subject_id').val(data.Subject.id);
                            $('.class').val(data.Subject.class);
                            $('.class').val(data.Subject.class).trigger("chosen:updated");
                            getSection(data.Subject.class);
                            SelectSection = data.Subject.section_id;
                            $('.subject_name').val(data.Subject.subject_name);
                        }else{
                            $('#editSubjectModal').modal('hide');
                        }
                    }
                });
            }
        });


        $('body').on('click','.UpdateSubject',function (e) {
            var form = $( "#UpdateSubjectForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ action('master\SubjectController@UpdateSubject') }}',
                    data:$('#UpdateSubjectForm').serialize(),
                    success: function(data) {
                        if(data.status == 'error'){
                            $("#UpdateSubjectForm").valid().showErrors(data.errors);
                        }else{
                            $('#editSubjectModal').modal('hide');
                            SubjectTable.ajax.reload();
                            $("#UpdateSubjectForm")[0].reset();
                        }
                    }
                });
            }
        });

        var subjectId = "";
        $('body').on('click','.DeleteSubject',function () {
            var subject_id = $(this).attr('id');
            subjectId = subject_id;
        });

        $(".DeleteConfirmed").click(function(e) {
            e.preventDefault();
            if (subjectId != '') {
                $.ajax({
                    type: "delete",
                    url: '{{ action('master\SubjectController@DeleteSubject') }}',
                    data: {subject_id: subjectId},
                    success: function (data) {
                        if(data.status == 'error'){
                            toastr.error("This Subject Added for Another modules.If you want to delete,you must delete another modules");
                            SubjectTable.ajax.reload();
                        }else{
                            $('#DeleteModel').modal('hide');
                            SubjectTable.ajax.reload();
                        }
                    }
                });
            }
        });

    });

    function getSection(value){
        var student_class = value;
        var selectHTML = "";
        if(student_class != ''){
            $.ajax({
                type: "get",
                url: '{{ route("getSection") }}',
                data:{student_class:student_class},
                success: function(data) {
                    for (var key in data) {
                        var row = data[key];
                        selectHTML += "<option value='" + row.id + "'>" + row.section + "</option>";
                    }
                    console.log(selectHTML);
                    $('.section_id').html(selectHTML);
                    $('.section_id').val(SelectSection).trigger("chosen:updated");
                }
            });
        }
    }

</script>
