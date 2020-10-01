<div class="modal fade AddPreparationTypeModal" id="AddPreparationTypeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">

                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Add Preparation Type</h1>
                        </div>

                        <div class="tile-body">

                            <form action="#" id="AddPreparationTypeForm" method="post" class="form-validate-jquery AddPreparationTypeForm" data-parsley-validate name="form2" role="form">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Preparation Type') !!}
                                                {!! Form::text('preparation_type', null, ['class' => 'form-control preparation_type','placeholder'=>'Preparation Type','id'=>'preparation_type','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                    <button type="submit" class="btn btn-lightred AddPreparationType" id="AddPreparationType">Save</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
