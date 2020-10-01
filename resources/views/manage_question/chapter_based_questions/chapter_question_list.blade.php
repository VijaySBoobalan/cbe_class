@extends('layouts.master')

@section('overview_chapter_based_questions')
active
@endsection

@section('chapterbsed_question_menu')
active open
@endsection

@section('content')
<style>
    /* Style the tab */
    .tab {
      overflow: hidden;
      border: 1px solid #ccc;
      background-color: ##bfbdbd;
    }

    /* Style the buttons inside the tab */
    .tab button {
      background-color: inherit;
      float: left;
      border: none;
      outline: none;
      cursor: pointer;
      padding: 14px 16px;
      transition: 0.3s;
      font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
      background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
      background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
      display: none;
      padding: 6px 12px;
      border: 1px solid #ccc;
      border-top: none;
    }
    </style>
    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Overview Chapter Based Questions</h1>
							<ul class="controls">
                                    <li>
                                        <a href="{{ route('ChapterBasedQuestion') }}"><i class="fa fa-plus mr-5"></i>Chapter Based Questions</a>
                                    </li>
                                </ul>
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
						 <div class="row">
                                <div class="col-sm-12">
                                    <div class="tab">
                                        <button class="tablinks defaulttab" onclick="openCity(event, 'Questions')">Question Details</button>
                                        <button class="tablinks" onclick="openCity(event, 'QuestionsAnswers')">Question Answer Details</button>
                                    </div>
                                </div>
                            </div>
							   <div id="Questions"style="display: block;" class="tabcontent">
                                   <div class="table-responsive">
                                <table class="table table-custom" id="OverviewChapterQuestions">
                                    <thead>
                                    <tr>
									 <th>S.No</th>
                                     <th>Pattern Name</th>
                                     <th>Class</th>
                                     <th>Subject</th>
                                     <th>Chapter</th>
                                     <th>Segregation Count</th>
                                     <th>Questions Count</th>
                                     <th>Action</th>
                                        
                                    </tr>
                                    </thead>
                                        @php
                                          $key = 0;
                                        @endphp
                                    <tbody>
                                    @foreach($chapter_questions as $key=>$pattern_details)  
									<tr>
									<td>{{ ++$key }}</td>
									<td>{{ $pattern_details->pattern_prefix }}</td>
									<td>{{ $pattern_details->class_id }}</td>
									<td>{{ $pattern_details->subject_name }}</td>
									<td>{{ $pattern_details->unit_name }}</td>
									<td>
									@foreach($segregations as $seg)
									<?php $countQuestions = getSegregationQuestionCount($seg->id,0); ?>
									<p>{{ $seg->segregation }} : {{ $countQuestions }}</p>
									@endforeach
									</td>
									<!--a href=""><i class="fa fa-pencil text-aqua"></i></a-->
									<td>
									@foreach($segregations as $segregation_details)
									<?php $count=getpreperationQuestionStoredCount($pattern_details->id,$segregation_details->id); $segregationId=$segregation_details->id ?>
									<p>{{ $segregation_details->segregation }} : {{ $count }} <a href="{{ action('ManageQuestions\ChapterBasedQuestionController@ChapterquestioneditSegregation',[$pattern_details->id,$segregationId]) }}"><i class="fa fa-pencil text-aqua"></i></a></p>
									@endforeach
									</td>
								
									<td>
									<a href="{{ action('ManageQuestions\ChapterBasedQuestionController@ChapterBasedQuestionedit',[$pattern_details->id]) }}"><i class="fa fa-pencil text-aqua"></i></a>
									<a class ="previewquestions" data-pattern_id="{{ $pattern_details->id }}"data-chapter_id="{{ $pattern_details->chapter_id }}" href="#"><i class="fa fa-print text-aqua preview"></i></a>
									<a href="{{ route('ChapterBasedQuestiondelete',$pattern_details->id) }}"><i class="fa fa-trash-o" style="color:red;"> </i></a>
									</td>
									</tr>
									@endforeach
                                    </tbody>
                                </table>
                            </div>
                            </div>
							   <div id="QuestionsAnswers" class="tabcontent">
                                   <div class="table-responsive">
                                <table class="table table-custom" id="OverviewChapterQuestionAnswers">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Pattern Name</th>
                                        <th>Class</th>
										<th>Subject</th>
										<th>Chapter</th>
                                        <th>Questions</th>                                       
                                        <th>Answer Options</th>
										<th>Answers</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                        @php
                                          $key = 0;
                                        @endphp
                                    <tbody>
									<?php //print_R($chapter_questions); ?>
                                    @foreach($chapter_questions as $key=>$pattern_details)  
									<tr>
									<td>{{ ++$key }}</td>
									<td>{{ $pattern_details->pattern_prefix }}</td>
									<td>{{ $pattern_details->class_id }}</td>
									<td>{{ $pattern_details->subject_name }}</td>
									<td>{{ $pattern_details->unit_name }}</td>
									<td>
									@foreach($pattern_details->details as $question_details)
									<p>{{ $question_details->segregation }} </p>
									@foreach($question_details->questions as $question)
									<p>{!! $question->question_name !!} </p>
									@endforeach
									@endforeach
									</td>
									<td>
									@foreach($pattern_details->details as $question_details)
									<p>--</p><br>
									@foreach($question_details->questions as $question)
									 <?php if($question->answer_option) { ?>
									<p>@foreach(unserialize($question->answer_option) as $key2 => $Que)
									{{ $key2 }}). {{ $Que }} 
									 
									@endforeach </p>
									 <?php } else{ echo "<br>"; }?>
									@endforeach
									@endforeach
									</td>
									
									<td>
									@foreach($pattern_details->details as $question_details)
									<p>-- </p>
									@foreach($question_details->questions as $question)
									
									<p><?php foreach(unserialize($question->answer) as $keyanswer => $answer) {
									echo $answer ;
									 
									 } ?> </p>
									@endforeach
									@endforeach
									</td>
									<td>
									<a class ="previewquestions" data-pattern_id="{{ $pattern_details->id }}"data-chapter_id="{{ $pattern_details->chapter_id }}" href="#"><i class="fa fa-print text-aqua preview"></i></a>
									<a href="{{ action('ManageQuestions\ChapterBasedQuestionController@ChapterBasedQuestionedit',[$pattern_details->id,$pattern_details->chapter_id]) }}"><i class="fa fa-pencil text-aqua"></i></a>
									<a href="{{ route('ChapterBasedQuestiondelete',$pattern_details->id) }}"><i class="fa fa-trash-o" style="color:red;"> </i></a>
									</td>
									</tr>
									@endforeach
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        <!-- /tile body -->

                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
   <script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	
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

    var OverviewChapterQuestions= $('#OverviewChapterQuestions').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        autoWidth: false,
       
    }); 
	var OverviewChapterQuestionAnswers= $('#OverviewChapterQuestionAnswers').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        autoWidth: false,
       
    });

    dataTable();
    function dataTable() {
        OverviewChapterQuestions= $('#OverviewChapterQuestions').DataTable({
            dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
            processing: true,
            serverSide: false,
            responsive: true,
            autoWidth: false,
            "bDestroy": true,
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

    // $(document).ready(function() {
    //     $('.chosen-select').chosen({
    //         placeholder_text_single: "Select Project/Initiative...",
    //         no_results_text: "Oops, nothing found!"
    //     });
    // });

	  $(".previewquestions").on("click", function(){
	 var id = $(this).data("pattern_id");
	 var chapter_id = $(this).data("chapter_id");
	   $.ajax({
                    type: "get",				
                    url: '{{ route('ChapterBasedQuestionpreview') }}',
                    data:{id:id , chapter_id:chapter_id},
					// dataType:'JSON',
                    success: function(data) {
						Popup(data);
					}
                });
	  });
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

