<div class="modal fade AddSegregationModal" id="AddSegregationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">

                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Add Segregation</h1>

                        </div>

                        <div class="tile-body">

                            <form action="#" id="AddSegregationForm" method="post" class="form-validate-jquery AddSegregationForm" data-parsley-validate name="form2" role="form">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Question Type') !!}
                                                {!! Form::select('question_type_id',$QuestionTypes->pluck('question_name','id') ,null, ['class' => 'form-control chosen-select question_type_id','placeholder'=>'Question Type','id'=>'question_type_id','required'=>'required']) !!}
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
                                    <button type="submit" class="btn btn-lightred AddSegregation" id="AddSegregation">Save</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
