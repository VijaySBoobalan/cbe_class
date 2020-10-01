
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
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
            // Only validation controls
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

    var InstitutionTable= $('#InstitutionTable').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        autoWidth: false,
        ajax: '{{ action('InstitutionController@index') }}',
        "columns": [
            { data: 'DT_RowIndex' },
            { data: 'institution_name' },
            { data: 'institution_address' },
            { data: 'email' },
            { data: 'phone_number_1' },
            { data: 'user_name' },
            { data: 'action', orderable: false, searchable: false },
        ]
    });

    $( document ).ready(function() {

        $(document).on('click', '.toggle-password', function() {

            $(this).toggleClass("fa-eye fa-eye-slash");

            var input = $("#password");
            input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
        });

        $(document).on('click', '.toggle-password_confirmation', function() {

            $(this).toggleClass("fa-eye fa-eye-slash");

            var input = $("#password_confirmation");
            input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
        });

        $('.AddInstitution').on('click',function (e) {
            // $("#AddInstitutionForm")[0].reset();
            var form = $( "#AddInstitutionForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ action('InstitutionController@store') }}',
                    data:$('#AddInstitutionForm').serialize(),
                    dataType: 'json',
                    success: function(data) {
						console.log(data);
                        if(data.status == 'error'){
                            toastr.error("Institution Cannot be Added");
                            $("#AddInstitutionForm").valid().showErrors(data.errors);
                        }else{
                            toastr.success("Institution Successfully Added");
                            $('#AddInstitutionModal').modal('hide');
                            InstitutionTable.ajax.reload();
                            $("#AddInstitutionForm")[0].reset();
                        }
                    },
                    error: function (err) {
                        console.log(err);
                        if (err.status == 422) { // when status code is 422, it's a validation issue
                            $.each(err.responseJSON.errors, function (i, error) {
                                toastr.error(error[0]);
                            });
                        }
                    }
                });
            }
        });

        $('body').on('click','.EditInstitution',function (e) {
            e.preventDefault();
            var institution_id = $(this).attr('id');
            if(institution_id != ''){
                $.ajax({
                    type: "get",
                    url: '{{ action('InstitutionController@create') }}',
                    data:{institution_id:institution_id},
                    success: function(data) {
                        if(data.status == 'success'){
                            console.log(data.Roles);
                            $('.institution_id').val(data.Institution.id);
                            $('.institution_name').val(data.Institution.institution_name);
                            $('.institution_address').val(data.Institution.institution_address);
                            $('.user_name').val(data.Institution.user_name);
                            $('.phone_number_1').val(data.Institution.phone_number_1);
                            $('.phone_number_2').val(data.Institution.phone_number_2);
                            $('.email').val(data.Institution.email);
                            // $('.tts_fee').val(data.Institution.tts_fee);
                            // $('.school_fee').val(data.Institution.school_fee);
                            $('.roles').val(data.Roles).trigger('chosen:updated');
                        }else{
                            $('#editInstitutionModal').modal('hide');
                        }
                    },
                    error: function (err) {
                        console.log(err);
                        if (err.status == 422) { // when status code is 422, it's a validation issue
                            $.each(err.responseJSON.errors, function (i, error) {
                                toastr.error(error[0]);
                            });
                        }
                    }
                });
            }
        });


        $('body').on('click','.UpdateInstitution',function (e) {
            var form = $( "#UpdateInstitutionForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ action('InstitutionController@UpdateInstitution') }}',
                    data:$('#UpdateInstitutionForm').serialize(),
                    success: function(data) {
						console.log(data);
                        if(data.status == 'error'){
                            toastr.error("Institution Cannot be Updated");
                            $("#UpdateInstitutionForm").valid().showErrors(data.errors);
                        }else{
                            toastr.success("Institution Successfully Updated");
                            $('#editInstitutionModal').modal('hide');
                            InstitutionTable.ajax.reload();
                            $("#UpdateInstitutionForm")[0].reset();
                        }
                    },
                    error: function (err) {
                        if (err.status == 422) { // when status code is 422, it's a validation issue
                            $.each(err.responseJSON.errors, function (i, error) {
                                toastr.error(error[0]);
                            });
                        }
                    }
                });
            }
        });

        $('body').on('click','.DeleteInstitution',function () {
            var institution_id = $(this).attr('id');
            InstitudeId = institution_id;
        });

        $(".DeleteConfirmed").click(function(e) {
            e.preventDefault();
            if (InstitudeId != '') {
                $.ajax({
                    type: "delete",
                    url: '{{ route('institutionDelete') }}',
                    data: {institution_id: InstitudeId},
                    success: function (data) {
                        console.log(data);
                        if(data.status == 'error'){
                            toastr.error("Institution cannot be Deleted");
                            InstitutionTable.ajax.reload();
                        }else{
                            toastr.success("Institution Deleted Successfully");
                            $('#DeleteModel').modal('hide');
                            InstitutionTable.ajax.reload();
                        }
                    },
                    error: function (err) {
                        if (err.status == 422) { // when status code is 422, it's a validation issue
                            $.each(err.responseJSON.errors, function (i, error) {
                                toastr.error(error[0]);
                            });
                        }
                    }
                });
            }
        });

    });

</script>
