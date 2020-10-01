<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $( document ).ready(function() {
        //CLASS HOMEWORK

        var table = $('#advanced-usage').DataTable({
            responsive: true,
            autoWidth: false,
        });

        $('.homework_id').on('click',function (){
          var homework_id = $(this).attr('id');
         $('#homework_id').val(homework_id);
        });

          $('#SubmitHomeworkForm').on('submit', function(event){

            var form = $( "#SubmitHomeworkForm" );
            form.validate();
            event.preventDefault();
                $.ajax({
                    type: "post",
                    url: '{{ route("SubmitHomework") }}',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        console.log(data);
                        if(data.status == 'success'){
							toastr.success(data.message);
                          $('#UploadHomework').modal('hide');
						   window.location.reload();
                        }else{
						toastr.error(data.message);
                        }
                    }
                });

        });
		$('.homework_view_status').on('click', function(event){
			 var student_id = '{{ auth()->user()->id }}';
			 var homework_id = $(this).attr('id');
			    $.ajax({
                        type: "post",
                        url: '{{ route("GetIndividualStudentHomework") }}',
                        data: {student_id:student_id,homework_id: homework_id},
                        success: function (data) {
                            console.log(data);
							$('#Remark').html(data.Studenthomework[0].remarks)
							 var file ="{{ URL::to('') }}/"+data.Studenthomework[0].homework_attachment ;
                             var image="<img src='"+file+"'class='btn btn-success downloadfile'width='500px'height='300px'>";

							$('.homework_status').html(image);

                        }
                    });
		});
    });

</script>

