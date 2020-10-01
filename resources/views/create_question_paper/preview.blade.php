@extends('layouts.master')

@section('question_paper_views')
active
@endsection

@section('question_paper_management')
active open
@endsection

@section('content')
<style>
#menu-toggle {
    float: right;
}
#sidemenu {
    padding-right: 0;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}
#sidemenu.toggled {
    padding-right: 250px;
}
#sidebar-wrapper {
    z-index: 1000;
    position: fixed;
    right: 250px;
    width: 0;
    height: 70%;
    margin-right: -250px;
    overflow-x: hidden;
    background: #e7eaeb;
    border: .1px solid #c18e8e;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}
#sidemenu.toggled #sidebar-wrapper {
    width: 250px;
}
#page-content-wrapper {
    width: 100%;
    position: absolute;
    padding: 15px;
}
#sidemenu.toggled #page-content-wrapper {
    position: absolute;
    margin-left: -250px;
}
/* Sidebar Styles */
 .sidebar-nav {
    position: absolute;
    top: 0;
    width: 250px;
    margin: 0;
    padding: 0;
    list-style: none;
}
.sidebar-nav li {
    text-indent: 20px;
    line-height: 30px;
    padding-right: 17%;
}
.sidebar-nav li a {
    display: block;
    text-decoration: none;
    color: #999999;
}
.sidebar-nav li a:hover {
    text-decoration: none;
    color: #fff;
    background: rgba(255, 255, 255, 0.2);
}
.sidebar-nav li a:active, .sidebar-nav li a:focus {
    text-decoration: none;
}
.sidebar-nav > .sidebar-brand {
    height: 65px;
    font-size: 18px;
    line-height: 60px;
}
.sidebar-nav > .sidebar-brand a {
    color: #999999;
}
.sidebar-nav > .sidebar-brand a:hover {
    color: #fff;
    background: none;
}
@media(min-width:768px) {
    #sidemenu {
        padding-right: 250px;
    }
    #sidemenu.toggled {
        padding-right: 0;
    }
    #sidebar-wrapper {
        width: 200px;
    }
    #sidemenu.toggled #sidebar-wrapper {
        width: 0;
    }
    #page-content-wrapper {
        padding: 20px;
        position: relative;
    }
    #sidemenu.toggled #page-content-wrapper {
        position: relative;
        margin-left: 0;
    }
}
.settings {
	position: -webkit-sticky; /* Safari & IE */
position: sticky;
top: 30px;
}
</style>
    <section id="content">

        <div class="page page-tables-datatables">
		
            <div class="row">
                <div class="col-md-12">
				
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font exam_detail"><strong>Exam Details</h1>
								<input type="hidden"name="question_paper_id"value="{{$PaperDetails->id}}"id="question_paper_id"> 
                        </div>
						<div class="panel-group" id="accordion">
				 <div id="sidemenu">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li>
			 <label> Change Font </label>
      <select id="changefont" class="form-control" name="font[name]">
        <?php 
		$fontFamilies=getFontFamily(); 
		$fontsizeandheight=getFontfontsizelineheight(); 
		$getFontfontsize=getFontfontsize(); 
		
		?>
		@foreach($fontFamilies as $fontsf)
			<option value="{{$fontsf}}"<?php if($QuestionPaperUi->font_family==$fontsf){ echo "selected"; } ?> >{{$fontsf}}</option>
		@endforeach
      </select>
            </li>
			<li>
			Font Size 
      <select id="changesize" class="form-control" name="font[size]">
		@foreach($getFontfontsize as $fonts)
			<option value="{{$fonts}}"<?php if($QuestionPaperUi->font_size==$fonts){ echo "selected"; } ?>>{{$fonts}}</option>
		@endforeach
      </select>
	  </li>
	  <li>
      <label> Line Space </label>
      <select id="changespace" class="form-control" name="font[linespace]">
        @foreach($fontsizeandheight as $fontlh)
			<option value="{{$fontlh}}"<?php if($QuestionPaperUi->line_spacing==$fontlh){ echo "selected"; } ?>>{{$fontlh}}</option>
		@endforeach
      </select>
	  </li>
	  <li>
      <label> Question Spaces </label>
      <select id="question_space" class="form-control" name="font[qstspace]">
        @foreach($fontsizeandheight as $fontqs)
			<option value="{{$fontqs}}"<?php if($QuestionPaperUi->question_spacing==$fontqs){ echo "selected"; } ?>>{{$fontqs}}</option>
		@endforeach
      </select>
	  </li>
	  <li><input type="checkbox"id="hideregno"class="menuchange"name="hideregno"value="hide"<?php if($QuestionPaperUi->hideregno != ''){ echo "checked"; } ?>>Hide Reg No</li>
		<li><input type="checkbox"id="hideexamname"name="hideexamname"class="menuchange"value="hide"<?php if($QuestionPaperUi->hideexamname != ''){ echo "checked"; } ?>>Hide Exam Name</li>
		<li><input type="checkbox"id="hidedate"name="hidedate"class="menuchange"value="hide"<?php if($QuestionPaperUi->hidedate != ''){ echo "checked"; } ?>>Hide Date</li>
		<li><input type="checkbox"id="hidesubject"name="hidesubject"class="menuchange"value="hide"<?php if($QuestionPaperUi->hidesubject != ''){ echo "checked"; } ?>>Hide Subject</li>
		<li><input type="checkbox"id="hidemarks"name="hidemarks"class="menuchange"value="hide"<?php if($QuestionPaperUi->hidemarks != ''){ echo "checked"; } ?>>Hide Marks</li>
    </div>
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <a href="#menu-toggle" class="btn btn-default settings" id="menu-toggle"><i class="fa fa-cog"></i></a>

        </div>
    </div>
    <!-- /#page-content-wrapper -->
