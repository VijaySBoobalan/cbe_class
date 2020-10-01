<hr>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Fee Details</h5>
    </div>

    <div class="card-body">
        <div class="card card-table table-responsive shadow-0 mb-0">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Fee Names</th>
                            <th>Checked</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($FeesTypes as $key=>$FeesType)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>
                                    {{ $FeesType->fee_name }}
                                </td>
                                <td colspan="2">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input feeGroup" id="custom_checkbox_stacked_unchecked{{ $key }}" value="{{ $FeesType->id }}" data-on-value="{{ $FeesType->amount }}" onclick="gettotalAmount(this);" name="fee_group[fee_name_id][]">
                                            <label class="custom-control-label" for="custom_checkbox_stacked_unchecked{{ $key }}"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <th class="text-right" colspan="2">Total :</th>
                            <th><span class="TotalValue"></span></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        @if (in_array('yes',$FeesTypes->pluck('scholarship')->toArray()))
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        {!! Form::label('name', 'ScholarShip?') !!}
                        <div>
                            <label class="radio-inline">
                                <input type="radio" name="scholarship_for" value="acadamics" {{ isset($FeesGroup) ? $FeesGroup->scholarship_for == "acadamics" ? "checked" : "" : "" }} required>Acadamics
                            </label>
                        </div>
                        <div>
                            <label class="radio-inline">
                                <input type="radio" name="scholarship_for" value="sports" {{ isset($FeesGroup) ? $FeesGroup->scholarship_for == "sports" ? "checked" : "" : "" }} required>Sports
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('name', 'Due Date') !!}
                    {!! Form::date('due_date', null, ['class' => 'form-control pickadate    ','placeholder'=>'Due Date','id'=>'due_date','required'=>'required']) !!}
                </div>
            </div>

            {{-- <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('name', 'Fine per day') !!}
                    {!! Form::text('fine_per_day',null, ['class' => 'form-control fine_per_day','placeholder'=>'Fine per day','id'=>'fine_per_day']) !!}
                </div>
            </div> --}}
        </div>
        <hr>
        <div class="d-flex justify-content-end align-items-center">
            <button type="submit" class="btn btn-primary">Save<i class="icon-paperplane ml-2"></i></button>
        </div>
    </div>
</div>

<script>
    $("input[name='fee_group[fee_name_id][]']:checked").each(function ()
    {
        TotalValue = parseFloat(TotalValue) + parseFloat($(this).attr("data-on-value"));
    });
    $('.TotalValue').html(TotalValue);

    function gettotalAmount(elem){
        if(elem.checked == true){
            TotalValue = parseFloat(TotalValue) + parseFloat($(elem).attr("data-on-value"));
        }else{
            TotalValue = parseFloat(TotalValue) - parseFloat($(elem).attr("data-on-value"));
        }
        $('.TotalValue').html(TotalValue);
    }
</script>


