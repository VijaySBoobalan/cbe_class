<div class="modal fade AddQuestionModelModal" id="AddQuestionModelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">

                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Add Question Model</h1>

                        </div>

                        <div class="tile-body">

                            <form action="#" id="AddQuestionModelForm" method="post" class="form-validate-jquery AddQuestionModelForm" data-parsley-validate name="form2" role="form">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Question Model') !!}
                                                {!! Form::text('question_model', null, ['class' => 'form-control question_model','placeholder'=>'Question Model','id'=>'question_model','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                    <button type="submit" class="btn btn-lightred AddQuestionModel" id="AddQuestionModel">Save</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
