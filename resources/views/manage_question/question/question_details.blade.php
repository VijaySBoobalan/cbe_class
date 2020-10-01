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
                                        <th>Question</th>
                                        <th>Question Options</th>
                                        <th>Question Answer</th>
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
                                                <td>{!!$Question->question_name!!}</td>
                                                <td>
                                                    @if ($Question->segregation_id == 1)
                                                       {{ "-" }}
                                                    @elseif($Question->segregation_id == 2)
                                                        @foreach (unserialize($Question->answer_option) as $key=>$answer_option)
                                                            <p>{!!$answer_option!!}</p>
                                                        @endforeach
                                                    @else
                                                        {{ "-" }}
                                                    @endif
                                            </td>
                                            <td>
                                                @if ($Question->segregation_id == 1)
                                                    {{ unserialize($Question->answer)[0] }}
                                                @elseif($Question->segregation_id == 2)
                                                    @foreach (unserialize($Question->answer_option) as $key=>$answer_option)
                                                        <p>{!! $key == unserialize($Question->answer)[0] ? $answer_option : "" !!}</p>
                                                    @endforeach
                                                @else
                                                    {!! unserialize($Question->answer)[0] !!}
                                                @endif
                                            </td>
                                            <td></td>
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
    @include('manage_question.question.js')
@endsection

