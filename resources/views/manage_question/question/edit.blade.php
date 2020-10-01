@extends('layouts.master')

@section('question_view')
active
@endsection

@section('question_menu')
active open
@endsection

@section('content')

    <section id="content">

        <div class="page page-forms-validate">

            <!-- row -->
            <div class="row">


                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Edit Question</h1>

                        </div>

                        <div class="tile-body">

                            {!! Form::open(['url' => route('QuestionUpdate'),'method' => 'post','class'=>'form-validate-jquery','data-parsley-validate','name'=>'form2','role'=>'form','id'=>'form2']) !!}
                                @csrf
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Chapter') !!}
                                                {!! Form::select('chapter_id', $Chapter->pluck('unit_name','id'),$chapter_id, ['class' => 'form-control chapter_id chosen-select','placeholder'=>'Select Chapter','id'=>'chapter_id','required'=>'required','disabled']) !!}
                                                <input type="hidden" name="chapter_id" id="chapter_id" value="{{ $chapter_id }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Preparation Type') !!}
                                                {!! Form::select('preparation_type_id', $PreparationTypes->pluck('preparation_type','id'),$preparation_type_id, ['class' => 'form-control preparation_type_id chosen-select','placeholder'=>'Preparation Type','id'=>'preparation_type_id','required'=>'required','disabled']) !!}
                                                <input type="hidden" name="preparation_type_id" id="preparation_type_id" value="{{ $preparation_type_id }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Question Type') !!}
                                                {!! Form::select('question_type_id', $QuestionTypes->pluck('question_type','id'),$question_type_id, ['onchange'=>'getSegregation(this.value);','class' => 'form-control question_type_id chosen-select','placeholder'=>'Question Type','id'=>'question_type_id','required'=>'required','disabled']) !!}
                                                <input type="hidden" name="question_type_id" id="question_type_id" value="{{ $question_type_id }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Segregation') !!}
                                                {!! Form::select('segregation_id', [] ,null, ['onchange'=>'getQuestionModels(this.value)','class' => 'form-control segregation_id chosen-select','placeholder'=>'Segregation','id'=>'segregation_id']) !!}
                                                <input type="hidden" name="segregation_id" id="segregation_id" value="{{ $segregation_id }}">
                                                <input type="hidden" name="staffSubjectAssignedId" id="staffSubjectAssignedId" value="{{ $staffSubjectAssignedId }}">
                                            </div>
                                        </div>
                                    </div>
                                    <?php $questionLoop = 0; $Questioncount = 0; $optioncount = 0 ; $optionLoop = 0; ?>
                                    @if ($segregation_id == 1)
                                    <?php $questionLoop = 0; ?>
                                        @foreach ($Questions as $Questionkey=>$Question)
                                            <?php $Questioncount = ++$questionLoop; ?>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <input type="hidden" name="question[question_id][]" value="{{ $Question->id }}">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                {{-- <label>Question {{ $questionLoop }}</label> --}}
                                                                <label>Question</label>
                                                                <textarea class="summernote" name="question[question_name][]" id="summernote">{{ $Question->question_name }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                {!! Form::label('name', 'Question Answer') !!}
                                                                <label class="checkbox checkbox-custom-alt">
                                                                    <input type="radio" name="question[{{ $Questionkey }}][answer][]" value="true" {{ in_array('true',unserialize($Question->answer)) ? "checked" : "" }}><i></i>True
                                                                </label>
                                                                <label class="checkbox checkbox-custom-alt">
                                                                    <input type="radio" name="question[{{ $Questionkey }}][answer][]" value="false" {{ in_array('false',unserialize($Question->answer)) ? "checked" : "" }}><i></i>False
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        @foreach ($Question->QuestionYears as $yearKey=>$QuestionYear)
                                                            <input type="hidden" name="question[{{ $Questionkey }}][year_id][]" value="{{ $QuestionYear->id }}">
                                                            <div class="form-group">
                                                                <div class="col-sm-3">
                                                                    <label>Year</label>
                                                                    <select name="question[{{ $Questionkey }}][year][]" id="country" class="form-control chosen-select">
                                                                        @foreach($Years as $id=> $country)
                                                                            <option value="{{ $id }}" {{ $id == $QuestionYear->year ? "selected" : "" }}>{{ $country->year }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <button type="button" class="btn btn-primary btn-sm AddYear" style="margin-top:25px;" onclick="AddYear({{ $Questionkey }});"><i class="fa fa-plus"></i></button>
                                                                        @if($yearKey>0)
                                                                            &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm Year" style="margin-top:25px;" onclick="Year(this);"><i class="fa fa-close"></i></button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        <div class="AppendYear{{ $Questionkey }}"></div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-primary btn-sm AddTrueorFalseQuestions" style="margin-top:25px;" onclick="AddTrueorFalseQuestions();"><i class="fa fa-plus"></i> Add Questions</button>
                                                                @if ($Questionkey > 0)
                                                                    &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm RemoveTrueorFalseQuestions" style="margin-top:25px;" onclick="RemoveTrueorFalseQuestions(this);"><i class="fa fa-close"></i> Remove Questions</button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="line-dashed line-full"/>
                                            <input type="hidden" name="question_key" id="question_key" value="{{ ++$Questionkey }}">
                                        @endforeach
                                    @elseif ($segregation_id == 2)
                                    <?php $questionLoop = 0; ?>
                                        @foreach ($Questions as $Questionkey=>$Question)
                                            <?php $Questioncount = ++$questionLoop; $optionLoop = 0; $optioncount = 0;?>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <input type="hidden" name="question[question_id][]" value="{{ $Question->id }}">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                {{-- <label>Question {{ $questionLoop }}</label> --}}
                                                                <label>Question</label>
                                                                <textarea class="summernote" name="question[question_name][]" id="summernote">{{ $Question->question_name }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @foreach (unserialize($Question->answer_option) as $OptionKey=>$option)
                                                        <?php $optioncount = ++$optionLoop; ?>
                                                        <div class="panel panel-default">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            {{-- <label>Option {{ $optionLoop }}</label> --}}
                                                                            <label>Option</label>
                                                                            <textarea class="summernote" name="question[{{ $Questionkey }}][answer_option][]" id="summernote">{{ $option }}</textarea>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            {!! Form::label('name', 'Question Answer') !!} (If this is correct answer,you too check only true option.Otherwise is empty )
                                                                            <label class="checkbox checkbox-custom-alt">
                                                                                <input type="radio" name="question[{{ $Questionkey }}][answer][]" value="{{ $OptionKey }}" {{ in_array($OptionKey,unserialize($Question->answer)) ? "checked" : "" }}><i></i>Answer
                                                                            </label>
                                                                            {{-- <label class="checkbox checkbox-custom-alt">
                                                                                <input type="radio" name="question[{{ $Questionkey }}][answer][]" value="{{ $OptionKey }}" {{ in_array($OptionKey,unserialize($Question->answer)) }}><i></i>False
                                                                            </label> --}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <button type="button" class="btn btn-primary btn-sm AddAnswer" style="margin-top:25px;" onclick="AddAnswer({{ $Questionkey }});"><i class="fa fa-plus"></i>Add Option</button>
                                                                            @if($OptionKey>0)
                                                                                &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm Year" style="margin-top:25px;" onclick="RemoveAnswer(this);"><i class="fa fa-close"></i>Remove Option</button>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @endforeach
                                                    <input type="hidden" optionId="{{ $OptionKey }}" name="option_key" id="option_key" value="{{ ++$OptionKey }}">
                                                    <input type="hidden" name="option_key" id="option_key" value="{{ ++$OptionKey }}">
                                                    <div class="AppendAnswer{{ $Questionkey }}"></div>

                                                    <div class="row">
                                                        @foreach ($Question->QuestionYears as $yearKey=>$QuestionYear)
                                                        <input type="hidden" name="question[{{ $Questionkey }}][year_id][]" value="{{ $QuestionYear->id }}">
                                                            <div class="form-group">
                                                                <div class="col-sm-3">
                                                                    <label>Year</label>
                                                                    <select name="question[{{ $Questionkey }}][year][]" id="country" class="form-control chosen-select">
                                                                        @foreach($Years as $id=> $country)
                                                                            <option value="{{ $id }}" {{ $id == $QuestionYear->year ? "selected" : "" }}>{{ $country->year }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <button type="button" class="btn btn-primary btn-sm AddYear" style="margin-top:25px;" onclick="AddYear({{ $Questionkey }});"><i class="fa fa-plus"></i></button>
                                                                        @if($yearKey>0)
                                                                            &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm Year" style="margin-top:25px;" onclick="RemoveYear(this);"><i class="fa fa-close"></i></button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        <div class="AppendYear{{ $Questionkey }}"></div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                @if($Questionkey > 0)
                                                                    <button type="button" class="btn btn-primary btn-sm AddQuestions" style="margin-top:25px;" onclick="AddCTBQuestions();"><i class="fa fa-plus"></i> Add Questions</button>
                                                                    &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm RemoveCTBQuestions" style="margin-top:25px;" onclick="RemoveCTBQuestions(this);"><i class="fa fa-close"></i> Remove Questions</button>
                                                                @else
                                                                    <button type="button" class="btn btn-primary btn-sm AddQuestions" style="margin-top:25px;" onclick="AddCTBQuestions();"><i class="fa fa-plus"></i> Add Questions</button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="line-dashed line-full"/>
                                            <input type="hidden" name="question_key" id="question_key" value="{{ ++$Questionkey }}">
                                        @endforeach
                                    @else
                                    <?php $questionLoop = 0; ?>
                                        @foreach ($Questions as $Questionkey=>$Question)
                                            <?php $Questioncount = ++$questionLoop; ?>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <input type="hidden" name="question[question_id][]" value="{{ $Question->id }}">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                {{-- <label>Question {{ $questionLoop }}</label> --}}
                                                                <label>Question</label>
                                                                <textarea class="summernote" name="question[question_name][]" id="summernote">{{ $Question->question_name }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Answer</label>
                                                                <textarea class="summernote" name="question[{{ $Questionkey }}][answer][]" id="summernote">{{ unserialize($Question->answer)[0] }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        @foreach ($Question->QuestionYears as $yearKey=>$QuestionYear)
                                                            <input type="hidden" name="question[{{ $Questionkey }}][year_id][]" value="{{ $QuestionYear->id }}">
                                                            <div class="form-group">
                                                                <div class="col-sm-3">
                                                                    <label>Year</label>
                                                                    <select name="question[{{ $Questionkey }}][year][]" id="country" class="form-control chosen-select">
                                                                        @foreach($Years as $id=> $country)
                                                                            <option value="{{ $id }}" {{ $id == $QuestionYear->year ? "selected" : "" }}>{{ $country->year }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <button type="button" class="btn btn-primary btn-sm AddYear" style="margin-top:25px;" onclick="AddYear({{ $Questionkey }});"><i class="fa fa-plus"></i></button>
                                                                        @if($yearKey>0)
                                                                            &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm Year" style="margin-top:25px;" onclick="Year(this);"><i class="fa fa-close"></i></button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        <div class="AppendYear{{ $Questionkey }}"></div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-primary btn-sm AddDefaultQuestions" style="margin-top:25px;" onclick="AddDefaultQuestions();"><i class="fa fa-plus"></i> Add Questions</button>
                                                                &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm RemoveDefaultQuestions" style="margin-top:25px;" onclick="RemoveDefaultQuestions(this);"><i class="fa fa-close"></i> Remove Questions</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="line-dashed line-full"/>

                                            <input type="hidden" name="question_key" id="question_key" value="{{ ++$Questionkey }}">
                                        @endforeach
                                    @endif
                                    <script>
                                        //Remove Questions AddMore Details
                                        function RemoveTrueorFalseQuestions(remove) {
                                            $(remove).parent().parent().parent().parent().parent().remove();
                                        }

                                        //Remove Questions AddMore Details
                                        function RemoveCTBQuestions(remove) {
                                            $(remove).parent().parent().parent().parent().parent().remove();
                                        }

                                        //Remove Questions AddMore Details
                                        function RemoveDefaultQuestions(remove) {
                                            $(remove).parent().parent().parent().parent().parent().remove();
                                        }

                                        function RemoveYear(remove) {
                                            $(remove).parent().parent().parent().remove();
                                        }

                                        function RemoveAnswer(remove) {
                                            $(remove).parent().parent().parent().parent().parent().parent().remove();
                                        }
                                    </script>
                                    <div class="appendQuestionModels"></div>

                                    <div class="TotalQuestionCount"><span><p>Total Number of Question : {{ $Questioncount }}</p></span></div>
                                </fieldset>
                            {!! Form::close() !!}
                        </div>

                        <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                            <button type="submit" class="btn btn-lightred" id="form2Submit">Submit</button>
                        </div>

                    </section>

                </div>
            </div>
            <!-- /row -->

        </div>

    </section>

@endsection

@section('script')
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>


    <script>
        var SelectSegregation = "";
        var questionTypeId = "";
        var questionLoop = "";
        var optionLoop = "";
        $(window).load(function(){
            $('#form2Submit').on('click', function(){
                $('#form2').submit();
            });
            SelectSegregation = '{{ $segregation_id }}';

            segregationId = '{{ $segregation_id }}';

            questionTypeId = '{{ $question_type_id }}';

            questionLoop = '{{ $Questioncount }}';

            optionLoop = '{{ $optioncount }}';

            getSegregation(questionTypeId)

            // getQuestionModels(SelectSegregation);

            $('.summernote').summernote({
                height: 200   //set editable area's height
            });
        });

        function getSegregation(question_type_id){
            var question_type_id = question_type_id;
            var selectHTML = "";
            if(question_type_id != ''){
                $.ajax({
                    type: "get",
                    url: '{{ route("getSegregation") }}',
                    data:{question_type_id:question_type_id},
                    success: function(data) {
                        for (var key in data) {
                            var row = data[key];
                            selectHTML += "<option value='" + row.id + "'>" + row.segregation + "</option>";
                        }
                        console.log(selectHTML);
                        $('.segregation_id').html(selectHTML);
                        $('#segregation_id').attr("disabled",'disabled');
                        $('.segregation_id').val(SelectSegregation).trigger("chosen:updated");
                    }
                });
            }
        }

        var questionId = $('#question_key').val();
        var optionId = $('#option_key').val();

        function getQuestionModels(segregationId) {
            if (segregationId == 1) {
                questionId = questionId;
                AddTrueorFalseQuestions();
            }else if(segregationId == 2){
                questionId = questionId;
                optionId = optionId;
                optionLoop = optionId;
                AddCTBQuestions();
            }else{
                questionId = questionId;
                AddDefaultQuestions();
            }
        }

        var appendQuestionModels = "";
        var AppendYear = "";
        function AddTrueorFalseQuestions() {
            ++questionLoop;

            if(questionId > 0){
                $questionId = '<button type="button" class="btn btn-primary btn-sm AddQuestions" style="margin-top:25px;" onclick="AddTrueorFalseQuestions();"><i class="fa fa-plus"></i> Add Questions</button>' +
                '&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm RemoveTrueorFalseQuestions" style="margin-top:25px;" onclick="RemoveTrueorFalseQuestions(this);"><i class="fa fa-close"></i> Remove Questions</button>';
            }else{
                $questionId = '<button type="button" class="btn btn-primary btn-sm AddQuestions" style="margin-top:25px;" onclick="AddTrueorFalseQuestions();"><i class="fa fa-plus"></i> Add Questions</button>';
            }
            $count = '<span><p>Total Number of Question : '+questionLoop+'</p></span>';
            appendQuestionModels =
                '<div class="panel panel-default">' +
                    '<div class="panel-body">' +
                        '<div class="row">' +
                            '<div class="col-sm-12">' +
                                '<div class="form-group">' +
                                    '<label>Question</label>' +
                                    // '<label>Question '+questionLoop+'</label>' +
                                    '<textarea class="summernote" name="question[question_name][]" id="summernote"></textarea>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +

                        '<div class="row">' +
                            '<div class="col-lg-6">' +
                                '<div class="form-group">' +
                                    '{!! Form::label('name', 'Question Answer') !!}' +
                                    '<label class="checkbox checkbox-custom-alt">' +
                                        '<input type="radio" name="question['+questionId+'][answer][]" value="true"><i></i>True' +
                                    '</label>' +
                                    '<label class="checkbox checkbox-custom-alt">' +
                                        '<input type="radio" name="question['+questionId+'][answer][]" value="false"><i></i>False' +
                                    '</label>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +

                        '<div class="row">' +
                            '<div class="form-group">' +
                                '<div class="col-sm-3">' +
                                    '<label>Year</label>' +
                                    '<select name="question['+questionId+'][year][]" id="country" class="form-control chosen-select">' +
                                        @foreach($Years as $id=> $country)
                                            '<option value="{{ $id }}">{{ $country->year }}</option>' +
                                        @endforeach
                                    '</select>' +
                                '</div>' +

                                '<div class="col-sm-3">' +
                                    '<div class="form-group">' +
                                        '<button type="button" class="btn btn-primary btn-sm AddYear" style="margin-top:25px;" onclick="AddYear('+questionId+');"><i class="fa fa-plus"></i></button>' +
                                        // '&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm Year" style="margin-top:25px;" onclick="Year(this);"><i class="icon-close"></i>Remove Questions</button>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +

                            '<div class="AppendYear'+questionId+'"></div>' +
                        '</div>' +

                        '<div class="row">' +
                            '<div class="col-sm-6">' +
                                '<div class="form-group">' +
                                    $questionId
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +

                '<hr class="line-dashed line-full"/>';
            if (questionId == 0) {
                $('.appendQuestionModels').html(appendQuestionModels);
                $('.TotalQuestionCount').html($count);
            }else{
                $('.appendQuestionModels').append(appendQuestionModels);
                $('.TotalQuestionCount').html($count);
            }
            questionId++;

            // $('.summernote').summernote();
            $('.summernote').summernote({
                height: 200   //set editable area's height
            });

            $('.chosen-select').chosen({

            });

        }

        //Remove Questions AddMore Details
        function RemoveTrueorFalseQuestions(remove) {
            questionId--;
            $(remove).parent().parent().parent().parent().parent().remove();
        }

        function AddCTBQuestions() {
            optionId = 0;
            optionLoop = 0;
            ++questionLoop;
            ++optionLoop;
            if(questionId > 0){
                $questionId = '<button type="button" class="btn btn-primary btn-sm AddQuestions" style="margin-top:25px;" onclick="AddCTBQuestions();"><i class="fa fa-plus"></i> Add Questions</button>' +
                        '&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm RemoveCTBQuestions" style="margin-top:25px;" onclick="RemoveCTBQuestions(this);"><i class="fa fa-close"></i> Remove Questions</button>';
            }else{
                $questionId = '<button type="button" class="btn btn-primary btn-sm AddQuestions" style="margin-top:25px;" onclick="AddCTBQuestions();"><i class="fa fa-plus"></i> Add Questions</button>' ;
            }
            $count = '<span><p>Total Number of Question : '+questionLoop+'</p></span>';
            appendQuestionModels =
                '<div class="panel panel-default">' +
                    '<div class="panel-body">' +
                        '<div class="row">' +
                            '<div class="col-sm-12">' +
                                '<div class="form-group">' +
                                    '<label>Question</label>' +
                                    // '<label>Question '+questionLoop+'</label>' +
                                    '<textarea class="summernote" name="question[question_name][]" id="summernote"></textarea>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                        '<div class="panel panel-default">' +
                            '<div class="panel-body">' +
                                '<div class="row">' +
                                    '<div class="col-sm-12">' +
                                        '<div class="form-group">' +
                                            // '<label>Option'+optionLoop+'</label>' +
                                            '<label>Option</label>' +
                                            '<textarea class="summernote" name="question['+questionId+'][answer_option][]" id="summernote"></textarea>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="col-lg-12">' +
                                        '<div class="form-group">' +
                                            '{!! Form::label('name', 'Question Answer') !!} (If this is correct answer,you too check only true option.Otherwise is empty )' +
                                            '<label class="checkbox checkbox-custom-alt">' +
                                                '<input type="radio" name="question['+questionId+'][answer][]" value="'+optionId+'"><i></i>Answer' +
                                            '</label>' +
                                            // '<label class="checkbox checkbox-custom-alt">' +
                                            //     '<input type="radio" name="question['+questionId+'][answer][]" value="'+optionId+'"><i></i>False' +
                                            // '</label>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="row">' +
                                    '<div class="col-sm-3">' +
                                        '<div class="form-group">' +
                                            '<button type="button" class="btn btn-primary btn-sm AddAnswer" style="margin-top:25px;" optionId="'+questionId+'" onclick="AddAnswer('+questionId+');"><i class="fa fa-plus"></i>Add Option</button>' +
                                            // '&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm Year" style="margin-top:25px;" onclick="RemoveAnswer(this);"><i class="icon-close"></i>Remove Questions</button>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +

                        '<div class="AppendAnswer'+questionId+'"></div>' +

                        '<div class="row">' +
                            '<div class="form-group">' +
                                '<div class="col-sm-3">' +
                                    '<label>Year</label>' +
                                    '<select name="question['+questionId+'][year][]" id="country" class="form-control chosen-select">' +
                                        @foreach($Years as $id=> $country)
                                            '<option value="{{ $id }}">{{ $country->year }}</option>' +
                                        @endforeach
                                    '</select>' +
                                '</div>' +

                                '<div class="col-sm-3">' +
                                    '<div class="form-group">' +
                                        '<button type="button" class="btn btn-primary btn-sm AddYear" style="margin-top:25px;" onclick="AddYear('+questionId+');"><i class="fa fa-plus"></i></button>' +
                                        // '&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm Year" style="margin-top:25px;" onclick="Year(this);"><i class="icon-close"></i>Remove Questions</button>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +

                            '<div class="AppendYear'+questionId+'"></div>' +
                        '</div>' +

                        '<div class="row">' +
                            '<div class="col-sm-6">' +
                                '<div class="form-group">' +
                                    $questionId;
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +

                '<hr class="line-dashed line-full"/>';
                if (questionId == 0) {
                    $('.appendQuestionModels').html(appendQuestionModels);
                    $('.TotalQuestionCount').html($count);
                }else{
                    $('.appendQuestionModels').append(appendQuestionModels);
                    $('.TotalQuestionCount').html($count);
                }
            questionId++;
            optionId++;
            $('.summernote').summernote({
                height: 200   //set editable area's height
            });
            $('.chosen-select').chosen({

            });
        }

        //Remove Questions AddMore Details
        function RemoveCTBQuestions(remove) {
            questionId--;
            $(remove).parent().parent().parent().parent().parent().remove();
        }

        function AddDefaultQuestions() {
            ++questionLoop;

            if(questionId > 0){
                $questionId = '<button type="button" class="btn btn-primary btn-sm AddDefaultQuestions" style="margin-top:25px;" onclick="AddDefaultQuestions();"><i class="fa fa-plus"></i> Add Questions</button>' +
                                    '&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm RemoveDefaultQuestions" style="margin-top:25px;" onclick="RemoveDefaultQuestions(this);"><i class="fa fa-close"></i> Remove Questions</button>';
            }else{
                $questionId = '<button type="button" class="btn btn-primary btn-sm AddDefaultQuestions" style="margin-top:25px;" onclick="AddDefaultQuestions();"><i class="fa fa-plus"></i> Add Questions</button>';
            }
            $count = '<span><p>Total Number of Question : '+questionCount+'</p></span>';
            appendQuestionModels =
                '<div class="panel panel-default">' +
                    '<div class="panel-body">' +
                        '<div class="row">' +
                            '<div class="col-sm-6">' +
                                '<div class="form-group">' +
                                    '<label>Question</label>' +
                                    // '<label>Question '+questionLoop+'</label>' +
                                    '<textarea class="summernote" name="question[question_name][]" id="summernote"></textarea>' +
                                '</div>' +
                            '</div>' +

                            '<div class="col-lg-6">' +
                                '<div class="form-group">' +
                                    '<label>Answer</label>' +
                                    '<textarea class="summernote" name="question['+questionId+'][answer][]" id="summernote"></textarea>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +

                        '<div class="row">' +
                            '<div class="form-group">' +
                                '<div class="col-sm-3">' +
                                    '<label>Year</label>' +
                                    '<select name="question['+questionId+'][year][]" id="country" class="form-control chosen-select">' +
                                        @foreach($Years as $id=> $country)
                                            '<option value="{{ $id }}">{{ $country->year }}</option>' +
                                        @endforeach
                                    '</select>' +
                                '</div>' +

                                '<div class="col-sm-3">' +
                                    '<div class="form-group">' +
                                        '<button type="button" class="btn btn-primary btn-sm AddYear" style="margin-top:25px;" onclick="AddYear('+questionId+');"><i class="fa fa-plus"></i></button>' +
                                        // '&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm Year" style="margin-top:25px;" onclick="Year(this);"><i class="icon-close"></i>Remove Questions</button>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +

                            '<div class="AppendYear'+questionId+'"></div>' +
                        '</div>' +

                        '<div class="row">' +
                            '<div class="col-sm-6">' +
                                '<div class="form-group">' +
                                    $questionId;
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +

                '<hr class="line-dashed line-full"/>';
            if (questionId == 0) {
                $('.appendQuestionModels').html(appendQuestionModels);
                $('.TotalQuestionCount').html($count);
            }else{
                $('.appendQuestionModels').append(appendQuestionModels);
                $('.TotalQuestionCount').html($count);
            }
            questionId++;
            $('.summernote').summernote({
                height: 200   //set editable area's height
            });
            $('.chosen-select').chosen({

            });
        }

        //Remove Questions AddMore Details
        function RemoveDefaultQuestions(remove) {
            questionId--;
            $(remove).parent().parent().parent().parent().parent().remove();
        }

        function AddYear(questionId) {
            AppendYear = '<div class="form-group">' +
                            '<div class="col-sm-3">' +
                                '<label>Year</label>' +
                                '<select name="question['+questionId+'][year][]" id="country" class="form-control chosen-select">' +
                                    @foreach($Years as $id=> $country)
                                        '<option value="{{ $id }}">{{ $country->year }}</option>' +
                                    @endforeach
                                '</select>' +
                            '</div>' +

                            '<div class="col-sm-3">' +
                                '<div class="form-group">' +
                                    '<button type="button" class="btn btn-primary btn-sm AddYear" style="margin-top:25px;" onclick="AddYear('+questionId+');"><i class="fa fa-plus"></i></button>' +
                                    '&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm RemoveYear" style="margin-top:25px;" onclick="RemoveYear(this);"><i class="fa fa-times"></i></button>' +
                                '</div>' +
                            '</div>' +
                            // '<div class="AppendYear'+questionId+'"></div>' +
                        '</div>';
            $('.AppendYear'+questionId).append(AppendYear);
            $('.chosen-select').chosen({

            });
        }

        function RemoveYear(remove) {
            $(remove).parent().parent().parent().remove();
        }

        function AddAnswer(questionId) {
        // alert($('#option_key').val());
            ++optionLoop;
            AppendAnswer = '<div class="panel panel-default">' +
                                '<div class="panel-body">' +
                                    '<div class="row">' +
                                        '<div class="form-group">' +
                                            '<div class="col-sm-12">' +
                                                '<div class="form-group">' +
                                                    // '<label>Option '+optionLoop+'</label>' +
                                                    '<label>Option</label>' +
                                                    '<textarea class="summernote" name="question['+questionId+'][answer_option][]" id="summernote"></textarea>' +
                                                '</div>' +
                                            '</div>' +

                                            '<div class="col-lg-12">' +
                                                '<div class="form-group">' +
                                                    '<label>Question Answer</label>If this is correct answer,you too check only true option.Otherwise is empty )' +
                                                    '<label class="checkbox checkbox-custom-alt">' +
                                                        '<input type="radio" name="question['+questionId+'][answer][]" value="'+optionId+'"><i></i>True' +
                                                    '</label>' +
                                                    // '<label class="checkbox checkbox-custom-alt">' +
                                                    //     '<input type="radio" name="question['+questionId+'][answer][]" value="'+optionId+'"><i></i>False' +
                                                    // '</label>' +
                                                '</div>' +
                                            '</div>' +

                                            '<div class="col-sm-3">' +
                                                '<div class="form-group">' +
                                                    '<button type="button" class="btn btn-primary btn-sm AddAnswer" style="margin-top:25px;" onclick="AddAnswer('+questionId+');"><i class="fa fa-plus"></i>Add Option</button>' +
                                                    '&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm RemoveAnswer" style="margin-top:25px;" onclick="RemoveAnswer(this);"><i class="fa fa-times"></i>Remove Option</button>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';
            $('.AppendAnswer'+questionId).append(AppendAnswer);
            optionId++;
            $('.summernote').summernote({
                height: 200   //set editable area's height
            });
        }

        function RemoveAnswer(remove) {
            optionId--;
            $(remove).parent().parent().parent().parent().parent().parent().remove();
        }
    </script>
@endsection
