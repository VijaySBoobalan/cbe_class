@extends('layouts.master')

@section('question_paper_views')
active
@endsection

@section('question_paper_management')
active open
@endsection

@section('content')
<style>
.regno {
    position: absolute;
    top: -10px;
    right: 0px;
}
.regno-container {
    position: relative;
}
.list-inline {
    padding-left: 0;
    margin-left: -5px;
    list-style: none;
}
.list-inline>li {
    display: inline-block;
    padding-right: 5px;
    padding-left: 5px;
}
.regno li {
    border: 1px solid #333;
    margin-right: -4px;
    height: 30px;
    width: 30px;
}
</style>
    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Exam Details</h1>
							 
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
						 <div class="table-responsive">
						 <div class="row">
						 <div class="col-md-4">
						 </div>
                            <div class="col-md-4">
							<input type="text"class="form-control"value="New syllabus 2019">
                            </div>
						<div class="col-md-4">
						</div>
						 </div>
						
						 <form action="{{ route('StoreExamQuestionInstructions') }}" id="StoreQuestions" method="get" class="form-validate-jquery" data-parsley-validate name="form2" role="form">
						 <div class="row">
						<input type="hidden"name="id"value="{{ $id }}">
						<h4 class="text-center">{{ $PaperDetails->exam_name }}</h4>
						 </div>
						 <div class="row">
						<div class="col-md-4">
						<label>Exam Time</label>
						<input type="number"name="exam_time"class="form-control">
						 </div>
						 <div class="col-md-4">
						<label>Subject</label>
						<input type="text"name="subject"class="form-control">
						 </div>
						 <div class="col-md-4">
					<div class="regno-container">
						<div class="regno text-right">
							<ul class="list-unstyled list-inline">
								Reg.No. :
								<li>&nbsp;</li>
								<li>&nbsp;</li>
								<li>&nbsp;</li>
								<li>&nbsp;</li>
								<li>&nbsp;</li>
								<li>&nbsp;</li>
							</ul>
						</div>
					</div>
					</div>
						  <div class="col-md-4">
						<label>Marks:</label>
						<input type="number"name="marks"class="form-control">
						 </div>
					
						 </div>
						 <div class="row">
						 <label>Main Note</label>
						 <textarea class="ckeditor" name="main_note"></textarea>
						 </div>
						 @foreach($ExamQuestions as $key=>$segregations)
						
						 <p><label>Secondary Note ( {{ $segregations['segregation'] }} )</label></p>
						 <input type="hidden"name="segregation_ids[{{ $segregations['id']}}]"value="{{ $segregations['id'] }}">
						 <textarea class="ckeditor" name="secondary_note[{{ $segregations['id'] }}]"></textarea>
							@foreach($segregations['questions'] as $qkey=>$questions)
							{{++$qkey}} <span>). </span><?php  echo strip_tags($questions['question_name']) ;?></p>
							<?php 
								if(!empty($questions['answer_option'])) {
								foreach(unserialize($questions['answer_option']) as $key2 => $Que){ ?>
								<span style="margin-left:50px">  {{++$key2}} ).</span>         <?php echo strip_tags($Que) ;
									} 
								}
									?> 
			 					
							@endforeach
						 @endforeach
						 <hr>
						 <label>Footer Note</label>
						 <textarea class="ckeditor" rows="2" name="footer_note"></textarea>
						 
						 <input type="submit"name="save"value="Save Exam"class="btn btn-primary">
						 </form>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
   <script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	 $('.summernote').summernote({
                // height: 100   //set editable area's height
                // width: 100   //set editable area's height
            });
		 var base_url="{{ URL::to('/assets/js/')}}/";
	    CKEDITOR.replace( '.ckeditor', {
    filebrowserBrowseUrl: base_url+'ckeditor/kcfinder/browse.php?type=images',
	filebrowserImageBrowseUrl: base_url+'ckeditor/kcfinder/browse.php?type=Images',
	filebrowserImageUploadUrl : base_url+'ckeditor/kcfinder/upload.php?opener=ckeditor&type=images',
	// baseHref =base_url,
	 // config.baseHref =base_url,
	 // $( 'textarea' ).ckeditor({baseHref : base_url}),
    filebrowserUploadUrl: base_url+'ckeditor/kcfinder/upload.php?type=images',
	extraPlugins : 'uicolor',
	height: '100px',
});

</script>


@endsection

