@extends('layouts.master')

@section('view_videos')
active
@endsection

@section('upload_videos_menu')
active open
@endsection

@section('content')

<section id="content">

    <div class="page page-forms-validate">
        <div class="row">
            <div class="col-md-12">
                <section class="tile">
                    <div class="tile-header dvd dvd-btm">
                        <h1 class="custom-font"><strong>Record Details</h1>
                    </div>
                    <div class="tile-body">
                        <form id="videos_filter_form" method="post" class="form-validate-jquery videos_filter_form" data-parsley-validate name="form2" role="form">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            @csrf
                            <fieldset>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Subject Name') !!}
                                            {!! Form::select('subject_id',$subjects->pluck('subject_name','id')  ,null, ['class' => 'form-control chosen-select subject_details','placeholder'=>'Select Subject','id'=>'subject_details','required'=>'required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            {!! Form::label('', '&nbsp;') !!}
                                            {!! Form::button('Filter',['class' => 'chosen-container chosen-container-single btn btn btn-lightred','style="width: 100%;"','id'=>'videos_filter_form_btn']) !!}
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                    </div>
                    {!! Form::close() !!}
            </div>
            <div class="page page-tables-datatables">
                <div class="row">
                    <div class="col-md-12">
                        <section class="tile">
                            <div class="tile-body" stlye="background-color:#332840" id="video_results">
                                <!-- <div class="row">
                                    <div class="col-lg-4">
                                        <span class="VideoAppend md-10"><video width="320" height="240" controls>
                                                <source src="https://ttsvle.sgp1.digitaloceanspaces.com/1594847717161_VID_20141225_133830471.mp4?AWSAccessKeyId=PMDT42AMAQCN2QIRAMJV&Expires=1594963073&Signature=1FoihKWYo%2BJxiI6GThnrNp%2FG17w%3D" id="video_src" type="video/mp4"></video></span>
                                    </div>
                                    <div class="col-lg-4">
                                        <span class="VideoAppend md-10"><video width="320" height="240" controls>
                                                <source src="https://ttsvle.sgp1.digitaloceanspaces.com/1594847717161_VID_20141225_133830471.mp4?AWSAccessKeyId=PMDT42AMAQCN2QIRAMJV&Expires=1594963073&Signature=1FoihKWYo%2BJxiI6GThnrNp%2FG17w%3D" id="video_src" type="video/mp4"></video></span>
                                    </div>
                                    <div class="col-lg-4">
                                        <span class="VideoAppend md-10"><video width="320" height="240" controls>
                                                <source src="https://ttsvle.sgp1.digitaloceanspaces.com/1594847717161_VID_20141225_133830471.mp4?AWSAccessKeyId=PMDT42AMAQCN2QIRAMJV&Expires=1594963073&Signature=1FoihKWYo%2BJxiI6GThnrNp%2FG17w%3D" id="video_src" type="video/mp4"></video></span>
                                    </div>
                                </div> -->
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-lg-12">
                    <span class="VideoAppend md-10"><video width="320" height="240" controls>
                            <source src="https://ttsvle.sgp1.digitaloceanspaces.com/1594847717161_VID_20141225_133830471.mp4?AWSAccessKeyId=PMDT42AMAQCN2QIRAMJV&Expires=1594963073&Signature=1FoihKWYo%2BJxiI6GThnrNp%2FG17w%3D" id="video_src" type="video/mp4"></video></span>
                </div>
            </div> -->

            <div id="video_modal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Modal Header</h4>
                        </div>
                        <div class="modal-body">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /tile body -->
            <meta name="csrf-token" content="{{ csrf_token() }}">
</section>
</div>
</div>
</div>
</section>

@endsection
<style>
    .form-group {
        margin-bottom: 0 !important;
    }
</style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/aws-sdk/2.713.0/aws-sdk.js"></script>
<script>
    const config = {
        region: 'sgp1',
        accessKeyId: 'PMDT42AMAQCN2QIRAMJV',
        secretAccessKey: 't6vSW16+Z0VAWUFeXLAbpiz0uZ9inH0ZnSZ2f7bXdyA',
        bucketName: 'ttsvle',
        baseUrl: 'https://ttsvle.sgp1.digitaloceanspaces.com',
        maxImages: 20
    }
    // declare API object
    var spacesEndpoint =
        new AWS.Endpoint('sgp1.digitaloceanspaces.com');
    var s3 = new AWS.S3({
        endpoint: spacesEndpoint,
        accessKeyId: config.accessKeyId,
        secretAccessKey: config.secretAccessKey
    });
    // define bucket name
    var params = {
        Bucket: config.bucketName
    }

    s3VideoNames = [];
    s3.listObjects(params, function(err, data) {
        if (err) console.log(err, err.stack);
        else {
            data['Contents'].forEach(function(obj) {
                s3VideoNames.push(obj.Key.split(".")[0]);
            })
        };
    });

    // url = s3.getSignedUrl('getObject', {
    //     Bucket: 'ttsvle',
    //     Key: '1594969620019_2109846340072679.mp4',
    //     Expires: 604800
    // });
    var sessionIds = [];
    document.addEventListener('DOMContentLoaded', function() {
        $("#videos_filter_form_btn").click(function() {
            sessionIds = [];
            var formFileds = $('#videos_filter_form').serialize();
            axios.post("{{ url('filterStudentVideos') }}", formFileds).then(response => {
                var onlineClassObject = response.data;
                for (var i = 0; i < onlineClassObject.length; i++) {
                    sessionIds.push(onlineClassObject[i].session_id);
                }
                filteredValues = s3VideoNames.filter(val => sessionIds.includes(val));
                generateVideos();
            }).catch(error => {
                console.log(error);
            })
        });
    })

    function generateVideos() {
        var video = "";
        filteredValues.forEach(function(vidName,i) {
            url = s3.getSignedUrl('getObject', {
                Bucket: 'ttsvle',
                Key: vidName + '.mp4',
                Expires: 604800
            });
            rowDivStart = '<div class="row" style="margin-bottom:15px">';
            videoDiv = '<div class="col-lg-4"><video width="320" height="240" controls>' +
                '<source src="' + url + '" type="video/mp4">' +
                '</video></div>';
            rowDivEnd ='</div>';
debugger;
            if((i+1)%3 == 1){
                video += rowDivStart + videoDiv;
            }else if((i+1)%3 == 2){
                video +=  videoDiv;
            }else{
                video +=  videoDiv + rowDivEnd;
            }
        });
        // for(i=1; i<=3; i++){
        //     if(i%3 == 0){
                
        //     }else{

        //     }
        // }
        $('#video_results').html(video);
    }

    function getSection(value) {
        var student_class = value;
        var selectHTML = "";
        if (student_class != '') {
            $.ajax({
                type: "get",
                url: '{{ route("getSection") }}',
                data: {
                    student_class: student_class
                },
                success: function(data) {
                    for (var key in data) {
                        var row = data[key];
                        selectHTML += "<option value='" + row.id + "'>" + row.section + "</option>";
                    }
                    $('.section_id').html(selectHTML);
                    $('.section_id').val(SelectSection).trigger("chosen:updated");
                    if (SelectSection == "0") {
                        SelectSection = "";
                        getSubjects(SelectSection);
                    }
                }
            });
        }
    }

    function getSubjects(value) {
        return new Promise(resolve => {
            var taken_class = $('.taken_class').val();
            var section_id = value;
            var selectHTML = "";
            if (taken_class != "" && section_id != "") {
                axios.get("{{ action('StaffSubjectAssignController@create') }}", {
                    params: {
                        "class_id": taken_class,
                        "section_id": section_id
                    }
                }).then(response => {
                    for (var key in response.data) {
                        var row = response.data[key];
                        selectHTML += "<option value=" + row.id + ">" + row.subject_name + "</option>";
                    }
                    $('.subject_details').html(selectHTML);
                    $('.subject_details').val(SelectSubject).trigger('chosen:updated');
                    resolve(1)
                }).catch(error => {
                    console.log(error);
                })
            }
        })
    }

    var SelectSubject = "0";
    var SelectSection = "0";
</script>