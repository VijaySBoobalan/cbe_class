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
                                <table class="table table-custom" id="QuestionTable">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Preparation Types</th>
                                        <th>Questions Types</th>
                                        <th>Questions Count</th>
                                        {{-- <th>Question Type</th> --}}
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                        @php
                                          $loop = 1;
                                        @endphp
                                    <tbody>
                                        @foreach ($Questions as $key=>$Question)
                                        {{-- <?php $questionCount = getQuestionCount($Chapter->id); ?> --}}
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $Question->PreparationTypes->preparation_type }}</td>
                                                <td>
                                                    {!! Form::open(['url' => route('QuestionDetails'),'method' => 'post','class'=>'form-validate-jquery QuestionFormDetails','data-parsley-validate','name'=>'form2','role'=>'form','id'=>'form2']) !!}
                                                        <input type="hidden" name="staff_subject_assign_id" id="staff_subject_assign_id" value="{{ $Question->Chapter->staff_subject_assign_id }}">
                                                        <input type="hidden" name="chapter_id" id="chapter_id" value="{{ $Question->chapter_id }}">
                                                        <input type="hidden" name="preparation_type_id" id="preparation_type_id" value="{{ $Question->preparation_type_id }}">
                                                        <input type="hidden" name="question_type_id" id="question_type_id" value="{{ $Question->question_type_id }}"">
                                                        <input type="hidden" name="segregation_id" id="segregation_id" value="{{ $Question->segregation_id }}">
                                                        <span class="QuestionDetails" onclick="formSuubmit({{ $Question->id }})"><a>{{ $Question->QuestionTypes->question_type }} - {{ $Question->Segregation->segregation }}</a></span>
                                                        <button style="display: none" class="formSubmit{{ $Question->id }}"></button>
                                                    {!! Form::close() !!}
                                                </td>
                                                <td>{{ getQuestionSegregationCount($Question->chapter_id,$Question->preparation_type_id,$Question->question_type_id,$Question->segregation_id) }}</td>
                                                <td>
                                                    {!! Form::open(['url' => route('EditQuestion'),'method' => 'post','class'=>'form-validate-jquery','data-parsley-validate','name'=>'form2','role'=>'form','id'=>'form2']) !!}
                                                        {{-- <a href="{{ route('ViewQuestion',$Question->question_type_id) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye"> View</i></a> --}}
                                                        <input type="hidden" name="staff_subject_assign_id" id="staff_subject_assign_id" value="{{ $Question->Chapter->staff_subject_assign_id }}">
                                                        <input type="hidden" name="chapter_id" id="chapter_id" value="{{ $Question->chapter_id }}">
                                                        <input type="hidden" name="preparation_type_id" id="preparation_type_id" value="{{ $Question->preparation_type_id }}">
                                                        <input type="hidden" name="question_type_id" id="question_type_id" value="{{ $Question->question_type_id }}"">
                                                        <input type="hidden" name="segregation_id" id="segregation_id" value="{{ $Question->segregation_id }}">
                                                        <button class="btn btn-sm btn-primary"><i class="fa fa-pencil"> Edit</i></button>
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                            <?php $loop++; ?>
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
    {{-- @include('manage_question.question.js') --}}

    <script>
        function formSuubmit(val) {
            console.log(val);
            $('.formSubmit'+val).trigger('click');
        }
    </script>
@endsection

