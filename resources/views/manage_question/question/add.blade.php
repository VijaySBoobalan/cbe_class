@extends('layouts.master')

@section('question_create')
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
                            <h1 class="custom-font"><strong>Add Question</h1>

                        </div>

                        <div class="tile-body">

                            {!! Form::open(['url' => route('Questionstore'),'method' => 'post','class'=>'form-validate-jquery','data-parsley-validate','name'=>'form2','role'=>'form','id'=>'form2']) !!}
                                @csrf
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Chapter') !!}
                                                {!! Form::select('chapter_id', $Chapter->pluck('unit_name','id'),null, ['class' => 'form-control chapter_id chosen-select','placeholder'=>'Select Chapter','id'=>'chapter_id','required'=>'required']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Preparation Type') !!}
                                                {!! Form::select('preparation_type_id', $PreparationTypes->pluck('preparation_type','id'),null, ['class' => 'form-control preparation_type_id chosen-select','placeholder'=>'Preparation Type','id'=>'preparation_type_id','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Question Type') !!}
                                                {!! Form::select('question_type_id', $QuestionTypes->pluck('question_name','id'),null, ['onchange'=>'getSegregation(this.value);','class' => 'form-control question_type_id chosen-select','placeholder'=>'Question Type','id'=>'question_type_id','required'=>'required']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Segregation') !!}
                                                {!! Form::select('segregation_id', [] ,null, ['onchange'=>'getQuestionModels(this.value)','class' => 'form-control segregation_id chosen-select','placeholder'=>'Segregation','id'=>'segregation_id']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="appendQuestionModels"></div>

                                    <div class="TotalQuestionCount"></div>
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
        $(window).load(function(){
            $('#form2Submit').on('click', function(){
                $('#form2').submit();
            });

            // $('.summernote').summernote();
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
                        $('.segregation_id').val(SelectSegregation).trigger("chosen:updated");
                    }
                });
            }
        }
        var questionId = 0;
        var optionId = 0;
        var questionCount = 0;
        function getQuestionModels(segregationId) {
            if (segregationId == 1) {
                questionId = 0;
                questionCount = 0;
                AddTrueorFalseQuestions();
            }else if(segregationId == 2){
                questionId = 0;
                optionId = 0;
                questionCount = 0;
                OptionCount = 0;
                AddCTBQuestions();
            }else{
                questionId = 0;
                questionCount = 0;
                AddDefaultQuestions();
            }
        }

        var appendQuestionModels = "";
        var AppendYear = "";
        function AddTrueorFalseQuestions() {
            questionCount++;
            if(questionId > 0){
                $questionId = '<button type="button" class="btn btn-primary btn-sm AddQuestions" style="margin-top:25px;" onclick="AddTrueorFalseQuestions();"><i class="fa fa-plus"></i> Add Questions</button>' +
                '&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm RemoveTrueorFalseQuestions" style="margin-top:25px;" onclick="RemoveTrueorFalseQuestions(this);"><i class="fa fa-close"></i> Remove Questions</button>';
            }else{
                $questionId = '<button type="button" class="btn btn-primary btn-sm AddQuestions" style="margin-top:25px;" onclick="AddTrueorFalseQuestions();"><i class="fa fa-plus"></i> Add Questions</button>';
            }
            $count = '<span><p>Total Number of Question : '+questionCount+'</p></span>';
            appendQuestionModels =
                '<div class="panel panel-default">' +
                    '<div class="panel-body">' +
                        '<div class="row">' +
                            '<div class="col-sm-12">' +
                                '<div class="form-group">' +
                                    '<label>Question</label>' +
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
            questionCount++;
            OptionCount++;
            if(questionId > 0){
                $questionId = '<button type="button" class="btn btn-primary btn-sm AddQuestions" style="margin-top:25px;" onclick="AddCTBQuestions();"><i class="fa fa-plus"></i> Add Questions</button>' +
                        '&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm RemoveCTBQuestions" style="margin-top:25px;" onclick="RemoveCTBQuestions(this);"><i class="fa fa-close"></i> Remove Questions</button>';
            }else{
                $questionId = '<button type="button" class="btn btn-primary btn-sm AddQuestions" style="margin-top:25px;" onclick="AddCTBQuestions();"><i class="fa fa-plus"></i> Add Questions</button>' ;
            }
            $count = '<span><p>Total Number of Question : '+questionCount+'</p></span>';
            appendQuestionModels =
                '<div class="panel panel-default">' +
                    '<div class="panel-body">' +
                        '<div class="row">' +
                            '<div class="col-sm-12">' +
                                '<div class="form-group">' +
                                    '<label>Question</label>' +
                                    '<textarea class="summernote" name="question[question_name][]" id="summernote"></textarea>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                        '<div class="panel panel-default">' +
                            '<div class="panel-body">' +
                                '<div class="row">' +
                                    '<div class="col-sm-12">' +
                                        '<div class="form-group">' +
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
                                            '<button type="button" class="btn btn-primary btn-sm AddAnswer" style="margin-top:25px;" onclick="AddAnswer('+questionId+');"><i class="fa fa-plus"></i>Add Option</button>' +
                                            // '&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm Year" style="margin-top:25px;" onclick="Year(this);"><i class="icon-close"></i>Remove Questions</button>' +
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
            questionCount++;
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
            OptionCount++;
            AppendAnswer = '<div class="panel panel-default">' +
                                '<div class="panel-body">' +
                                    '<div class="row">' +
                                        '<div class="form-group">' +
                                            '<div class="col-sm-12">' +
                                                '<div class="form-group">' +
                                                    '<label>Option</label>' +
                                                    '<textarea class="summernote" name="question['+questionId+'][answer_option][]" id="summernote"></textarea>' +
                                                '</div>' +
                                            '</div>' +

                                            '<div class="col-lg-12">' +
                                                '<div class="form-group">' +
                                                    '{!! Form::label('name', 'Question Answer') !!}(If this is correct answer,you too check only true option.Otherwise is empty )' +
                                                    '<label class="checkbox checkbox-custom-alt">' +
                                                        '<input type="radio" name="question['+questionId+'][answer][]" value="'+optionId+'"><i></i>Answer' +
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
