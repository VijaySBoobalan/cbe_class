@extends('layouts.master')

@section('view_assign_fee')
active
@endsection

@section('fees_master_open_menu')
open
@endsection

@section('fees_master_open_menu_display')
block
@endsection

@section('assign_fee_open_menu')
open
@endsection

@section('assign_fee_open_menu_display')
block
@endsection

@section('content')

<section id="content">
    <div class="page page-forms-validate">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <section class="tile">
                    <div class="tile-header dvd dvd-btm">
                        <h1 class="custom-font"><strong>Filter</h1>
                    </div>
                    <div class="tile-body">
                        <div class="card-body">
                            {!! Form::open(['url' => action('FeesManagement\StudentAssignFeesController@index'),'method' => 'get','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                @csrf
                                <fieldset>
                                    <div class="row">
                                        <input type="hidden" name="filter_section_id" id="filter_section_id" value="{{ $section_id }}">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Class') !!}
                                                {!! Form::select('class_id',$ClassSection->pluck('class','class'),$class_id, ['onchange'=>'getSection()','class' => 'form-control chosen-select class_id','placeholder'=>'Class','id'=>'class_id','required'=>'required']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Section') !!}
                                                {!! Form::select('section_id',[],$section_id, ['class' => 'form-control chosen-select section_id','placeholder'=>'Section','id'=>'section_id','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="d-flex justify-content-end align-items-center">
                                    <button type="submit" id="add_btn" class="btn btn-primary ml-3">Filter <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div class="page page-forms-validate">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <section class="tile">
                    <div class="tile-header dvd dvd-btm">
                        <h1 class="custom-font"><strong>Assign Fee List</h1>
                    </div>
                    <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table datatable-basic" id="mess_menu_table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Fee Type</th>
                                        <th>Fee Name</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        @if(auth()->user()->hasAnyPermission(['fee_assign_student_list','fee_assign_update']))
                                            <th class="text-center">Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($StudentAssignFees))
                                    @foreach ($StudentAssignFees as $key=>$StudentAssignFee)
                                    <?php $total = 0; ?>
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $StudentAssignFee->getFeeFeesGroup->getFeesMasterName->fee_type }}</td>
                                                <td>
                                                    @foreach ($StudentAssignFee->getFeeFeesGroup->getFeesGroupDetails as $item)
                                                        {{ $item->getFeesTypeAmountDetails->fee_name }} - {{ $item->getFeesTypeAmountDetails->fee_code }} - {{ $item->getFeesTypeAmountDetails->amount }} <br>
                                                        <?php $total = $total + $item->getFeesTypeAmountDetails->amount; ?>
                                                    @endforeach
                                                    <?php echo "Total : $total" ; ?>
                                                </td>
                                                <td>{{ $StudentAssignFee->class_id }}</td>
                                                <td>{{ $StudentAssignFee->ClassSection->section }}</td>
                                                <td class="text-center">
                                                    {!! Form::model($StudentAssignFee,['url' => action('FeesManagement\StudentAssignFeesController@destroy',$StudentAssignFee->id),'method' => 'delete','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                                        @can('fee_assign_student_list')
                                                            <a href="{{ action('FeesManagement\StudentAssignFeesController@showStudentList',$StudentAssignFee->id) }}" class="btn btn-xs btn-success text-center"><i class="glyphicon glyphicon-tasks"></i>&nbsp;&nbsp;Student List</i></a>&nbsp;&nbsp;&nbsp;
                                                        @endcan
                                                        @can('fee_assign_update')
                                                            <a href="{{ action('FeesManagement\StudentAssignFeesController@edit',$StudentAssignFee->id) }}" class="btn btn-xs btn-primary text-center"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Edit</a>
                                                        @endcan
                                                        @can('fee_assign_delete')
                                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this Assigned Fee?');" class="btn btn-xs btn-danger text-center"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Delete </button>
                                                        @endcan
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
    <script>

        var SelectSection = "";
        getSection();
        if($('#filter_section_id').val()!=""){
            SelectSection = $('#filter_section_id').val();
        }
        // $(document).ready(function() {
            function getSection() {
                var student_class = $('.class_id').val();
                var selectHTML = "";
                if (student_class != '') {
                    $.ajax({
                        type: "get",
                        url: '{{ route("getSection") }}',
                        data: { student_class: student_class },
                        success: function(data) {
                            for (var key in data) {
                                var row = data[key];
                                selectHTML += "<option value='" + row.id + "'>" + row.section + "</option>";
                            }
                            $('.section_id').html(selectHTML);
                            $('.section_id').val(SelectSection).trigger("chosen:updated");
                        }
                    });
                }
            }
        // });
    </script>
@endsection