</div>
</div>
						 <div class="tab toptabs">
                                        <button class="tablinks defaulttab active" onclick="openCity(event, 'Questions')">{{$PaperDetails->exam_name}}</button>
                                        <button class="tablinks" onclick="openCity(event, 'AnswerKey')">{{$PaperDetails->exam_name}} Answer Key</button>
                                        <button class="tablinks" onclick="openCity(event, 'QuestionWithAnswers')">{{$PaperDetails->exam_name}} Question With Answer</button>
                                        <button class="tablinks" onclick="openCity(event, 'QuestionWithAnswersInFinal')">{{$PaperDetails->exam_name}} Question With Answer in Final</button>
                         </div>
                        <!-- /tile header -->

                        <!-- tile body -->
						<div class="appenddatas">
					
						</div>
     

                    </section>
                </div>
            </div>
        </div>
		
    </section>
	<div id="QuestionsList" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4><div class="message"></div><div class="Errormessage"></div>
      </div>
      <div class="modal-body">
	  <table class="table">
	  <thead>
	  <tr>
	  <th>Questions</th>
	  <th>Select</th>
	  </tr>
	  </thead>
	  <tbody class="questions">
	  
	  </tbody>
	  </table>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endsection

@section('script')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
   <script>
   $("#menu-toggle").click(function (e) {
		e.preventDefault();
		$("#sidemenu").toggleClass("toggled");
	});
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	$(document).ready(function(){
		$("#sidemenu").toggleClass("toggled");
		get_datas();
		function get_datas(){
			var paper_id=$('#question_paper_id').val();
		    $.ajax({
                    type: "get",	
                    url: '{{ route('getPreviewDatas') }}',
                    data:{paper_id:paper_id},					
                    success: function(data) {
					$('.appenddatas').html(data);
					}
					});	
		}
	
			$('body').on('change','#changefont',function (e) {
                    var font_family = $(this).val();
					
					// $('.exam_detail').css('background-color', '#ff0000');
					var font_size = $('#changesize').val();
					var line_height = $('#changespace').val();
					var question_space = $('#question_space').val();
					var question_paper_id = $('#question_paper_id').val();
					var element = "updated_at";
					var value = "<?php echo date('Y-m-d H:s:i'); ?>" ;
					// $('.everydetails').css('font-family',font_family);
					// $('.rowsection').css('line-height',line_height);
					// $('.questionname').css('line-height',question_space);
					  $.ajax({
                    type: "get",	
                    url: '{{ route('UpdateQuestionPaperUi') }}',
                    data:{element:element,value:value,font_family:font_family ,question_space:question_space ,font_size:font_size,line_height:line_height,question_paper_id:question_paper_id},
                    success: function(data) {
					console.log(data);
					// get_datas();
                    }
					});
            });
			$('body').on('change','#changesize',function (e) {
                    var font_size = $(this).val();
					var question_space = $('#question_space').val();
                    var font_family = $('#changefont').val();
					var line_height = $('#changespace').val();
					var question_paper_id = $('#question_paper_id').val();
					var element = "updated_at";
					var value = "<?php echo date('Y-m-d H:s:i'); ?>" ;
					$('.everydetails').css('font-family',font_family);
					$('.rowsection').css('line-height',line_height);
					$('.questionname').css('line-height',question_space);
					  $.ajax({
                    type: "get",	
                    url: '{{ route('UpdateQuestionPaperUi') }}',
                    data:{element:element,value:value,font_family:font_family ,question_space:question_space ,font_size:font_size,line_height:line_height,question_paper_id:question_paper_id},
                    success: function(data) {
					// console.log(data);
					// get_datas();
                    }
                });
            });
			$('body').on('change','#changespace',function (e) {
                    var line_height = $(this).val();
					var question_space = $('#question_space').val();
					var font_size = $('#changesize').val();
                    var font_family = $('#changefont').val();
					var question_paper_id = $('#question_paper_id').val();
					var element = "updated_at";
					var value = "<?php echo date('Y-m-d H:s:i'); ?>" ;
					$('.everydetails').css('font-family',font_family);
					$('.rowsection').css('line-height',line_height);
					$('.questionname').css('line-height',question_space);
					// changeui(question_space,line_height,font_size,font_family);
					  $.ajax({
                    type: "get",	
                    url: '{{ route('UpdateQuestionPaperUi') }}',
                    data:{element:element,value:value,font_family:font_family ,question_space:question_space ,font_size:font_size,line_height:line_height,question_paper_id:question_paper_id},
                    success: function(data) {
					// console.log(data);
					// get_datas();
                    }
                });
            });
			$('body').on('change','#question_space',function (e) {
                    var question_space = $(this).val();
					var element = "updated_at";
					var value = "<?php echo date('Y-m-d H:s:i'); ?>" ;
                    var line_height = $('#changespace').val();
					var font_size = $('#changesize').val();
                    var font_family = $('#changefont').val();
					var question_paper_id = $('#question_paper_id').val();
					$('.everydetails').css('font-family',font_family);
					$('.rowsection').css('line-height',line_height);
					$('.questionname').css('line-height',question_space);
					  $.ajax({
                    type: "get",	
                    url: '{{ route('UpdateQuestionPaperUi') }}',
                    data:{element:element,value:value,font_family:font_family ,question_space:question_space ,font_size:font_size,line_height:line_height,question_paper_id:question_paper_id},
                    success: function(data) {
					// console.log(data);
					// get_datas();
                    }
                });
            });
			$('body').on('change','.menuchange',function (e) {			
                    var element = $(this).attr('id');
					var value = $('#'+element).val()
					if(value ==''){
					$('#'+element).val('hide'); 
					}else{
					$('#'+element).val('');
					}			
					var question_space = $('#question_space').val();
                    var line_height = $('#changespace').val();
					var font_size = $('#changesize').val();
                    var font_family = $('#changefont').val();
					var question_paper_id = $('#question_paper_id').val();
					$.ajax({
                    type: "get",	
                    url: '{{ route('UpdateQuestionPaperUi') }}',
                    data:{element:element,value:value,font_family:font_family ,question_space:question_space ,font_size:font_size,line_height:line_height,question_paper_id:question_paper_id},
                    success: function(data) {					
					get_datas();
                    }
					}); 
            });		
	});	
			
		function openCity(evt, cityName) {
			var i, tabcontent, tablinks;
			tabcontent = document.getElementsByClassName("tabcontent");
			for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
			// tabcontent[i].removeClass('active');
			}
			tablinks = document.getElementsByClassName("tablinks");
			for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace("active", "");
			// tabcontent[i].className.addClass('active');
			tablinks[i].classList.add("mystyle");
			}
			document.getElementById(cityName).style.display = "block"; 
		}

  // $(document).on("click", ".change_question", function() {
		$('body').on('click','.addnewQuestion',function (e) {	  
			var question_id = $(this).data("Qid");
			var segregation_id = $(this).data("segrigation_id");
			var chapter_id = $(this).data("chapter_id");
			var row_id = $(this).data("row_id");
			var blueprint_id= $('#blueprint_id').val();
			var question_paper_id= $('#question_paper_id').val();		
			$.ajax({
                    type: "get",					
                    url: '{{ route('Getnewquestions') }}',
                    data:{question_id:question_id , segregation_id:segregation_id,chapter_id:chapter_id,blueprint_id:blueprint_id,question_paper_id:question_paper_id,row_id:row_id},
					dataType:'JSON',
                    success: function(data) {
						console.log(data);
						var questions = '';
						var i;
							if(data.questions.length === 0){
								alert('no More Questions in this Segregation');
								$('.Errormessage').text("No More Questions");
							}else{
							for(i=0; i<data.questions.length; i++){						
								questions += '<tr>'+
		                  		'<td>'+data.questions[i].question_name+'</td>'+
		                  		'<td><input type="radio"class="add_question"data-segregation_id="'+data.questions[i].segregation_id+'"data-chapter_id="'+chapter_id+'"name="replace_question"data-question_paper_id="'+question_paper_id+' "value='+data.questions[i].id+'></td>'+
		                        '</tr>';
								}
								$('.questions').html(questions);					  
							}
					}
                });			
		});
		$('body').on('click','.ReplaceQuestion',function (e) {		  
				var question_id = $(this).data("question_id");
				var segregation_id = $(this).data("segrigation_id");
				var row_id = $(this).data("row_id");
				var chapter_id = $(this).data("chapter_id");
				var blueprint_id = $("#blueprint_id").val();
				var question_paper_id= $("#question_paper_id").val();
				$.ajax({
                    type: "get",
					
                    url: '{{ route('Getnewquestions') }}',
                    data:{question_id:question_id , segregation_id:segregation_id,chapter_id:chapter_id,blueprint_id:blueprint_id,question_paper_id:question_paper_id,row_id:row_id},
					dataType:'JSON',
                    success: function(data) {
						console.log(data);
						var questions = '';
						var i;
						if(data.questions.length === 0){
							alert('no More Questions in this Segregation');
							$('.Errormessage').text("No More Questions");
						}else{
								for(i=0; i<data.questions.length; i++){					
								questions += '<tr>'+
		                  		'<td>'+data.questions[i].question_name+'</td>'+
		                  		'<td><input type="radio"class="replace_question" data-row_id="'+data.row_id +'"data-segregation_id="'+data.questions[i].segregation_id+'"data-chapter_id="'+chapter_id+'"name="replace_question"data-question_paper_id="'+question_paper_id+' "value='+data.questions[i].id+'></td>'+
		                        '</tr>';
								}
								$('.questions').html(questions);					  
							}
					}
                });	
		});
	$('body').on('change','.replace_question',function (e) {
            var question_id = $(this).val();
            var row_id = $(this).data('row_id');
            var segregation_id = $(this).data('segregation_id');
            var question_paper_id = $(this).data('question_paper_id');		  
				$.ajax({
				type: "get",	
                url: '{{ route('ReplaceNewQuestion') }}',
                data:{question_id:question_id ,segregation_id:segregation_id,question_paper_id:question_paper_id,row_id:row_id},
				success: function(data) {
					// console.log(data);
					if(data.status == "success"){
					toastr.success(data.message);
					window.location.reload();
					}
                }
                });
    });
	$('body').on('change','.add_question',function (e) {
                    var question_id = $(this).val();
                    var segregation_id = $(this).data('segregation_id');
                    var question_paper_id = $(this).data('question_paper_id');	
				    $.ajax({
						type: "get",	
						url: '{{ route('StoreNewQuestion') }}',
						data:{question_id:question_id ,segregation_id:segregation_id,question_paper_id:question_paper_id},
						success: function(data) {
							if(data.status == "success"){
							toastr.success(data.message);
							window.location.reload();
							}
						}
					});
    });
			
			
			function changeui(question_space,line_height,font_size,font_family){
				
				$('.rowsection').css('line-height:'+line_height+'px')
				$('.everydetails').css('font-family:'+font_family+'px')
				$('.everydetails').css('font-size:'+font_size+'px')
				$('.questionname').css('font-size:'+question_space+'px')
			}
	 function printDiv(value) {
		 var blueprint_id = $("#blueprint_id").val();
		var question_paper_id= $("#question_paper_id").val();
		  $.ajax({
                    type: "get",					
                    url: '{{ route('GetPrintData') }}',
                    data:{blueprint_id:blueprint_id,question_paper_id:question_paper_id,value:value},
                    success: function(data) {
						// console.log(data);
						Popup(data);
					}
                });	
        }
        	function Popup(data)
    {

        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
//Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
// frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/idcard.css">');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body>');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
        return true;
    }

</script>


@endsection

