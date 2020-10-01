<?php

namespace App\Http\Controllers\master;

use App\Chapter;
use App\ChapterDetails;
use App\Http\Controllers\Controller;
use App\Staff;
use App\StaffSubjectAssign;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChapterController extends Controller
{
    public function getAllStaff(Request $request)
    {
        if ($request->ajax()) {
            $staff = Staff::all();
            return DataTables::of($staff)
                ->addIndexColumn()
                ->addColumn(
                    'action',
                    '<a href="staff_assigned_subject?id={{ $id }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-eye-open"></i>&nbsp; Subjects</a>'
                )
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.chapter.allstaff');
    }

    public function viewStafflist(Request $request)
    {
        if ($request->ajax()) {
            $staff = Staff::all();
            return DataTables::of($staff)
                ->addIndexColumn()
                ->addColumn(
                    'action',
                    '<a href="view_staff_subject?id={{ $id }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-eye-open"></i>&nbsp; Subjects</a>'
                )
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.chapter.view_all_staff');
    }

    public function staff_assigned_subject(Request $request)
    {
        if ($request->ajax()) {
            $StaffSubjectAssign = StaffSubjectAssign::where([['staff_id', request('staff_id')]])->get();
            return DataTables::of($StaffSubjectAssign)
                ->addIndexColumn()
                ->addColumn('subjects', function ($StaffSubjectAssign) {
                    return $StaffSubjectAssign->StaffSubject->subject_name;
                })
                ->addColumn('action',function($StaffSubjectAssign){
                    $chapter = Chapter::where('staff_subject_assign_id',$StaffSubjectAssign->id)->get()->count();
                    $btn = "";
                    if ($chapter>0) {
                        $btn .= '<span style="color:green">Already Added</span>';
                    }else{
                        $btn .= '<a href="add_chapter?id='.$StaffSubjectAssign->id.'" class="list-icons-item text-primary-600"><button type="button" class="btn btn-primary btn-sm">Add Chapter</button></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $data['staff_id'] = $request->id;
        return view('master.chapter.staffsubject', $data);
    }

    public function view_staff_subject(Request $request)
    {
        if ($request->ajax()) {
            $StaffSubjectAssign = StaffSubjectAssign::where([['staff_id', request('staff_id')]])->get();
            return DataTables::of($StaffSubjectAssign)
                ->addIndexColumn()
                ->addColumn('subjects', function ($StaffSubjectAssign) {
                    return $StaffSubjectAssign->StaffSubject->subject_name;
                })
                ->addColumn('action',function($StaffSubjectAssign){
                    $chapter = Chapter::where('staff_subject_assign_id',$StaffSubjectAssign->id)->get()->count();
                    $btn = "";
                    if ($chapter>0) {
                        $btn .= '<a href="view_chapter?id='.$StaffSubjectAssign->id.'" class="list-icons-item text-primary-600"><button type="button" class="btn btn-primary btn-sm">View Chapter</button></a>&nbsp';
                        $btn .= '<a href="edit_chapter?id='.$StaffSubjectAssign->id.'" class="list-icons-item text-primary-600"><button type="button" class="btn btn-primary btn-sm">Edit Chapter</button></a>';
                    }else{
                        $btn .= '<span style="color:green">No Chapter(s)</span>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $data['id'] = $request->id;
        return view('master.chapter.view_staff_subject', $data);
    }

    public function AddChapter(Request $request)
    {
        $data['id'] = $request->id;
		$StaffSubjectAssign = StaffSubjectAssign::where([['id', $request->id]])->get()->first();
		$data['class'] =$StaffSubjectAssign->class;
		$data['subject_id'] = $StaffSubjectAssign->StaffSubject->id;
        return view('master.chapter.add', $data);
    }

    public function SaveChapter(Request $request)
    {
        // return $request->all();
        DB::beginTransaction();
        try {
            if (request('unit')) {
                foreach ($request->unit['unit_number'] as $key => $values) {
                    $Chapter = new Chapter();
                    $Chapter->staff_subject_assign_id = $request->staff_subject_id;
                    $Chapter->subject_id = $request->subject_id;
                    $Chapter->class = $request->class;
                    $Chapter->unit_number = $request->unit['unit_number'][$key];
                    $Chapter->unit_name = $request->unit['unit_name'][$key];
                    $Chapter->unit_type = $request->unit['unit_type'][$key];
                    $Chapter->unit_from = $request->unit['unit_from'][$key];
                    $Chapter->unit_to = $request->unit['unit_to'][$key];
                    $Chapter->save();
                    if (request('chapter')) {
                        foreach ($request->chapter[$key]['chapter_number'] as $key1 => $values) {
                            $chapterDetails = new ChapterDetails();
                            $chapterDetails->chapter_id = $Chapter->id;
                            $chapterDetails->chapter_number = $request->chapter[$key]['chapter_number'][$key1];
                            $chapterDetails->chapter_name = $request->chapter[$key]['chapter_name'][$key1];
                            $chapterDetails->chapter_hours = $request->chapter[$key]['chapter_hours'][$key1];
                            $chapterDetails->chapter_from = $request->chapter[$key]['chapter_from'][$key1];
                            $chapterDetails->chapter_to = $request->chapter[$key]['chapter_to'][$key1];
                            $chapterDetails->save();
                        }
                    }
                }
            }
            DB::commit();
            return back()->with('success', 'Chapter Added Successfully');
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning', 'Chapter Cannot Be Added');
        }
    }

    public function EditChapter(Request $request)
    {
        $data['id'] = $request->id;
        $data['Chapters'] = Chapter::where('staff_subject_assign_id', $request->id)->get();
        return view('master.chapter.edit', $data);
    }

    public function ViewChapter(Request $request)
    {
        if ($request->id != '') {
            $data['id'] = $request->id;
            $data['Chapters'] = Chapter::where('staff_subject_assign_id', $request->id)->get();
            return view('master.chapter.view_chapter', $data);
        } else {
            return view('master.chapter.view_all_staff');
        }
    }

    public function UpdateChapter (Request $request)
    {

        DB::beginTransaction();
        try {
            if (!empty($request->unit)) {
                $Chapter = Chapter::where("staff_subject_assign_id", $request->staff_subject_id)->get();
                foreach ($Chapter->pluck("id") as $key => $value) {
                    if (in_array($value, $request->unit["unit_id"])) {
                        $Chapter = Chapter::findorfail($value);
                    }else{
                        $chapterDetailsdelete = ChapterDetails::where('chapter_id',$value)->delete();
                        $Chapterdelete = Chapter::findorfail($value)->delete();
                    }
                }
                foreach ($request->unit['unit_number'] as $unitkey => $values) {
                    if (isset($request->unit["unit_id"][$unitkey])) {
                        $Chapter = Chapter::findorfail($request->unit["unit_id"][$unitkey]);
                    } else {
                        $Chapter = new Chapter;
                    }
                    $Chapter->staff_subject_assign_id = $request->staff_subject_id;
                    $Chapter->unit_number = $request->unit['unit_number'][$unitkey];
                    $Chapter->unit_name = $request->unit['unit_name'][$unitkey];
                    $Chapter->unit_type = $request->unit['unit_type'][$unitkey];
                    $Chapter->unit_from = $request->unit['unit_from'][$unitkey];
                    $Chapter->unit_to = $request->unit['unit_to'][$unitkey];
                    $Chapter->save();
                    if (!empty($request->chapter)) {
                        $chapterDetailscount = ChapterDetails::where('chapter_id',$Chapter->id)->get()->count();
                        $chapterDetails = ChapterDetails::where('chapter_id',$Chapter->id)->get();
                        if($chapterDetailscount>0){
                            foreach ($chapterDetails->pluck("id") as $keys => $value) {
                                if(isset($request->chapter[$unitkey]["chapter_id"])){
                                    if (in_array($value, $request->chapter[$unitkey]["chapter_id"])) {
                                        $ChapterDetails = ChapterDetails::findorfail($value);
                                    }
                                }else{
                                    $ChapterDetails = ChapterDetails::findorfail($value)->delete();
                                }
                            }
                        }
                        if (isset($request->chapter[$unitkey]['chapter_number'])) {
                            foreach ($request->chapter[$unitkey]['chapter_number'] as $chapterkey => $values) {
                                if (isset($request->chapter[$unitkey]["chapter_id"][$chapterkey])) {
                                    $chapterDetails = ChapterDetails::findorfail($request->chapter[$unitkey]["chapter_id"][$chapterkey]);
                                } else {
                                    $chapterDetails = new ChapterDetails;
                                }
                                $chapterDetails->chapter_id = $Chapter->id;
                                $chapterDetails->chapter_number = $request->chapter[$unitkey]['chapter_number'][$chapterkey];
                                $chapterDetails->chapter_name = $request->chapter[$unitkey]['chapter_name'][$chapterkey];
                                $chapterDetails->chapter_hours = $request->chapter[$unitkey]['chapter_hours'][$chapterkey];
                                $chapterDetails->chapter_from = $request->chapter[$unitkey]['chapter_from'][$chapterkey];
                                $chapterDetails->chapter_to = $request->chapter[$unitkey]['chapter_to'][$chapterkey];
                                $chapterDetails->save();
                            }
                        }
                    }
                }
            }
            DB::commit();
            return back()->with('success','Chapter Updated Successfully');
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning','Chapter Cannot Be Updated');
        }
    }

}
