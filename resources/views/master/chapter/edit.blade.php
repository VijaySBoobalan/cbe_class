@extends('layouts.master')

@section('view_chapter')
active
@endsection

@section('chapter_open_menu_display')
block
@endsection

@section('chapter_menu')
active open
@endsection

<script src="{{ asset('js/main_pages/editUnit.js') }}"></script>

@section('content')
<section id="content">
    <div class="page page-tables-datatables">
        <div class="row">
            <div class="col-md-12">
                <section class="tile">
                    <div class="tile-header dvd dvd-btm">
                        <h1 class="custom-font"><strong>Edit Chapter</h1>
                    </div>
                    <!-- /tile header -->

                    <!-- tile body -->

                    <div class="tile-body">
                        <form class="form-validate-jquery" action="{{ url('update_chapter') }}" id="subject_form" method="post">
                            @csrf
                            <?php $count = 0; ?>
                            @foreach ($Chapters as $Syllabuskey=>$Syllabi)
                                <input type="hidden" name="staff_subject_id" value="{{ $id }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <input type="hidden" name="unit[unit_id][]" value="{{$Syllabi->id}}">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Unit</label>
                                                        <input type="text" name="unit[unit_number][]" placeholder="Unit Number" class="form-control " value="{{ $Syllabi->unit_number }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Name Of the Unit</label>
                                                        <input type="text" name="unit[unit_name][]" placeholder="Unit Name" class="form-control " value="{{ $Syllabi->unit_name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Unit Type</label>
                                                        <select name="unit[unit_type][]" id="participate" class="form-control form-control-select2">
                                                            <option value="theory" {{ $Syllabi->unit_type == "theory" ? "selected" : "" }}>Theory</option>
                                                            <option value="practical" {{ $Syllabi->unit_type == "practical" ? "selected" : "" }}>Practical</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>From</label>
                                                        <input type="text" name="unit[unit_from][]" placeholder="From Date" class="form-control pickadate" value="{{ $Syllabi->unit_from }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>To</label>
                                                        <input type="text" name="unit[unit_to][]" placeholder="To Date" class="form-control pickadate" value="{{ $Syllabi->unit_to }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-primary btn-sm AddChapter" style="margin-top:25px;" onclick="AddChapter({{ $Syllabuskey }});"><i class="icon-plus2"></i>Add Chapter</button>
                                                        &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm RemoveUnit" style="margin-top:25px;" onclick="RemoveUnit(this);"><i class="icon-x"></i>Remove Unit</button>
                                                    </div>
                                                </div>
                                                    @foreach($Syllabi->getChapterDetails as $chapterKey=>$get_chapter_detail)
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-body">
                                                                        <input type="hidden" name="chapter[{{ $Syllabuskey }}][chapter_id][]" value="{{$get_chapter_detail->id}}">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label>Chapter</label>
                                                                                <input type="text" name="chapter[{{ $Syllabuskey }}][chapter_number][]" placeholder="Unit Number" class="form-control " value="{{ $get_chapter_detail->chapter_number }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label>Name Of the chapter</label>
                                                                                <input type="text" name="chapter[{{ $Syllabuskey }}][chapter_name][]" placeholder="Unit Name" class="form-control " value="{{ $get_chapter_detail->chapter_name }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label>Hours</label>
                                                                                <input type="" class="form-control" name="chapter[{{ $Syllabuskey }}][chapter_hours][]" placeholder="Total Hours" value="{{ $get_chapter_detail->chapter_hours }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label>From</label>
                                                                                <input type="text" name="chapter[{{ $Syllabuskey }}][chapter_from][]" placeholder="From Date" class="form-control pickadate" value="{{ $get_chapter_detail->chapter_from }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label>To</label>
                                                                                <input type="text" name="chapter[{{ $Syllabuskey }}][chapter_to][]" placeholder="To Date" class="form-control pickadate" value="{{ $get_chapter_detail->chapter_to }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <button type="button" class="btn btn-primary btn-sm AddChapter" style="margin-top:25px;" onclick="AddChapter({{ $Syllabuskey }});"><i class="icon-plus2"></i>Add Chapter</button>
                                                                                &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm RemoveChapter" style="margin-top:25px;" onclick="RemoveChapter(this);"><i class="icon-close"></i> Remove Chapter</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                <div class="AppendUnitChaptersDiv{{$Syllabuskey}}"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $count = $Syllabuskey; ?>
                            @endforeach
                            <input type="hidden" value="{{++$count}}" id="Syllabuskey">
                            <div class="AppendUnitDetailsdDiv"></div>
                            <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                <button type="button" class="btn btn-primary ml-3 AddUnit" onclick="AddUnit();" UnitId="0">Add Unit<i class="icon-paperplane ml-2"></i></button>
                                <button type="submit" class="btn btn-primary ml-3">Update<i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
    <script>
        //Add Unit AddMore Details
        var UnitId = 0;
        $( document ).ready(function() {
            UnitId = $("#Syllabuskey").val();
            console.log(UnitId);
        });

        function AddUnit() {
            var AppendUnitDetails =
            '<div class="row">' +
                '<div class="col-md-12">' +
                    '<div class="panel panel-default">' +
                        '<div class="panel-body">' +
                            '<div class="col-md-4">' +
                                '<div class="form-group">' +
                                    '<label>Unit</label>' +
                                    '<input type="text" name="unit[unit_number][]" placeholder="Unit Number" class="form-control ">' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                                '<div class="form-group">' +
                                    '<label>Name Of the Unit</label>' +
                                    '<input type="text" name="unit[unit_name][]" placeholder="Unit Name" class="form-control ">' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                                '<div class="form-group">' +
                                    '<label>Unit Type</label>' +
                                    '<select name="unit[unit_type][]" id="participate" class="form-control chosen-select">' +
                                        '<option value="theory">Theory</option>' +
                                        '<option value="practical">Practical</option>' +
                                    '</select>' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                                '<div class="form-group">' +
                                    '<label>From</label>' +
                                    '<input type="date" name="unit[unit_from][]" placeholder="From Date" class="form-control pickadate">' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                                '<div class="form-group">' +
                                    '<label>To</label>' +
                                    '<input type="date" name="unit[unit_to][]" placeholder="To Date" class="form-control pickadate">' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                                '<div class="form-group">' +
                                    '<button type="button" class="btn btn-primary btn-sm AddChapter" style="margin-top:25px;" onclick="AddChapter('+UnitId+');"><i class="icon-plus2"></i>Add Chapter</button>' +
                                    // '&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm RemoveUnit" style="margin-top:25px;" onclick="RemoveUnit(this);"><i class="icon-close"></i>Remove Unit</button>' +
                                '</div>' +
                            '</div>' +
                            '<div class="AppendUnitChaptersDiv'+UnitId+'"></div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>';

            $('.AppendUnitDetailsdDiv').append(AppendUnitDetails);
            UnitId++;
            // $('.pickadate').pickadate({
            //     selectMonths: true,
            //     selectYears: 75,
            //     format: 'dd/mm/yyyy',
            //     formatSubmit: 'yyyy/mm/dd',
            //     hiddenName: true,
            // });
        }

        //Remove Unit AddMore Details
        function RemoveUnit(remove) {
            UnitId--;
            $(remove).parent().parent().parent().parent().parent().remove();
        }


        //Add Chapter AddMore Details
        function AddChapter(UnitId) {
            var AppendUnitChapters =
            '<div class="row">' +
                '<div class="col-md-12">' +
                    '<div class="panel panel-default">' +
                        '<div class="panel-body">' +
                            '<div class="col-md-4">' +
                                '<div class="form-group">' +
                                    '<label>Chapter</label>' +
                                    '<input type="text" name="chapter['+UnitId+'][chapter_number][]" placeholder="Unit Number" class="form-control ">' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                                '<div class="form-group">' +
                                    '<label>Name Of the chapter</label>' +
                                    '<input type="text" name="chapter['+UnitId+'][chapter_name][]" placeholder="Unit Name" class="form-control ">' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                                '<div class="form-group">' +
                                    '<label>Hours</label>' +
                                    '<input type="" class="form-control" name="chapter['+UnitId+'][chapter_hours][]" placeholder="Total Hours" >' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                                '<div class="form-group">' +
                                    '<label>From</label>' +
                                    '<input type="date" name="chapter['+UnitId+'][chapter_from][]" placeholder="From Date" class="form-control pickadate">' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                                '<div class="form-group">' +
                                    '<label>To</label>' +
                                    '<input type="date" name="chapter['+UnitId+'][chapter_to][]" placeholder="To Date" class="form-control pickadate">' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                                '<div class="form-group">' +
                                    '<button type="button" class="btn btn-primary btn-sm AddChapter" style="margin-top:25px;" onclick="AddChapter('+UnitId+');"><i class="icon-plus2"></i>Add Chapter</button>' +
                                    '&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm RemoveChapter" style="margin-top:25px;" onclick="RemoveChapter(this);"><i class="icon-close"></i> Remove Chapter</button>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>';

            $('.AppendUnitChaptersDiv'+UnitId).append(AppendUnitChapters);
            // $('.pickadate').pickadate({
            //     selectMonths: true,
            //     selectYears: 75,
            //     format: 'dd/mm/yyyy',
            //     formatSubmit: 'yyyy/mm/dd',
            //     hiddenName: true,
            // });
        }

        //Remove Chapter AddMore Details
        function RemoveChapter(remove) {
            $(remove).parent().parent().parent().parent().parent().remove();
        }


    </script>
@endsection
