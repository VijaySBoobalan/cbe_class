@extends('layouts.master')

@section('add_staff')
active
@endsection

@section('staff_menu')
active open
@endsection

@section('content')
<!-- <div style="color:red;position:fixed; top:35px;right:0;left:0;z-index:21">123</div> -->
<section id="content">

    <div class="page page-forms-validate">

        <!-- row -->
        <div class="row">


            <div class="col-md-12">

                <div class="tile">

                    <div class="tile-header dvd dvd-btm">
                        <h1 class="custom-font"><strong>Add Staff</h1><a class="fa fa-expand" data-action="fullscreen"></a>

                    </div>

                    <div class="tile-body">
                        {!! Form::open(['url' => action('StaffController@store'),'method' => 'post','enctype'=>'multipart/form-data','class'=>'form-validate-jquery','data-parsley-validate','name'=>'form2','role'=>'form','id'=>'form2']) !!}
                        @csrf
                        <fieldset>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('name', 'Staff id No') !!}
                                        {!! Form::text('staff_id_no', null, ['class' => 'form-control','placeholder'=>'Staff id No','id'=>'staff_id_no','required'=>'required']) !!}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        
                                        {!! Form::label('name', 'Staff Name') !!}
                                        {!! Form::text('staff_name', null, ['class' => 'form-control','placeholder'=>'Staff Name','id'=>'staff_name','required'=>'required']) !!}
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        {!! Form::close() !!}
                    </div>

                    <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                        <button type="submit" class="btn btn-lightred" id="form2Submit">Submit</button>
                    </div>

                </div>

            </div>
        </div>
        <!-- /row -->




    </div>

</section>

@endsection

@section('script')
<style>
    /* [data-action="fullscreen"]:after {
        content: '\e9f9';
    }

    [data-action="fullscreen"][data-fullscreen="active"]:after {
        content: '\e9fa';
    } */

    .tile.fixed-top {
        overflow: auto;
        max-height: 100%;
    }

    .fixed-top {
        position: fixed;
        top: 0px;
        right: 0px;
        left: 0px;
        z-index: 1030;
    }

    .h-100 {
        height: 100% !important;
    }

    /* .rounded-0 {
        border-radius: 0 !important;
    } */
</style>
<script>
    $(function() {
        _cardActionFullscreen();
    })
    // Card fullscreen mode
    var _cardActionFullscreen = function() {
        $('.tile [data-action=fullscreen]').on('click', function(e) {
            e.preventDefault();
            // Define vars
            var $target = $(this),
                cardFullscreen = $target.closest('.tile'),
                overflowHiddenClass = 'overflow-hidden',
                collapsedClass = 'collapsed-in-fullscreen',
                fullscreenAttr = 'data-fullscreen';

            // Toggle classes on card
            cardFullscreen.toggleClass('fixed-top h-100 rounded-0');

            // Configure
            if (!cardFullscreen.hasClass('fixed-top')) {
                $target.removeAttr(fullscreenAttr);
                cardFullscreen.children('.' + collapsedClass).removeClass('show');
                $('body').removeClass(overflowHiddenClass);
                // $target.siblings('[data-action=move], [data-action=remove], [data-action=collapse]').removeClass('d-none');
            } else {
                $target.attr(fullscreenAttr, 'active');
                cardFullscreen.removeAttr('style').children('.collapse:not(.show)').addClass('show ' + collapsedClass);
                $('body').addClass(overflowHiddenClass);
                $("#sidebar").css("z-index","1");
                $("#header").css("z-index","1");
                // $target.siblings('[data-action=move], [data-action=remove], [data-action=collapse]').addClass('d-none');
            }
        });
    };
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
@endsection