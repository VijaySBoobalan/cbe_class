<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var ClassHomeworkTable= $('#ClassHomeworkTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        ajax: '{{ route("ClassHomework") }}',
        "columns": [
            { data: 'DT_RowIndex' },
            { data: 'class_id' },
            { data: 'section' },
            {data:'subject_name'},
            {data:'homework_date'},
            {data:'submission_date'},
            { data: 'action', orderable: false, searchable: false },
        ]
    });
    
    var StudentHomeworkTable= $('#StudentHomeworkTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        ajax: '{{ route("StudentHomework") }}',
        "columns": [
            { data: 'DT_RowIndex' },
            { data: 'class' },
            { data: 'section' },
            { data:'subject_name'},
            { data:'student_name'},
            { data:'homework_date'},
            { data:'submission_date'},
            { data:'status'},
            { data: 'action', orderable: false, searchable: false },
        ]
    });
    $( document ).ready(function() {
        //CLASS HOMEWORK
      
            $('#AddClassHomeworkForm').on('submit', function(event){
            console.log($('#AddClassHomeworkForm').serialize());
            var form = $( "#AddClassHomeworkForm" );
            form.validate();
            event.preventDefault();
          
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("AddHomework") }}',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        if(data.status == 'error'){
							toastr.error(data.message);
                            $("#AddClassHomeworkForm").valid().showErrors(data.errors);
                        }else{
							toastr.success(data.message);
							$('#student_class').val("").trigger("chosen:updated");
							$('#section_id').val("").trigger("chosen:updated");
							$('#subject_id').val("").trigger("chosen:updated");
							$("#AddClassHomeworkForm")[0].reset();
							
                            $('#AddHomeworkModal').modal('hide');
                            ClassHomeworkTable.ajax.reload();
                            
                        }
                    }
                });
            }
        });

        $('body').on('click','.EditClassHomework',function (e) {
            e.preventDefault();
            var homework_id = $(this).attr('id');
            if(homework_id != ''){
                $.ajax({
                    type: "get",
                    url: '{{ route("editHomework") }}',
                    data:{homework_id:homework_id},
                    success: function(data) {
                        console.log(data);
                        if(data.status == 'success'){
                            var class_id=data.Homework.class_id;
                            var section_id=data.Homework.section_id;
                            var subject_id=data.Homework.subject_id;
                            $('.homework_id').val(data.Homework.id);
                            $('.student_class').val(data.Homework.class_id);
                            $('.section_id').val(data.Homework.section_id);
                            $('.homework_date').val(data.Homework.homework_date);
                            $('.submission_date').val(data.Homework.submission_date);
                            $('.description').val(data.Homework.description);
                            get_classes(class_id);
                            get_section(section_id);
                            get_subject_list(subject_id);
                        }else{
                            $('#editSectionModal').modal('hide');
                        }
                    }
                });
            }
        });


       
            $('#UpdateClassHomeworkForm').on('submit', function(event){
            var form = $( "#UpdateClassHomeworkForm" );
            form.validate();
            console.log($('.UpdateClassHomework').serialize());
            event.preventDefault();
            var checkValid = form.valid();

            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("UpdateHomework") }}',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        if(data.status == 'error'){
							toastr.error(data.message);
                            $("#UpdateClassHomeworkForm").valid().showErrors(data.errors);
                        }else{
							toastr.success(data.message);
                            $('#EditClassHomework').modal('hide');
                            ClassHomeworkTable.ajax.reload();
                            $("#UpdateClassHomeworkForm")[0].reset();
                        }
                    }
                });
            }
        });


        $('body').on('click','.DeleteClassHomework',function () {
            var homework_id = $(this).attr('id')          
            $(".DeleteConfirmed").click(function(e) {
                e.preventDefault();
                if (homework_id != '') {
                    $.ajax({
                        type: "post",
                        url: '{{ route("DeleteHomework") }}',
                        data: {homework_id: homework_id},
                        success: function (data) {
                            if(data.status == 'error'){
								toastr.error(data.message);
                                ClassHomeworkTable.ajax.reload();
                            }else{
								toastr.success(data.message);
                                $('#DeleteModel').modal('hide');
                                ClassHomeworkTable.ajax.reload();
                            }
                        }
                    });
                }
            });
        });
        //END CLASS HOMEWORK
        //START STUDENT HOMEWORK
       
            $('#AddStudentHomeworkForm').on('submit', function(event){
          
            // console.log($('#AddStudentHomeworkForm').serialize());
            var form = $( "#AddStudentHomeworkForm" );
            form.validate();
            event.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("AddHomework") }}',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        if(data.status == 'error'){
							toastr.error(data.message);
                            $("#AddStudentHomeworkForm").valid().showErrors(data.errors);
                        }else{
							toastr.success(data.message);
							$('#class_id').val("").trigger("chosen:updated");
							$('#stud_section_id').val("").trigger("chosen:updated");
							$('#stud_subject_id').val("").trigger("chosen:updated");
							$('.studentlist').hide();
							$('.homeworkdetails').hide();
                            $('#AddStudentHomeworkModal').modal('hide');
                            StudentHomeworkTable.ajax.reload();
                            $("#AddStudentHomeworkForm")[0].reset();
                        }
                    }
                });
            }
        });

        $('body').on('click','.EditStudentHomework',function (e) {
            e.preventDefault();
            var homework_id = $(this).attr('id');
            if(homework_id != ''){
                $.ajax({
                    type: "get",
                    url: '{{ route("EditStudentHomework") }}',
                    data:{homework_id:homework_id},
                    success: function(data) {
                        console.log(data);
                        if(data.status == 'success'){
                            var subject_id=data.Studenthomework[0].subject_id;
                            $('.student_name').html(data.Studenthomework[0].student_name);
                            $('.student_class').html(data.Studenthomework[0].class_id);
                            $('.student_section').html(data.Studenthomework[0].section);
                            $('.student_email').html(data.Studenthomework[0].email);
                            $('.student_homework_id').val(data.Studenthomework[0].homework_id);
                            $('.stud_homework_date').val(data.Studenthomework[0].homework_date);
                            $('.stud_submission_date').val(data.Studenthomework[0].submission_date);
                            $('.stud_description').val(data.Studenthomework[0].description);
                            get_subject_list(subject_id);
                        }else{
                            // $('#editStudentHomeworkModal').modal('hide');
                        }
                    }
                });
            }
        });


       
            $('#UpdateStudentHomeworkForm').on('submit', function(event){
            var form = $( "#UpdateStudentHomeworkForm" );
            form.validate();
            event.preventDefault();
            var checkValid = form.valid();

            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("UpdateHomework") }}',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        if(data.status == 'error'){
							toastr.error(data.message);
                            $("#UpdateStudentHomeworkForm").valid().showErrors(data.errors);
                        }else{
							toastr.success(data.message);
                            $('#editStudentHomeworkModal').modal('hide');
                            StudentHomeworkTable.ajax.reload();
                            $("#UpdateStudentHomeworkForm")[0].reset();
                        }
                    }
                });
            }
        });


        $('body').on('click','.DeleteStudentHomework',function () {
            var homework_id = $(this).attr('id');          
            $(".DeleteStudentConfirmed").click(function(e) {
                e.preventDefault();
                if (homework_id != '') {
                    $.ajax({
                        type: "post",
                        url: '{{ route("DeleteHomework") }}',
                        data: {homework_id: homework_id},
                        success: function (data) {
                            if(data.status == 'error'){
								toastr.error(data.message);
                                StudentHomeworkTable.ajax.reload();
                            }else{
								toastr.success(data.message);
                                $('#DeleteModel').modal('hide');
                                StudentHomeworkTable.ajax.reload();
                            }
                        }
                    });
                }
            });
        });
        //END STUDENT HOMEWORK
        function get_classes(class_id){       
        var selectclass='';
        $.ajax({
                    type: "get",
                    url: '{{ route("GetClassList") }}',
                    data:{class_id:class_id},
                    success: function(data) {
                        console.log(data);
                        for (var key in data) {
                          var row = data[key];
                          var sel = "";
                          if (class_id == row.class) {
                            sel = "selected";
                            }
                        
                          selectclass += "<option value='" + row.class + "'"+sel+">" + row.class + "</option>";
                      }
                      $('.edit_student_class').html(selectclass);
                    }
                });
      }  
      function get_section(section_id){
        var select_section='';
        $.ajax({
                    type: "get",
                    url: '{{ route("GetSectionList") }}',
                    data:{section_id:section_id},
                    success: function(data) {
                        console.log(data);
                        for (var key in data) {
                          var row = data[key];
                          var sel = "";
                            if (section_id == row.id) {
                            sel = "selected";
                            }
                          select_section += "<option value='" + row.id + "'"+sel+">" + row.section + "</option>";
                      }
                      $('.section_id').html(select_section);
                    }
                });
      }
      function get_subject_list(subject_id){
         var select_subject=""; 
       
         $.ajax({
                    type: "get",
                    url: '{{ route("GetSubjectList") }}',
                    data:{subject_id:subject_id},
                    success: function(data) {
                        console.log('subjects',data);
                        for (var key in data) {
                          var row = data[key];
                          var sel = "";
                            if (subject_id == row.id) {
                            sel = "selected";
                            }
                            select_subject += "<option value='" + row.id + "'"+sel+">" + row.subject_name+ "</option>";
                      }
                      $('.subject_id').html(select_subject);
                    }
                });
      }
      $('body').on('click','.GetStudents',function () {
       var class_id= $(this).attr("data-class_id");
       var section_id= $(this).attr("data-section_id");
       var homework_id = $(this).attr('id');
       $('#assigned_homework_id').val(homework_id);  
       get_students_homework(class_id,section_id,homework_id);
    });
    });

