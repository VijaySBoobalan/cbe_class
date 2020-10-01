<div class="modal fade" id="editSegregationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">

                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Edit Question Types</h1>
                        </div>

                        <div class="tile-body">
                            <form action="#" id="UpdateSegregationForm" method="post" class="form-validate-jquery" data-parsley-validate name="form2" role="form">

                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <input name="segregation_id" id="segregation_id" type="hidden" class="segregation_id">
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Question Type') !!}
                                                {!! Form::select('question_type_id',$QuestionTypes->pluck('question_type','id') ,null, ['class' => 'form-control chosen-select question_type_id','placeholder'=>'Question Type','id'=>'question_type_id','required'=>'required']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Segregation') !!}
                                                {!! Form::text('segregation', null, ['class' => 'form-control segregation','placeholder'=>'Segregation','id'=>'segregation','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                    <button type="submit" class="btn btn-lightred UpdateSegregation" id="UpdateSegregation">Update</button>
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
                    <button type="button" class="btn btn-danger DeleteConfirmed" data-dismiss="modal">Delete </button>
                    <button type="button" style="float: right;" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
