@extends('layouts.master')

@section('add_assign_fee')
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
                        {!! Form::open(['url' => action('FeesManagement\StudentAssignFeesController@index'),'method' => 'get','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                        @csrf
                            <fieldset>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Fee Types') !!}
                                            {!! Form::select('fee_type',$FeesMaster->pluck('fee_type','id'),$fee_type, ['onchange'=>'FeeGroupDetails(this.value);','class' => 'form-control chosen-select','placeholder'=>'Fee Types','id'=>'fee_type']) !!}
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        {!! Form::close() !!}
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
                            <table class="table datatable-basic" id="mileage_Detail_table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Fee Type</th>
                                        <th>Fee Name</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <?php $count = 0;?>
                                @if (isset($FeesGroups))
                                    <tbody>
                                        @foreach ($FeesGroups as $key=>$FeesGroup)
                                        <?php $total = 0;?>
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $FeesGroup->getFeesMasterName->fee_type }}</td>
                                                <td>
                                                    @foreach ($FeesGroup->getFeesGroupDetails as $item)
                                                        {{ $item->getFeesTypeDetails->fee_name }} - {{ $item->getFeesTypeDetails->fee_code }} - {{ $item->getFeesTypeDetails->amount }} <br>
                                                        <?php $total = $total + $item->getFeesTypeDetails->amount; ?>
                                                    @endforeach
                                                    <?php echo "Total : $total" ; ?>
                                                </td>
                                                <td class="text-center">
                                                    {!! Form::model($FeesMaster,['url' => action('FeesManagement\StudentAssignFeesController@destroy',$FeesGroup->id),'method' => 'delete','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                                    <a href="{{ action('FeesManagement\StudentAssignFeesController@show',$FeesGroup->id) }}" class="btn btn-xs btn-primary text-center"><i class="glyphicon glyphicon-send"></i>&nbsp;&nbsp;Assign</a>
                                                        {{-- <a href="{{ action('FeesManagement\StudentAssignFeesController@edit',$FeesGroup->id) }}" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a> --}}
                                                        {{-- <button type="submit" onclick="return confirm('Are you sure you want to delete this Fees type?');" class='list-icons-item text-danger-600 btn btn-sm'><i class='icon-trash'></i></button> --}}
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>

@endsection
