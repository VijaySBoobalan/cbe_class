<script>

    var SelectSubject = "0";
    var SelectSection = "0";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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

    var SelectSubject = "0";


    var AssignStaffScheduleTable= $('#AssignStaffScheduleTable').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        autoWidth: false,
        ajax: '{{ action('StaffScheduleController@StaffScheduleIndex') }}',
        "columns": [
            { data: 'DT_RowIndex' },
            { data: 'staff_id' },
            { data: 'class' },
            { data: 'section_id' },
            {
                data: 'subjects',
                "render": function(data, type, row){
                    return data.split(",").join("<br/>");
                }
            },
            { data: 'action', orderable: false, searchable: false },
        ]
    });

    $( document ).ready(function() {
        $('.StaffScheduleDetail').on('click',function (e) {
            $('.staff_id').attr('disabled',false);
            $('.taken_class').attr('disabled',false);
            $('.section_id').attr('disabled',false);
            $('.staff_id').val("").trigger('chosen:updated');
            $('.taken_class').val("").trigger('chosen:updated');
            $('.section_id').val("").trigger('chosen:updated');
            $('.AppendStaffSchedule').hide();
            $('.modal-footer').show();

        });

        $('.FilterStaffSubjectDetails').on('click',function (e) {
            var form = $( "#FilterStaffSubjectForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            $('.AppendStaffSchedule').show();
            var staff_id = $('.staff_id').val();
            var taken_class = $('.taken_class').val();
            var section_id = $('.section_id').val();
            if(checkValid == true){
                $.ajax({
                    type: "get",
                    url: '{{ action('StaffScheduleController@StaffScheduleCreate') }}',
                    data:{staff_id : staff_id , taken_class : taken_class , section_id : section_id},
                    success: function(data) {
                        $('.AppendStaffSchedule').html(data);
                    }
                });
            }
        });


        $('body').on('click','.EditStaffSchedule',function (e) {
            e.preventDefault();
            var staff_schedule_id = $(this).attr('id');
            $('.AppendStaffSchedule').show();
            $('.modal-footer').hide();
            $('.staff_id').attr('disabled',true);
            $('.taken_class').attr('disabled',true);
            $('.section_id').attr('disabled',true);
            if(staff_schedule_id != ''){
                $.ajax({
                    type: "get",
                    url: '{{ action('StaffScheduleController@StaffScheduleEdit') }}',
                    data:{staff_schedule_id : staff_schedule_id},
                    success: function(data) {
                        $('.staff_id').val(data.StaffScheduleClass.staff_id).trigger('chosen:updated');
                        $('.taken_class').val(data.StaffScheduleClass.class).trigger('chosen:updated');
                        getSection(data.StaffScheduleClass.class);
                        SelectSection = data.StaffScheduleClass.section_id;
                        $('.section_id').val(data.StaffScheduleClass.section_id).trigger('chosen:updated');
                        if(data.StaffScheduleSubjectDetails !=""){
                            $.ajax({
                                type: "get",
                                url: '{{ action('StaffScheduleController@StaffScheduleRender') }}',
                                data:{staff_schedule_id : staff_schedule_id},
                                success: function(data) {
                                    $('.AppendStaffSchedule').html(data);
                                }
                            });
                        }
                    }
                });
            }
        });

        $('body').on('click','.DeleteStaffSchedule',function () {
            var staff_schedule_id = $(this).attr('id')
            $(".DeleteConfirmed").click(function(e) {
                e.preventDefault();
                if (staff_schedule_id != '') {
                    $.ajax({
                        type: "delete",
                        url: '{{ action('StaffScheduleController@StaffScheduleDelete') }}',
                        data: {staff_schedule_id: staff_schedule_id},
                        success: function (data) {
                            if(data.status == 'error'){
                                AssignStaffScheduleTable.ajax.reload();
                            }else{
                                $('#DeleteStaffScheduleModel').modal('hide');
                                AssignStaffScheduleTable.ajax.reload();
                            }
                        }
                    });
                }
            });
        });
    });

    function getSubjects(section_id) {
        return new Promise(resolve => {
            var taken_class = $('.taken_class').val();
            var selectHTML = "";
            axios.get("{{ action('StaffSubjectAssignController@create') }}",{params: { "class_id": taken_class , "section_id": section_id } }).then(response => {
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
        })
    }


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
                }
            });
        }
    }

</script>
