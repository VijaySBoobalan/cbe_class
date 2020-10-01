<div class="modal fade AddOnlineTestModal" id="AddOnlineTestModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"style="width:1000px;margin-left: -89px;padding-left: 16px">
            <div class="row">

                <div class="col-md-6"style="border: 1px solid #ffe9e9;">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Add Schedule</h1>
                        </div>

                        <div class="tile-body">
							
                            <form action="#" id="AddOnlineTestForm" method="post" class="form-validate-jquery AddOnlineTestForm" data-parsley-validate name="form2" role="form">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Exam Name') !!}
                                                {!! Form::text('exam_name', null, ['class' => 'form-control exam_name','placeholder'=>'Exam Name','id'=>'exam_name','required'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Class') !!}
                                                {!! Form::select('student_class',$ClassSection->pluck('class','class') ,null, ['onchange'=>'getSections()','class' => 'form-control chosen-select','placeholder'=>'Class','id'=>'student_class','required'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Section') !!}
                                                {!! Form::select('section_id',[],null, ['onchange'=>'firstfunction()','class' => 'form-control chosen-select section_id','data-placeholder'=>'Section','id'=>'section_id','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            {!! Form::label('name', 'From Time') !!}
                                            <div class='input-group datepicker' data-format="LT">
                                                {!! Form::text('from_time', null, ['class' => 'form-control from_time','placeholder'=>'From Time','id'=>'from_time','required'=>'required']) !!}
                                                <span class="input-group-addon">
                                                    <span class="fa fa-clock-o"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            {!! Form::label('name', 'To Time') !!}
                                            <div class='input-group datepicker' data-format="LT">
                                                {!! Form::text('to_time', null, ['class' => 'form-control to_time','placeholder'=>'From Time','id'=>'to_time','required'=>'required']) !!}
                                                <span class="input-group-addon">
                                                    <span class="fa fa-clock-o"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <br>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'From Date') !!}
                                                <div class="input-group datepicker" data-format="L">
                                                    {!! Form::text('from_date', null , ['class' => 'form-control from_date','placeholder'=>'Day','id'=>'from_date','required'=>'required']) !!}
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'To Date') !!}
                                                <div class="input-group datepicker" data-format="L">
                                                    {!! Form::text('to_date', null , ['class' => 'form-control to_date','placeholder'=>'Day','id'=>'to_date','required'=>'required']) !!}
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>  
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Topic') !!}
                                                {!! Form::text('topic', null, ['class' => 'form-control topic','placeholder'=>'Batch Name','id'=>'topic','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>   
                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                    <button type="submit" class="btn btn-lightred AddOnlineTest" id="AddOnlineTest">Save</button>
                                </div>
                            {!! Form::close() !!}
							
							
                        </div>
                    </section>
                </div>
				<div class="col-md-6">
					<div id="calendar">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    if($('#editSectio_id').val() != ""){
          var SelectSection = $('#editSectio_id').val();
      }else{
          $('#student_class').trigger("chosen:updated");
          var SelectSection = "";
      }

   function getSections(){
          var student_class = $('#student_class').val();
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
  <script type="text/javascript">
   // $(document).ready(function(){
	  firstfunction();
	   // alert(dynamicdata);
	   function call_calendar_events(events){
		   $('#calendar').fullCalendar({
        
        events: events,
		eventColor: '#bec40e',
		height: 450
    });
	   }
	   function firstfunction(){
		  var class_id = $('#student_class').val();
		    var section_id = $('.section_id').val();
		    $.ajax({
                    url:"{{ Route('getExamEvents') }}",
                    type:"get",
                    dataType:"json",
                    data:{class_id:class_id, section_id:section_id},
                    success:function(data)
                    {
						// alert(data); 
						 $('#calendar').fullCalendar('removeEvents');
              $('#calendar').fullCalendar('addEventSource', data);      
				call_calendar_events(data)
              $('#calendar').fullCalendar('rerenderEvents' );
                       
                    }
                });
	   }
    // });
           
</script>