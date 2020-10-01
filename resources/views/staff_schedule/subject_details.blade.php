@if (!$StaffSubjectAssigns->isEmpty())
    <script>
        var MINOVATE = MINOVATE || {};

            $(function() {

            MINOVATE.extra = {

                init: function() {
                MINOVATE.extra.datepicker();
                },

                datepicker: function() {
                    if ($datepickerEl.length > 0) {
                        $datepickerEl.each(function() {
                        var element = $(this);
                        var format = element.data('format')
                        element.datetimepicker({
                            format: format,
                        });
                        });
                    }
                },

            };

            //!!!!!!!!!!!!!!!!!!!!!!!!!
            // initialize after resize
            //!!!!!!!!!!!!!!!!!!!!!!!!!

            MINOVATE.documentOnResize = {
                    init: function(){
                        var t = setTimeout( function(){
                            MINOVATE.documentOnReady.setSidebar();
                            MINOVATE.navbar.removeRipple();

                        }, 500 );
                    }
                };

            //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            // initialize when document ready
            //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

            MINOVATE.documentOnReady = {
                init: function(){
                    MINOVATE.extra.init();
                    MINOVATE.documentOnReady.setSidebar();
                },

                // run on window scrolling

                windowscroll: function(){
                    $window.on( 'scroll', function(){
                    });
                },


                setSidebar: function() {
                    width = $window.width();
                    if (width < 992) {
                        $app.addClass('sidebar-sm');
                    } else {
                        $app.removeClass('sidebar-sm sidebar-xs');
                    }
                    if (width < 768) {
                        $app.removeClass('sidebar-sm').addClass('sidebar-xs');
                    } else if (width > 992){
                        $app.removeClass('sidebar-sm sidebar-xs');
                    } else {
                        $app.removeClass('sidebar-xs').addClass('sidebar-sm');
                    }

                    if ($app.hasClass('sidebar-sm-forced')) {
                        $app.addClass('sidebar-sm');
                    }

                    if ($app.hasClass('sidebar-xs-forced')) {
                        $app.addClass('sidebar-xs');
                    }
                }

            };



            //!!!!!!!!!!!!!!!!!!!!!!!!!
            // global variables
            //!!!!!!!!!!!!!!!!!!!!!!!!!

            var $window = $(window),
                $body = $('body'),
                $header = $('#header'),
                $branding = $('#header .branding'),
                $sidebar = $('#sidebar'),
                $controls = $('#controls'),
                $app = $('.appWrapper'),
                $navigation = $('#navigation'),
                $sparklineEl = $('.sparklineChart'),
                $slimScrollEl = $('.slim-scroll'),
                $collapseSidebarEl = $('.collapse-sidebar'),
                $wrap = $('#wrap'),
                $offcanvasToggleEl = $('.offcanvas-toggle'),

                //navigation elements
                $dropdowns = $navigation.find('ul').parent('li'),
                $a = $dropdowns.children('a'),
                $notDropdowns = $navigation.children('li').not($dropdowns),
                $notDropdownsLinks = $notDropdowns.children('a'),
                // end of navuigation elements

                $headerSchemeEl = $('.color-schemes .header-scheme'),
                $brandingSchemeEl = $('.color-schemes .branding-scheme'),
                $sidebarSchemeEl = $('.color-schemes .sidebar-scheme'),
                $colorSchemeEl = $('.color-schemes .color-scheme'),
                $fixedHeaderEl = $('#fixed-header'),
                $fixedAsideEl = $('#fixed-aside'),
                $toggleRightbarEl = $('.toggle-right-sidebar'),
                $pickDateEl = $('.pickDate'),

                $tileEl = $('.tile'),
                $tileToggleEl = $('.tile .tile-toggle'),
                $tileRefreshEl = $('.tile .tile-refresh'),
                $tileFullscreenEl = $('.tile .tile-fullscreen'),
                $tileCloseEl = $('.tile .tile-close'),

                $easypiechartEl = $('.easypiechart'),
                $chosenEl = $('.chosen-select'),
                $toggleClassEl = $('.toggle-class'),
                $colorPickerEl = $('.colorpicker'),
                $touchspinEl = $('.touchspin'),
                $datepickerEl = $('.datepicker'),
                $animateProgressEl = $('.animate-progress-bar'),
                $counterEl = $('.counter'),
                $splashEl = $('.splash');


            //!!!!!!!!!!!!!
            // initializing
            //!!!!!!!!!!!!!
            $(document).ready( MINOVATE.documentOnReady.init );
            $window.on( 'resize', MINOVATE.documentOnResize.init );

            });

            $.extend( $.validator.prototype, {
                checkForm: function () {
                    this.prepareForm();
                    for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
                        if(true){
                            for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
                                this.check(this.findByName(elements[i].name)[cnt]);
                            }
                        } else {
                            // var el = this.findByName(elements[i].name);
                            this.check(elements[i]);
                        }
                    }
                    return this.valid();
                }
            });

    </script>
    <hr>
    <div class="row">
        <div class="col-md-12">

            <section class="tile">
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Staff Schedule</h1>
                </div>
                <div class="tile-body">

                @if (isset($StaffScheduleSubjectDetails))
                <?php $data = $StaffScheduleSubjectDetails; ?>
                    <form action="{{ action('StaffScheduleController@StaffScheduleUpdate') }}" id="UpdateStaffScheduleForm" method="post" class="form-validate-jquery UpdateStaffScheduleForm" data-parsley-validate name="form2" role="form2">
                @else
                    <form action="#" id="AddStaffScheduleForm" method="post" class="form-validate-jquery AddStaffScheduleForm" data-parsley-validate name="form2" role="form1">
                @endif
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        @csrf
                        <fieldset>
                            <input type="hidden" value="{{ $staff_id }}" name="staff_id">
                            <input type="hidden" value="{{ $class }}" name="class">
                            <input type="hidden" value="{{ $section_id }}" name="section_id">
                            <input type="hidden" value="{{ isset($StaffScheduleClass) ? $StaffScheduleClass->id  : null }}" name="staff_schedule_id">
                            <?php $disabled = ""; $count = 0;?>
                            @foreach ($StaffSubjectAssigns as $key=>$StaffSubjectAssign)
                                <div class="row">
                                    <input type="hidden" name="staff_schedule[id][]" value="{{ isset($data) ? @$data->pluck('id')[$key] : null }}">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Subject Details') !!}
                                            {!! Form::text(null,$StaffSubjectAssign->StaffSubject->subject_name, ['class' => 'form-control subject_id','placeholder'=>'Select Staff','id'=>'subject_id','disabled'=>'disabled']) !!}
                                            {!! Form::hidden('staff_schedule[subject_id][]',$StaffSubjectAssign->subjects, ['class' => 'form-control','placeholder'=>'Select Staff']) !!}
                                        </div>
                                    </div>
                                    <?php
                                        $subjectday = isset($data) ? isset($data->pluck('subject_day')[$key]) ? date('Y-m-d',strtotime($data->pluck('subject_day')[$key])) : date('m/d/Y') : null;
                                        $totime = isset($data) ? isset($data->pluck('to_time')[$key]) ? $data->pluck('to_time')[$key] : date('H:i') : null;
                                        if(isset($data)){
                                            if(isset($data->pluck('subject_day')[$key])){
                                                if(date('Y-m-d H:i') >= $subjectday ." ". $totime){
                                                    ?><script>toastr.error('{{ ++$count }}.Class time is over.So you cannot edit this.')</script>
                                                    <?php $disabled = "readonly";
                                                }else{
                                                    $disabled = "";
                                                }
                                            }else{
                                                $disabled = "";
                                            }
                                        }else{
                                            $disabled = "";
                                        }
                                    ?>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Date') !!}
                                            <div class="input-group datepicker" data-format="L">
                                                {!! Form::text('staff_schedule[subject_day][]' ,isset($data) ? isset($data->pluck('subject_day')[$key]) ? date('m/d/Y',strtotime($data->pluck('subject_day')[$key])) : date('m/d/Y') : date('m/d/Y') , ['class' => 'form-control subject_day','placeholder'=>'Day','id'=>'subject_day','required'=>'required',$disabled]) !!}
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        {!! Form::label('name', 'From Time') !!}
                                        <div class='input-group datepicker' data-format="LT">
                                            {!! Form::text('staff_schedule[from_time][]' ,isset($data) ? @$data->pluck('from_time')[$key] :null, ['class' => 'form-control from_time','placeholder'=>'From Time','id'=>'from_time','required'=>'required',$disabled]) !!}
                                            <span class="input-group-addon">
                                                <span class="fa fa-clock-o"></span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            {!! Form::label('name', 'To Time') !!}
                                            <div class='input-group datepicker' data-format="LT">
                                                {!! Form::text('staff_schedule[to_time][]' ,isset($data) ? @$data->pluck('to_time')[$key] :null, ['class' => 'form-control to_time','placeholder'=>'To Time','id'=>'to_time','required'=>'required',$disabled]) !!}
                                                <span class="input-group-addon">
                                                    <span class="fa fa-clock-o"></span>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </fieldset>
                        <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                            @if (isset($StaffScheduleSubjectDetails))
                                <button type="submit" class="btn btn-lightred UpdateStaffSchedule" id="UpdateStaffSchedule">Update</button>
                            @else
                                <button type="submit" class="btn btn-lightred AddStaffSchedule" id="AddStaffSchedule">Save</button>
                            @endif
                        </div>
                    </form>
                </div>

            </section>
        </div>
    </div>
@else
    <p>Data Not Available</p>
@endif

<script>

    $( document ).ready(function() {
        $('.AddStaffSchedule').on('click',function (e) {
            var form1 = $( "#AddStaffScheduleForm" );
            form1.validate();
            e.preventDefault();
            var checkValid1 = form1.valid();
            if(checkValid1 == true){
                $.ajax({
                    type: "post",
                    url: '{{ action('StaffScheduleController@StaffScheduleStore') }}',
                    data:$('#AddStaffScheduleForm').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if(data.status == 'error'){
                            toastr.error(data.message);
                        }else{
                            toastr.success(data.message);
                            $('.AddStaffScheduleModal').modal('hide');
                            AssignStaffScheduleTable.ajax.reload();
                            $(".AddStaffScheduleForm")[0].reset();
                            $('.staff_id').val("").trigger('chosen:updated');
                            $('.taken_class').val("").trigger('chosen:updated');
                            $('.section_id').val("").trigger('chosen:updated');
                        }
                    }
                });
            }
        });
    });
</script>
