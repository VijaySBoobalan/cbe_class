				<div class="modal fade Password" id="Password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">

                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Enter Password</h1>

                        </div>

                        <div class="tile-body">
						 <form action="#"id="checkpassword" class="form-validate-jquery checkpassword"enctype="multipart/form-data" data-parsley-validate name="form2" role="form">
                           <div class="row">
						   <input type="hidden"name="exam_id"value=""id="exam_id">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Password') !!}
                                            <input type="password"name="password"class="form-control"id="password">
                                        </div>
                                    </div>
                            </div>
							  <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                    <button type="submit" class="btn btn-lightred SubmitHomeworks" id="SubmitHomework">Submit</button>
                                </div>
						 </form>
						
                        </div>
                    </section>

            </div>
        </div>
    </div>
</div>
</div>
<script>
	$('body').on('click','.examdetails',function (e) {
	 var exam_id = $(this).attr('id');
	 $('#exam_id').val(exam_id);
	});
   $('#checkpassword').on('submit', function(event){
			
            var form = $( "#checkpassword" );
            form.validate();
            event.preventDefault();
                $.ajax({
                    type: "post",
                    url: '{{ route("checkpassword") }}',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        console.log(data);
                        if(data.status == 'success'){
							toastr.success(data.message);
                          var route='{{ url("start_exam") }}/'+data.id;

                window.location.href = route;
                        }else{
						toastr.error(data.message);
                        }
                    }
                });

        });
</script>