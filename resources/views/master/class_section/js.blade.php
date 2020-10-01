<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var ClassSectionTable= $('#ClassSectionTable').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        autoWidth: false,
        ajax: '{{ route("ClassSectionIndex") }}',
        "columns": [
            { data: 'DT_RowIndex' },
            { data: 'class' },
            { data: 'section' },
            { data: 'action', orderable: false, searchable: false },
        ]
    });

    var sectionId="";
    $( document ).ready(function() {
        $('.AddClassSubject').on('click',function (e) {
            var form = $( "#AddClassSubjectForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("storeSection") }}',
                    data:$('#AddClassSubjectForm').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if(data.status == 'error'){
                            $("#AddClassSubjectForm").valid().showErrors(data.errors);
                        }else{
                            $('#AddClassSectionModal').modal('hide');
                            ClassSectionTable.ajax.reload();
                            $("#AddClassSubjectForm")[0].reset();
                        }
                    }
                });
            }
        });

        $('body').on('click','.EditSection',function (e) {
            e.preventDefault();
            var section_id = $(this).attr('id');
            if(section_id != ''){
                $.ajax({
                    type: "get",
                    url: '{{ route("editSection") }}',
                    data:{section_id:section_id},
                    success: function(data) {
                        console.log(data);
                        if(data.status == 'success'){
                            $('.section_id').val(data.Section.id);
                            $('.class').val(data.Section.class);
                            $('.section').val(data.Section.section);
                        }else{
                            $('#editSectionModal').modal('hide');
                        }
                    }
                });
            }
        });


        $('body').on('click','.UpdateSection',function (e) {
            var form = $( "#UpdateSectionForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();

            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("UpdateSection") }}',
                    data:$('#UpdateSectionForm').serialize(),
                    success: function(data) {
                        if(data.status == 'error'){
                            $("#UpdateSectionForm").valid().showErrors(data.errors);
                        }else{
                            $('#editSectionModal').modal('hide');
                            ClassSectionTable.ajax.reload();
                            $("#UpdateSectionForm")[0].reset();
                        }
                    }
                });
            }
        });

        $('body').on('click','.DeleteSection',function (e) {
            e.preventDefault();
            var section_id = $(this).attr('id');
            sectionId = section_id;
        });

        $(".DeleteConfirmed").click(function(e) {
            e.preventDefault();
            if (sectionId != '') {
                $.ajax({
                    type: "delete",
                    url: '{{ route("DeleteSection") }}',
                    data: {section_id: sectionId},
                    success: function (data) {
                        if(data.status == 'error'){
                            toastr.error("This Class Added for Another modules.If you want to delete,you must delete another modules");
                            ClassSectionTable.ajax.reload();
                        }else{
                            $('#DeleteModel').modal('hide');
                            ClassSectionTable.ajax.reload();
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
