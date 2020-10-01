@extends('layouts.app')

@section('add_student_scholarship')
active
@endsection

@section('fees_master_open_menu')
nav-item-expanded nav-item-open
@endsection


@section('student_scholarship_open_menu')
nav-item-open
@endsection

@section('student_scholarship_display')
block
@endsection

@section('content')
<script src="{{ asset('js/plugins/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/tables/datatables/extensions/buttons.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<div class="card">
	<div class="card-header header-elements-inline">
		<!-- <h5 class="card-title">Higher Secondary Groups</h5> -->
		<legend class="font-weight-semibold text-uppercase font-size-sm">
			<i class="icon-reading mr-2"></i>
			Schloarship Acadamic Details
		</legend>
	</div>

	<div class="card-body">
        @if(isset($ScholarshipAcadamic))
            {!! Form::model($ScholarshipAcadamic,['url' => action('FeesManagement\StudentScholarShipController@update',$ScholarshipAcadamic->id),'method' => 'put','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
        @else
            {!! Form::open(['url' => action('FeesManagement\StudentScholarShipController@store'),'method' => 'post','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
        @endif
        <?php $acadamic = isset($ScholarshipAcadamic) ? $ScholarshipAcadamic->fee_type == "acadamic" ? "inline" : "none" : "none" ?>
        <?php $sports = isset($ScholarshipAcadamic) ? $ScholarshipAcadamic->fee_type == "sports" ? "inline" : "none" : "none" ?>
            @csrf
            <fieldset>
				<div class="row">

                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('name', 'Student Name') !!}
                            {!! Form::text(null,$Students->student_name, ['class' => 'form-control','placeholder'=>'Student Name','id'=>'fee_type','readonly'=>'readonly']) !!}
                            {!! Form::hidden('student_id',$Students->id, ['class' => 'form-control','placeholder'=>'Student Name','id'=>'fee_type','readonly'=>'readonly']) !!}
                            {!! Form::hidden('scholarship_type',$Students->interested_activity, ['class' => 'form-control','placeholder'=>'Student Name','id'=>'fee_type','readonly'=>'readonly']) !!}
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('name', 'Department Name') !!}
                            {!! Form::text(null,$Students->department_details->department_name, ['class' => 'form-control','placeholder'=>'Department Name','id'=>'fee_type','readonly'=>'readonly']) !!}
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('name', 'Year') !!}
                            {!! Form::select('year',['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5'],null, ['onchange'=>'getYearwiseDetails(this.value);','class' => 'form-control select-search','placeholder'=>'select Year','id'=>'year']) !!}
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('name', 'Semester') !!}
                            {!! Form::select('semester',['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','5'=>'5'],null, ['class' => 'form-control select-search','placeholder'=>'select Semester','id'=>'semester']) !!}
                        </div>
                    </div>
                </div>

                @if ($Students->interested_activity == 'activities')
                <?php 
                    $percentage = 0; $count = 0;
                    $explode_id = array_map('intval', explode(',', $HigherSecondaryGroupAndSubject->subject_ids));
                ?>
                @if (isset($Students->student_marks))
                    @if (in_array($Students->student_marks->hsc_subject1,$explode_id))
                        <?php 
                            $percentage += $Students->student_marks->hsc_mark1; 
                        ?>
                    @endif
                    @if (in_array($Students->student_marks->hsc_subject2,$explode_id))
                        <?php 
                            $percentage += $Students->student_marks->hsc_mark2;    
                        ?>
                    @endif
                    @if (in_array($Students->student_marks->hsc_subject3,$explode_id))
                        <?php 
                            $percentage += $Students->student_marks->hsc_mark3;  
                        ?>
                    @endif
                    @if (in_array($Students->student_marks->hsc_subject4,$explode_id))
                        <?php 
                            $percentage += $Students->student_marks->hsc_mark4;  
                        ?>
                    @endif
                    @if (in_array($Students->student_marks->hsc_subject5,$explode_id))
                        <?php 
                            $percentage += $Students->student_marks->hsc_mark5;  
                        ?>
                    @endif
                    @if (in_array($Students->student_marks->hsc_subject6,$explode_id))
                        <?php 
                            $percentage += $Students->student_marks->hsc_mark6;  
                        ?>
                    @endif
                @endif
                <?php 
                    $Count =  count($explode_id);
                ?>
                
                    <div class="AcadamicDiv">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('name', 'ScholarShip Name') !!}
                                    {!! Form::select('scholarship_acadamics_id',$ScholarshipAcadamics->pluck('acadamic_scholarship_name','id'), null, ['onchange'=>'GetScholarshipAcadamicDetails(this.value)','class' => 'form-control select-search','placeholder'=>'ScholarShip Name','id'=>'acadamic_scholarship_name']) !!}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('name', 'Percentage From') !!}
                                    {!! Form::text('percentage_from', null, ['class' => 'form-control','placeholder'=>'Percentage From','id'=>'percentage_from','readonly'=>'readonly']) !!}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('name', 'Percentage To') !!}
                                    {!! Form::text('percentage_to', null, ['class' => 'form-control','placeholder'=>'Percentage To','id'=>'percentage_to','readonly'=>'readonly']) !!}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('name', 'Fees Cocertion') !!}
                                    {!! Form::text('acadamic_fees_concertion', null, ['class' => 'form-control','placeholder'=>'Fees Cocertion','id'=>'acadamic_fees_concertion','readonly'=>'readonly']) !!}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('name', '% Should Maintain') !!}
                                    {!! Form::text('maintain_percentage', null, ['class' => 'form-control','placeholder'=>'% Should Maintain','id'=>'maintain_percentage','readonly'=>'readonly']) !!}
                                </div>
                            </div>

                            <div class="col-lg-6 12_th_percentageDiv">
                                <div class="form-group">
                                    {!! Form::label('name', '12 th percentage') !!}
                                    {!! Form::text('percentage', $percentage/$Count, ['class' => 'form-control','placeholder'=>'12 th percentage','id'=>'12_th_percentage','readonly'=>'readonly']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($Students->interested_activity == 'sports')
                    <div class="ZonalDiv">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('name', 'ScholarShip Name') !!}
                                    {!! Form::select('scholarship_acadamics_id',$ScholarshipSports->pluck('zonal_particulars','id'), null, ['onchange'=>'GetScholarshipSportsDetails(this.value)','class' => 'form-control select-search','placeholder'=>'ScholarShip Name','id'=>'zonal_scholarship_name']) !!}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('name', 'Fees Cocertion') !!}
                                    {!! Form::text('zonal_fees_concertion', null, ['class' => 'form-control','placeholder'=>'Fees Cocertion','id'=>'zonal_fees_concertion','readonly'=>'readonly']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
			</fieldset>
			<div class="d-flex justify-content-end align-items-center">
				<button type="button" onClick="clearForm()" class="btn btn-light" id="reset">Reset <i class="icon-reload-alt ml-2"></i></button>
				<button type="submit" id="add_btn" class="btn btn-primary ml-3">Save <i class="icon-paperplane ml-2"></i></button>
			</div>
        {!! Form::close() !!}
	</div>
</div>

@include('fees_management.student_scholarship.js')

@endsection
