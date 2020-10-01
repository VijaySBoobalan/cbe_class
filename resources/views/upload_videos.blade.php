@extends('layouts.master')

@section('upload_videos_menu')
active open
@endsection

@section('content')
<!-- <div style="color:red;position:fixed; top:35px;right:0;left:0;z-index:21">123</div> -->
<section id="content">

    <!--
The classic file input element we'll enhance to a file pond
-->
    <input type="file" class="filepond" name="filepond" data-max-file-size="4000MB" />
</section>
<!-- file upload itself is disabled in this pen -->
<style>
    /**
 * FilePond Custom Styles
 */
    .filepond--drop-label {
        color: #4c4e53;
        min-height: 500px !important
    }

    .filepond--root :not(text) {
        font-size: 30px !important
    }

    .filepond--label-action {
        text-decoration-color: #babdc0;
    }

    .filepond--panel-root {
        border-radius: 2em;
        background-color: #edf0f4;
        height: 1em;
    }

    .filepond--item-panel {
        background-color: #595e68;
    }

    .filepond--drip-blob {
        background-color: #7f8a9a;
    }


    /**
 * Page Styles
 */
    /* html {
        padding: 30vh 0 0;
    }

    body {
        max-width: 20em;
        margin: 0 auto;
    } */
</style>
<!-- <link rel="stylesheet" href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"/> -->
<link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.min.css" />

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/aws-sdk/2.713.0/aws-sdk.js"></script>
<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script> -->
<script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>
<!-- <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js"></script> -->
<!-- <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script> -->
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>


<script>
    /*
We want to preview images, so we need to register the Image Preview plugin
*/
AWS.config.httpOptions.timeout = 0;

    FilePond.registerPlugin(

        // encodes the file as base64 data
        FilePondPluginFileEncode,

        // validates the size of the file
        FilePondPluginFileValidateSize,

        // corrects mobile image orientation
        // FilePondPluginImageExifOrientation,

        // previews dropped images
        //   FilePondPluginImagePreview
    );
    document.addEventListener('FilePond:loaded', e => {
        console.log('FilePond ready for use', e.detail);
    });

    FilePond.setOptions({
        server: {
            process: function(fieldName, file, metadata, load, error, progress, abort) {
                var data = {
                    "fileName": file.name
                };
                axios.post("{{ url('validateVideo') }}", data).then(response => {
                    debugger;
                    if (response.data.response == 0) {
                        s3.upload({
                            Bucket: 'ttsvle',
                            Key: file.name,
                            Body: file,
                            ContentType: file.type,
                            ACL: 'private',
                        }, function(err, data) {
                            console.log(err);
                            if (err) {
                                error('Something went wrong');
                                return;
                            }

                            // pass file unique id back to filepond
                            load(data.Key);

                        });
                    } else {
                        bootbox.alert("Invalid File, You can upload your session videos only!", function() {
                            location.reload();
                        })
                    }
                }).catch(error => {
                    console.log(error);
                })


            }
        }
    });
    // Select the file input and use create() to turn it into a pond
    FilePond.create(
        document.querySelector('input')
    );

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
</script>