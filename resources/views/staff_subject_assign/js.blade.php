{{-- <style type="text/css">
    .floatRight{
        float:right;
    }
    .clear{
        clear:both;
    }
</style> --}}
<script>
    var SelectSubject = "0";
    var SelectSection = "0";
    var AssignStaffSubjectTable = "";
    $(function(){
        $.validator.setDefaults({
            errorElement: "span",
            errorClass: "help-block",
            ignore: ":hidden:not(select)",
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
                else if (element.is("select.chosen-select")) {
                    element.next("div.chosen-container").append(error);
                }
                else {
                    error.insertAfter(element);
                }
            }
        });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Setting datatable defaults
    $.extend($.fn.dataTable.defaults, {
        autoWidth: false,
        columnDefs: [{
            orderable: false,
            width: 100,
            targets: [3]
        }],
        dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        language: {
            search: '<span>Search:</span> _INPUT_',
            searchPlaceholder: 'Type to filter...',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
        }
    });

    var data = [];
    dataTable(data);

    function dataTable(data) {
        AssignStaffSubjectTable= $('#AssignStaffSubjectTable').DataTable({
            processing: true,
            serverSide: false,
            responsive: true,
            autoWidth: false,
            "bDestroy": true,
            ajax:{
                url:'{{ action('StaffSubjectAssignController@index') }}',
                data:data,
            },
            "columns": [
                { data: 'DT_RowIndex' },
                { data: 'staff_id' },
                { data: 'class' },
                { data: 'section_id' },
                { data: 'subject_id' },
                { data: 'action', orderable: false, searchable: false },
            ],
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

    $( document ).ready(function() {
        $('#FilterStaffSubjectDetails').on('click',function (e) {
            e.preventDefault();
            var staff_id = $('.staff_id').val();
            var class_id = $('.class_id').val();
            var section_id = $('.section_id').val();
            dataTable({staff_id : staff_id ,class_id : class_id ,section_id : section_id });
        });

        $('.StaffSubjectDetail').on('click',function (e) {
            $('.staff_id').val("").trigger('chosen:updated');
            $('.taken_class').val("").trigger('chosen:updated');
            $('.subject_details').html('<option>Select Subjects</option>');
        });

        $('.AddStaffSubject').on('click',function (e) {
            if ($("select.chosen-select").length > 0) {
                $("select.chosen-select").each(function() {
                    if ($(this).attr('required') !== undefined) {
                        $(this).on("change", function() {
                            $(this).valid();
                        });
                    }
                });
            }

            $('.staff_id').chosen();
            $('.taken_class').chosen();

            var form = $( "#AddStaffSubjectForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ action('StaffSubjectAssignController@store') }}',
                    data:$('#AddStaffSubjectForm').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if(data.data == 'error'){
                            toastr.error("Class Already Added");
                        }
                        if(data.status == 'error'){
                            $("#AddStaffSubjectForm").valid().showErrors(data.errors);
                            toastr.error("Class Already Added");
                        }else{
                            $('.AssignStaffSubjectModal').modal('hide');
                            AssignStaffSubjectTable.ajax.reload();
                            $(".AddStaffSubjectForm")[0].reset();
                            $('.staff_id').val("").trigger('chosen:updated');
                            $('.taken_class').val("").trigger('chosen:updated');
                            $('.subject_details').prop('selectedIndex',0);
                        }
                    }
                });
            }
        });

        $('body').on('click','.EditStaffSubject',function (e) {
            e.preventDefault();
            var staff_subject_id = $(this).attr('id');
            if(staff_subject_id != ''){
                $.ajax({
                    type: "get",
                    url: '{{ action('StaffSubjectAssignController@EditStaffSubject') }}',
                    data:{staff_subject_id:staff_subject_id},
                    success: function(data) {
                        if(data.status == 'success'){
                            $('.staff_subject_id').val(data.StaffSubjectAssign.id);
                            $('.staff_id').val(data.StaffSubjectAssign.staff_id).trigger('chosen:updated');
                            $('.taken_class').val(data.StaffSubjectAssign.class).trigger('chosen:updated');
                            getSection(data.StaffSubjectAssign.class);
                            EditgetSubjects(data.StaffSubjectAssign.class,data.StaffSubjectAssign.section_id);
                            $('.subject_details').val(data.StaffSubjectAssign.subjects);
                            SelectSection = data.StaffSubjectAssign.section_id;
                            SelectSubject = data.StaffSubjectAssign.subjects;
                        }else{
                            $('#EditStaffSubjectModal').modal('hide');
                        }
                    }
                });
            }
        });


        $('body').on('click','.UpdateStaffSubject',function (e) {
            var form = $( "#UpdateStaffSubjectForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ action('StaffSubjectAssignController@UpdateStaffSubject') }}',
                    data:$('#UpdateStaffSubjectForm').serialize(),
                    success: function(data) {
                        if(data.status == 'error'){
                            $("#UpdateStaffSubjectForm").valid().showErrors(data.errors);
                        }else{
                            $('#EditStaffSubjectModal').modal('hide');
                            AssignStaffSubjectTable.ajax.reload();
                            $("#UpdateStaffSubjectForm")[0].reset();
                        }
                    }
                });
            }
        });

        var staffSubjectId = "";
        $('body').on('click','.DeleteStaffSubject',function () {
            var staff_subject_id = $(this).attr('id');
            staffSubjectId = staff_subject_id;
        });

        $(".DeleteConfirmed").click(function(e) {
            e.preventDefault();
            if (staffSubjectId != '') {
                $.ajax({
                    type: "delete",
                    url: '{{ action('StaffSubjectAssignController@DeleteStaffSubject') }}',
                    data: {staff_subject_id: staffSubjectId},
                    success: function (data) {
                        console.log(data);
                        if(data.status == 'error'){
                            AssignStaffSubjectTable.ajax.reload();
                            toastr.error("Cannot be Deleted.Try more time");
                        }else{
                            $('#DeleteStaffSubjectModel').modal('hide');
                            AssignStaffSubjectTable.ajax.reload();
                        }

                        if(data.status == 'warning'){
                            AssignStaffSubjectTable.ajax.reload();
                            toastr.error("This Staff Subject Added for Another modules.If you want to delete,you must delete Staff Schedule");
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
                    $('.section_id').html(selectHTML);
                    $('.section_id').val(SelectSection).trigger("chosen:updated");
                    if(SelectSection =="0"){
                        SelectSection = "";
                        getSubjects(SelectSection);
                    }
                }
            });
        }
    }

    function getSubjects(value) {
        return new Promise(resolve => {
            var taken_class = $('.taken_class').val();
            var section_id = value;
            var selectHTML = "";
            if(taken_class!="" && section_id!="" ){
                axios.get("{{ action('StaffSubjectAssignController@create') }}",{params: {"class_id": taken_class , "section_id": section_id } }).then(response => {
                    for (var key in response.data) {
                        var row = response.data[key];
                        selectHTML += "<option value=" + row.id + ">" + row.subject_name + "</option>";
                    }
                    $('.subject_details').html(selectHTML);
                    $('.subject_details').val(SelectSubject).trigger('chosen:updated');
                    resolve(1)
                }).catch(error => {
                    console.log(error);
                })
            }
        })
    }

    function EditgetSubjects(taken_class,section_id) {
        return new Promise(resolve => {
            var selectHTML = "";
            if(taken_class!="" && section_id!="" ){
                axios.get("{{ action('StaffSubjectAssignController@create') }}",{params: {"class_id": taken_class , "section_id": section_id } }).then(response => {
                    for (var key in response.data) {
                        var row = response.data[key];
                        selectHTML += "<option value=" + row.id + ">" + row.subject_name + "</option>";
                    }
                    $('.subject_details').html(selectHTML);
                    $('.subject_details').val(SelectSubject).trigger('chosen:updated');
                    resolve(1)
                }).catch(error => {
                    console.log(error);
                })
            }
        })
    }

</script>
