<?php

namespace App\Http\Controllers;

use App\ShareScreenFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\File as File;
use Intervention\Image\ImageManagerStatic as Image;
class ShareScreenFilesController extends Controller
{
    public function ViewerfilesUpload(Request $request)
    {
        $ShareScreenFiles=new ShareScreenFiles();
        $ShareScreenFiles->staff_id = auth()->user()->id;
        $ShareScreenFiles->class = $request->class_id;
        $ShareScreenFiles->section_id = $request->section_id;
        $ShareScreenFiles->subject_id = $request->subject_id;
        if (isset($request->file)) {
            $files = $request->file('file');
            $document = $files->getClientOriginalName();
            $files->move(public_path().'/uploads/document/',$document);
            $ShareScreenFiles->file_name = $document;
        }
        $ShareScreenFiles->file_type = "file";
        $ShareScreenFiles->save();
        // $ShareScreenFiles = new ShareScreenFiles;
        // $ShareScreenFiles->file = $request->file->store('/', 'do_spaces');
        // Storage::cloud()->setVisibility($ShareScreenFiles->file, 'public/viewer');
        // $ShareScreenFiles->save();
    }

    public function ViewerimagesUpload(Request $request)
    {
        $ShareScreenFiles=new ShareScreenFiles;
        $ShareScreenFiles->staff_id = auth()->user()->id;
        $ShareScreenFiles->class = $request->class_id;
        $ShareScreenFiles->section_id = $request->section_id;
        $ShareScreenFiles->subject_id = $request->subject_id;
        if (isset($request->file)) {
            $files = $request->file('file');
            $image = $files->getClientOriginalName();
            $files->move(public_path().'/uploads/images/',$image);
            $ShareScreenFiles->file_name = $image;
        }
        $ShareScreenFiles->file_type = "image";
        $ShareScreenFiles->save();
        // $ShareScreenFiles = new ShareScreenFiles;
        // $ShareScreenFiles->file = $request->file->store('/', 'do_spaces');
        // Storage::cloud()->setVisibility($ShareScreenFiles->file, 'public/viewer');
        // $ShareScreenFiles->save();
    }

    public function VideofilesUpload(Request $request)
    {
        // try{
            $ShareScreenFiles=new ShareScreenFiles;
            $ShareScreenFiles->staff_id = auth()->user()->id;
            // if (isset($request->file)) {
            //     $ShareScreenFiles->file_name = $request->file->store('/', 'do_spaces');
            //     Storage::cloud()->setVisibility($ShareScreenFiles->file, 'public');
            // }
            // if (isset($request->file)) {
            //     $files = $request->file('file');
            //     $video = $files->getClientOriginalName();
            //     $files->move(public_path().'/uploads/video/',$video);
            //     $ShareScreenFiles->file_name = $video;
            // }
            $embeded_url = $this->getYoutubeEmbedUrl($request->link_upload);
            $ShareScreenFiles->file_name = $embeded_url;
            $ShareScreenFiles->file_type = "videos";
            $ShareScreenFiles->save();
            $Data['status'] = 'success';
            return response()->json($Data);
        // }catch (Exception $e){
        //     return response()->json(['error'=>'Subject Not Found!']);
        // }
    }

    public function uploadDocuments($file, $newName, $subFolder)
    {
        $folder = "app/uploads/" . $subFolder;
        if ($file != null) {
            $input= $file->getPathName();
            $file = $file->storeAs('importFiles', $file->getClientOriginalName());
            $getFile = Storage::put($folder . "/" . $file,$input);;
        } else {
            $file = "";
        }
        return $file;
    }

    public function uploadImages($file, $newName, $subFolder)
    {
        $folder = "uploads/" . $subFolder;
        if ($file != null) {
            $fileExtension = $file->getClientOriginalExtension();
            $newFileName = $newName;
            return $tmpFile = Image::make($file->getRealPath())->encode($fileExtension, 50);
            Storage::put($folder . "/" . $newFileName, $tmpFile);
        } else {
            $newFileName = "";
        }
        return $newName;
    }

    public function getDocumentList(Request $request)
    {
        return ShareScreenFiles::where([['file_type','file'],['staff_id',auth()->user()->id],['class',$request->class_id],['section_id',$request->section_id],['subject_id',$request->subject_id]])->get();
    }

    public function getImageList(Request $request)
    {
        return ShareScreenFiles::where([['file_type','image'],['staff_id',auth()->user()->id],['class',$request->class_id],['section_id',$request->section_id],['subject_id',$request->subject_id]])->get();
    }

    public function getVideoList(Request $request)
    {
        return ShareScreenFiles::where([['file_name','!=','null'],['file_type','videos'],['staff_id',auth()->user()->id]])->get();
    }

    function getYoutubeEmbedUrl($url){
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))(\w+)/i';

        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }

        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        return 'https://www.youtube.com/embed/' . $youtube_id ;
    }

    function DeleteDocument(Request $request){
        $Data['ShareScreenFiles'] = ShareScreenFiles::findorfail($request->value)->delete();
        $Data['status'] = 'success';
        $Data['message'] = 'Document deleted successfully';
        return response()->json($Data);
    }

    function DeleteImage(Request $request){
        $Data['ShareScreenFiles'] = ShareScreenFiles::findorfail($request->value)->delete();
        $Data['status'] = 'success';
        $Data['message'] = 'Image deleted successfully';
        return response()->json($Data);
    }

    function DeleteVideo(Request $request){
        $Data['ShareScreenFiles'] = ShareScreenFiles::findorfail($request->value)->delete();
        $Data['status'] = 'success';
        $Data['message'] = 'Video deleted successfully';
        return response()->json($Data);
    }
}
