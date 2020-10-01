@extends('layouts.master')

@section('exam_management')
active
@endsection

@section('content')

    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Exam Packs</h1>
                          
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="row">
                                <div class="col-sm-12">
                                   
                                </div>
                            </div>
                            <div id="ClassHomework" class="tabcontent">
                                <div class="table-responsive">
                                    <table class="table table-custom" id="ExamPacks">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Pack</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $packs=getExamPacks(); ?>
                                        @foreach ($packs as $key=>$value )
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $value }}</td>
												
                                                <td><a href="{{ route('Exams',$key) }}"class="btn btn-success"><i class="fa fa-eye"></i></a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                           



                        </div>

                        <!-- /tile body -->

                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection




