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

<link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
@section('content')
<script src="{{ asset('js/plugins/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/tables/datatables/extensions/buttons.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="{{ asset('js/plugins/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('js/plugins/pickers/pickadate/picker.date.js') }}"></script>
<script src="{{ asset('js/plugins/pickers/pickadate/picker.time.js') }}"></script>
<script src="{{ asset('js/plugins/pickers/pickadate/legacy.js') }}"></script>

    <div class="card">
        <div class="card-body">
            {!! Form::open(['url' => action('FeesManagement\StudentScholarShipController@create'),'method' => 'get','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                @csrf
                <fieldset>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::label('name', 'Department') !!}
                                {!! Form::select('department_id[]',$departments->pluck('department_name','id'),$department_id, ['class' => 'form-control select-search','data-placeholder'=>'select Department','id'=>'department_id','multiple'=>'multiple']) !!}
                            </div>
                        </div>
                        
                        {{-- <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::label('name', 'Year') !!}
                                {!! Form::select('year[]',['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5'],null, ['class' => 'form-control select-search','data-placeholder'=>'select Year','id'=>'year','multiple'=>'multiple']) !!}
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::label('name', 'Semester') !!}
                                {!! Form::select('semester',['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','5'=>'5'],null, ['class' => 'form-control select-search','placeholder'=>'select Semester','id'=>'semester']) !!}
                            </div>
                        </div> --}}

                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::label('name', 'Fee Type') !!}
                                {!! Form::select('fee_type',['acadamic'=>'Acadamic','sports'=>'Sports'],$fee_type, ['class' => 'form-control select-search','placeholder'=>'Fee Type','id'=>'fee_type']) !!}
                            </div>
                        </div>                        
                    </div>
                    
                </fieldset>
                <div class="d-flex justify-content-end align-items-center">
                    <button type="submit" class="btn btn-primary ml-3">Filter <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header header-elements-inline">
            <legend class="font-weight-semibold text-uppercase font-size-sm">
                <i class="icon-reading mr-2"></i>
                View Items List
            </legend>
        </div>

        <table class="table datatable-basic" id="mileage_Detail_table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Student Name</th>
                    <th>Department</th>
                    <th>Scholarship</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <?php $count = 0; ?>
            @if (isset($Students))
                <tbody>
                    @foreach ($Students as $key=>$Student)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $Student->student_name }}</td>
                            <td>{{ $Student->department_details->department_name }}</td>
                            <td>{{ $Student->interested_activity }}</td>
                            <td>
                                <a href="{{ action('FeesManagement\StudentScholarShipController@show',$Student->id) }}" data-popup="tooltip" title="Assign ScholarShip" data-trigger="hover"><i class='icon-stack'></i></a>&nbsp;&nbsp;&nbsp;
                                <a href="{{ action('FeesManagement\StudentScholarShipController@ScholarShipDetails',$Student->id) }}" data-popup="tooltip" title="View ScholarShip" data-trigger="hover"><i class='icon-eye'></i></a>&nbsp;&nbsp;&nbsp;
                                {{-- <a href="{{ action('FeesManagement\StudentAssignFeesController@AssignFees',$Student->id) }}" data-popup="tooltip" title="Assign Fee" data-trigger="hover"><i class='icon-plus2'></i></a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @endif
        </table>
    </div>
    @include('fees_management.student_scholarship.js')
@endsection