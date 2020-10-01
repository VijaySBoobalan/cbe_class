@extends('layouts.master')

@section('homework')
active
@endsection

@section('content')
<script src="{{ url('assets/plugins/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ url('assets/plugins/tables/datatables/extensions/buttons.min.js') }}"></script>
    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Homeworks</h1>
                        </div>

                        <div class="tile-body">
                            {{-- <div class="row">
                                <div class="col-md-6"><div id="tableTools"></div></div>
                                <div class="col-md-6"><div id="colVis"></div></div>
                            </div> --}}
                            <div class="table-responsive">
                                <table class="table table-custom table-responsive" id="advanced-usage">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Homework Subject</th>
                                        <th>Homework Type</th>
                                        <th>Staff</th>
                                        <th>Homework Date</th>
                                        <th>Submission Date</th>
                                        <th>Estimated Mark</th>
                                        <th>Status</th>
                                        <th>Viewed</th>
                                        <th>Attachment</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($ClassHomework as $key=>$Homewrok)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $Homewrok['subject_name'] }} </td>
                                            <td>{{ $Homewrok['homework_type'] }} </td>
                                            <td>{{ $Homewrok['staff_name'] }} </td>
                                            <td>{{ $Homewrok['homework_date'] }} </td>
                                            <td>{{ $Homewrok['submission_date'] }} </td>
                                            <td>@if($Homewrok['submitted']){{ $Homewrok['submitted'][0]['marks_obtained'] }}/ @endif {{ $Homewrok['estimated_mark'] }} </td>
                                            <?php if(empty($Homewrok['submitted'])){ ?>
                                            <td>Not Submitted </td>
                                            <?php }else{ ?>
                                            <td>{{ $Homewrok['submitted'][0]['status'] }}</td>
                                            <?php } ?>
                                            <?php if(empty($Homewrok['submitted'])){ ?>
                                                <td>Not Viewed</td>
                                                <?php }else{ ?>
                                                <td>Yes</td>
                                                <?php } ?>
                                            <td><a href="{{URL::to('/').$Homewrok['attachment'] }}"download>Download</a> </td>
                                            @if($Homewrok['submitted']==null)
                                        <td> <a href="#"id="{{ $Homewrok['homework_id'] }}"class="btn btn-success homework_id"data-toggle="modal" data-target="#UploadHomework">Submit</a></td>
                                        @else
                                            <td><a href="#"id="{{ $Homewrok['homework_id'] }}"class="btn btn-success homework_view_status"data-toggle="modal" data-target="#UploadHomeworkStatus">View</a></td>
                                        @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /tile body -->

                    </section>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('Modal')
    @include('student.homework.add')

@endsection
@section('script')
    @include('student.homework.js')

@endsection
