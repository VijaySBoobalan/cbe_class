<div class="modal fade AddClassSectionModal" id="AddClassSectionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">

                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Add Class/Section</h1>

                        </div>

                        <div class="tile-body">

                            <form action="#" id="AddClassSubjectForm" method="post" class="form-validate-jquery AddClassSubjectForm" data-parsley-validate name="form2" role="form">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Class') !!}
                                                {!! Form::text('class', null, ['class' => 'form-control','placeholder'=>'Class','id'=>'class','required'=>'required']) !!}
                                                <span class="Error" style="color: red;"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Section') !!}
                                                {!! Form::text('section', null, ['class' => 'form-control','placeholder'=>'Section','id'=>'section','required'=>'required']) !!}
                                            </div>
                                        </div>

                                    </div>
                                </fieldset>

                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                    <button type="submit" class="btn btn-lightred AddClassSubject" id="AddClassSubject">Save</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
