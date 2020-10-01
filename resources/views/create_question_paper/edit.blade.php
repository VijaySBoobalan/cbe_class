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
label.secondary_notes {
    font-size: 18px;
    font-weight: bolder;
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
						
						 <form action="{{ route('UpdateExamQuestionInstructions') }}" id="StoreQuestions" method="get" class="form-validate-jquery" data-parsley-validate name="form2" role="form">
						 <div class="row">
						<input type="hidden"name="id"value="{{ $id }}">
						<div class="col-md-4">
						</div>
						<div class="col-md-4">
						<label>Exam Question paper</label>
						<input type="text"name="exam_name"value="{{ $PaperDetails->exam_name }}"class="form-control">
						 </div>
						 <div class="col-md-4">
						</div>
						 </div>
						 <div class="row">
						<div class="col-md-4">
						<label>Exam Time</label>
						<input type="number"name="exam_time"value="{{ $PaperDetails->exam_time }}"class="form-control">
						 </div>
						 <div class="col-md-4">
						<label>Subject</label>
						<input type="text"name="subject"value="{{ $PaperDetails->subject }}"class="form-control">
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
						<input type="number"name="marks"value="{{ $PaperDetails->marks }}"class="form-control">
						 </div>
					
						 </div>
						 <div class="row">
						 <label class="secondary_notes">Main Note</label>
						
						  <textarea id="main_note" name="main_note"class="ckeditor">{{ $PaperDetails->main_note }}</textarea> 
						 </div>
						
						 @foreach($ExamQuestions as $key=>$segregations)
						
						 <p><label class="secondary_notes">Secondary Note ( {{ $segregations['segregation'] }} )</label></p>
						 <input type="hidden"name="segregation_ids[{{ $segregations['id']}}]"value="{{ $segregations['id'] }}">
						 <textarea class="ckeditor" name="secondary_note[{{ $segregations['id'] }}]">{{ $segregations['segregation_notes']}}</textarea>
							
						 @endforeach
						 <hr>
						 <label class="secondary_notes">Footer Note</label>
						 <textarea class="ckeditor" name="footer_note">{{ $PaperDetails->footer_note }}</textarea>
						 
						 <input type="submit"name="save"value="Update"class="btn btn-primary">
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
                height: 100   //set editable area's height
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