</script>
<script>
    function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
 
}
    // get students
    $('.get_students').click(function(){
        var class_id = $('#class_id').val();
        var section_id = $('#stud_section_id').val();
        
        get_students(class_id,section_id);
    });
    function get_students(class_id,section_id){
        var studentlist = "";
        if(class_id .length === 0 && section_id .length === 0){
            alert('Please Choose class and Section');
        }else{
            $.ajax({
                    type: "post",
                    url: '{{ route("getStudent") }}',
                    data:{class_id:class_id,section_id:section_id},
                    success: function(data) {
                     console.log('students',data);
                     if(data .length === 0){
                        alert('No Students Found');
                     }else{
                     for (var key in data) {
                            var row = data[key];
                           
                            studentlist +="<tr><td>"+row.student_name+"</td><td>"+row.student_class+"</td><td>"+row.section_id+"</td><td> <input class='checkboxall' type='checkbox' name='sel_student[]' value="+row.id+"></td></tr>";  
                        }
                        $('.get_students').hide();
                        $('.set_homework').show();
                        $('.studentlist').html(studentlist);
                     }
                    }
                });
        }
    }
    function get_students_homework(class_id,section_id,homework_id){
     
        var homework_assigned_list = "";
        var button="";
        if(class_id .length === 0 && section_id .length === 0){
            alert('Please Choose class and Section');
        }else{
            $.ajax({
                    type: "post",
                    url: '{{ route("getStudent") }}',
                    data:{class_id:class_id,section_id:section_id,homework_id:homework_id},
                    success: function(data) {
                     console.log('students',data);
                     if(data .length === 0){
                        alert('No Students Found');
                     }else{
                      var button='';
                     for (var key in data) {
                        var submission_button='';
                            var row = data[key];
                            var student_id=row.id;  
                       if(row.submitted.length===0){
                        button ="<button class='btn btn-danger'>Not Submitted</button>";    
                       }else{
                        button ="<button id='"+student_id+"'data-toggle='modal' data-target='#showStudentHomeworkSubmits'data-homework_id='"+homework_id+"'class='btn btn-primary view_student_homework'>View</button>";   
                       }
                  
                homework_assigned_list +="<tr><td class='get_student_homework'id="+row.id+">"+row.student_name +"</td><td>"+row.student_class+"</td><td>"+row.section_id+"</td><td>"+button+"</td></tr>"; 
                        }
                       
                        $('.assigned_homeworks').html(homework_assigned_list);
                     }
                    }
                });
        }
    }
    
    $('body').on('click','.view_student_homework',function () {
        var student_id = $(this).attr('id');
    var homework_id= $(this).attr("data-homework_id");
   
    $.ajax({
                        type: "post",
                        url: '{{ route("GetIndividualStudentHomework") }}',
                        data: {student_id:student_id,homework_id: homework_id},
                        success: function (data) {
                            console.log(data);
                             
                            if(data.status == 'error'){
                                var error="Not Submitted";
                                $('.error').html(error);            
                                $('.status_div').hide();
                            }else{
                                $('.error').remove();            
                                $('.status_div').show();
                             var submit_on=data.Studenthomework[0].submitted_on;
                             // if(data.Studenthomework[0].status=="Approved"){
                                 // $('.change_homework_status').hide();
                             // }
                             var file ="{{ URL::to('/') }}"+data.Studenthomework[0].homework_attachment ;
                             var downloadlink="<img src='"+file+"'class='btn btn-success downloadfile'width='300px'height='300px'>";
                                $('#submitted_on').html(submit_on);
                                $('#status').html(data.Studenthomework[0].status);
                                // $('#student_upload_file').html(downloadlink);
                                $('.change_homework_status').attr( 'data-homework_id',data.Studenthomework[0].homework_id);
                                $('.change_homework_status').attr( 'data-student_id',data.Studenthomework[0].student_id);
                            var img = new Image;
							img.setAttribute('crossOrigin', 'anonymous');
							img.onload = setup;
							img.src =file;

						function setup() {
							var canvas = document.querySelector("canvas"),
							
							ctx = canvas.getContext("2d"),
							lastPos, isDown = false;
							
							ctx.drawImage(this, 0, 0, canvas.width, canvas.height);    
							ctx.lineCap = "round";                                   // make lines prettier
							ctx.lineWidth = 1;
							ctx.globalCompositeOperation = "blue";               // KEY MODE HERE
							// ctx.clearRect(0, 0, canvas.width, canvas.height);
							// ctx.restore();
							canvas.onmousedown = function(e) {
							isDown = true;
							lastPos = getPos(e);
							};
						window.onmousemove = function(e) {
						if (!isDown) return;
						var pos = getPos(e);
						ctx.beginPath();
						ctx.moveTo(lastPos.x, lastPos.y);
						ctx.lineTo(pos.x, pos.y);
						ctx.stroke();
						lastPos = pos;
						};
						window.onmouseup = function(e) {isDown = false};
    
						function getPos(e) {
						var rect = canvas.getBoundingClientRect();
						var element='';
						element= {x: e.clientX - rect.left, y: e.clientY - rect.top};
						$('.delete_element').click(
                                    function() {
									ctx.restore();

                                    }).removeClass('hide').show();
						console.log(element);
						return element;
						}
						}
						

						   }
                        }
                    });
					
    });
  
   
       
        
       $(".change_homework_status").click(function(){
		   var marks_obtained = $('#mark').val();
		   if(marks_obtained == ''){
			alert('Please Add Mark For The Student');   
		   }else{
				var canvas = document.getElementById("student_upload_file");
				var dataURL = canvas.toDataURL("image/png");
				 // console.log(dataURL); 
				document.getElementById('hidden_data').value = dataURL;
				var homework_id= $(this).attr("data-homework_id");
				var student_id= $(this).attr("data-student_id");
				var status= $(this).attr("data-homework_status");
				
				var image= $('#hidden_data').val();
				
				var fd = new FormData(document.forms["form1"]);
            var remark='';
            if(status=='Remarked'){
                var status= $(this).attr("data-homework_status");
                var remark=$('#remark').val();
            }		
			  var imageURL = canvas.toDataURL(); 
			  var homework_id=[homework_id];
				var student_id=[student_id];
				var status=[status];
				var remark=[remark];
				var image=[image];
				var marks_obtained=[marks_obtained];
			var post_url= '{{ route("ChangeHomeworkStatus") }}';
			var ajaxHandler = new XMLHttpRequest();
			ajaxHandler.open("POST", post_url, true);
			fd.append("student_id",student_id);
            fd.append("homework_id",homework_id);
            fd.append("status",status);
            fd.append("remark",remark);
            fd.append("image",image);
            fd.append("marks_obtained",marks_obtained);
            $.ajax({
                url: '{{ route("ChangeHomeworkStatus") }}',
                data:fd,
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false,
				 success: function(data) {
                       
                        if(data.status == 'success'){
						toastr.success(data.message);
                        $('#showStudentHomeworkSubmits').modal('hide');						   
                        }else{
						toastr.error(data.message);
                        }
                    }
            })      
			ajaxHandler.send(fd);
		   }
		 });
   
    $(".set_homework").click(function(){
        $('.homeworkdetails').show();
    });
    $(".selectall").click(function(){
        if(this.checked){
            $('.checkboxall').each(function(){
                $(".checkboxall").prop('checked', true);
            })
        }else{
            $('.checkboxall').each(function(){
                $(".checkboxall").prop('checked', false);
            })
        }
    });
    // Get the element with id="defaultOpen" and click on it
   
    $('.defaulttab').trigger('click');
    </script>
   
