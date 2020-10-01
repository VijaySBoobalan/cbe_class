@extends('layouts.master')

@section('question_view')
active
@endsection

@section('question_menu')
active open
@endsection

@section('content')

    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Question Details</h1>
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="table-responsive">
                                <input type="hidden" name="" id="questionId" value="{{ $id }}">
                                <table class="table table-custom" id="QuestionTable">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Chapter</th>
                                        <th>No of Questions</th>
                                        {{-- <th>Question Model</th>
                                        <th>Question Type</th> --}}
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $loop = 0; ?>
                                        @foreach ($Chapters as $key=>$Chapter)
                                        <?php $questionCount = getQuestionCount($Chapter->id); ?>
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $Chapter->unit_name }}</td>
                                                <td>{{ $questionCount }}</td>
                                                {{-- <td>{{ $Chapter->QuestionModel->question_model }}</td>
                                                <td>{{ $Chapter->QuestionTypes->question_type }}</td> --}}
                                                <td>
                                                    <a href="{{ route('ViewQuestion',$Chapter->id) }}"><button class="btn btn-sm btn-primary"><i class="fa fa-eye"> Views</i></button></a>
                                                    {{-- {!! Form::open(['url' => route('EditQuestion'),'method' => 'post','class'=>'form-validate-jquery','data-parsley-validate','name'=>'form2','role'=>'form','id'=>'form2']) !!}
                                                        <input type="hidden" name="staff_subject_assign_id" id="staff_subject_assign_id" value="{{ $Chapter->staff_subject_assign_id }}">
                                                        <input type="hidden" name="chapter_id" id="chapter_id" value="{{ $Chapter->chapter_id }}">
                                                        <input type="hidden" name="question_model" id="question_model" value="{{ $Chapter->question_model }}">
                                                        <input type="hidden" name="question_type_id" id="question_type_id" value="{{ $Chapter->question_type_id }}"">
                                                        <input type="hidden" name="segregation_id" id="segregation_id" value="{{ $Chapter->segregation_id }}">
                                                        <button class="btn btn-sm btn-primary"><i class="fa fa-pencil"> Edit</i></button>
                                                    {!! Form::close() !!} --}}
                                                </td>
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

@section('script')
    @include('manage_question.question.js')
@endsection

