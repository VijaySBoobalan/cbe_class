@include('master.subject.js')

<div class="modal fade" id="editSubjectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">

                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Edit Subject</h1>
                        </div>

                        <div class="tile-body">
                            <form action="#" id="UpdateSubjectForm" method="post" class="form-validate-jquery" data-parsley-validate name="form2" role="form">

                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <input name="subject_id" id="subject_id" type="hidden" class="subject_id">
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Class') !!}
                                                {!! Form::select('class',$ClassSection->pluck('class','class') ,null, ['onchange'=>'getSection(this.value)','class' => 'form-control class chosen-select','placeholder'=>'Class','id'=>'class','required'=>'required']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Section') !!}
                                                {!! Form::select('section_id',[],null, ['class' => 'form-control chosen-select section_id','placeholder'=>'Section','id'=>'section_id','required'=>'required']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Subject Name') !!}
                                                {!! Form::text('subject_name', null, ['class' => 'form-control subject_name','placeholder'=>'Subject Name','id'=>'subject_name','required'=>'required']) !!}
                                            </div>
                                        </div>

                                    </div>
                                </fieldset>

                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                    <button type="submit" class="btn btn-lightred UpdateSubject" id="UpdateSubject">Update</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="DeleteModel" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Are You Sure ! You Want to Delete</h4>
            </div>
            <div class="modal-body">
                <form action="#">
                    <button type="submit" class="btn btn-danger DeleteConfirmed" data-dismiss="modal">Delete </button>
                    <button type="button" style="float: right;" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
