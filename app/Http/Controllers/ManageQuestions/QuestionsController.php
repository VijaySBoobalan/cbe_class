<?php

namespace App\Http\Controllers\ManageQuestions;

use App\Chapter;
use App\Http\Controllers\Controller;
use App\PreparationTypes;
use App\QuestionModel;
use App\Questions;
use App\QuestionTypes;
use App\QuestionYears;
use App\Segregation;
use App\StaffSubjectAssign;
use App\Years;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\Facades\DataTables;

class QuestionsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(auth()->user()->user_type == 'Staff'){
                $StaffSubjectAssign = StaffSubjectAssign::where('staff_id',auth()->user()->user_id);
            }else{
                $StaffSubjectAssign = StaffSubjectAssign::all();
            }
            return DataTables::of($StaffSubjectAssign)
                ->addIndexColumn()
                ->editColumn('subjects', function($StaffSubjectAssign){
                    return $StaffSubjectAssign->StaffSubject->subject_name;
                })
                ->addColumn('action',
                    '<a href="{{route(\'addnewQuestion\',[$id])}}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-plus"></i>&nbsp; Add Question</a>'
                )
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('manage_question.question.subject_details');
    }

    public function QuestionSubjects(Request $request)
    {
        if ($request->ajax()) {
            if(auth()->user()->user_type == 'Staff'){
                $StaffSubjectAssign = StaffSubjectAssign::where('staff_id',auth()->user()->user_id);
            }else{
                $StaffSubjectAssign = StaffSubjectAssign::all();
            }
            return DataTables::of($StaffSubjectAssign)
                ->addIndexColumn()
                ->editColumn('subjects', function($StaffSubjectAssign){
                    return $StaffSubjectAssign->StaffSubject->subject_name;
                })
                ->addColumn('action',
                    '<a href="{{route(\'QuestionView\',[$id])}}" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i>&nbsp; View Question</a>'
                )
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('manage_question.question.subject_view');
    }

    public function QuestionView(Request $request)
    {
        // if ($request->ajax()) {
            if(auth()->user()->user_type == 'Staff'){
                $data['Chapters'] = Chapter::
                where('staff_subject_assign_id',$request->id)
                // ->join('questions','questions.chapter_id','chapters.id')
                ->get();
                // ->groupBy('questions.question_type_id')->unique('questions.segregation_id');
            }else{
                $data['Chapters'] = Chapter::
                where('staff_subject_assign_id',$request->id)
                // ->join('questions','questions.chapter_id','chapters.id')
                ->get();
                // ->groupBy('questions.question_type_id')->unique('questions.segregation_id');
            }
            // return DataTables::of($Chapters)
            //     ->addIndexColumn()
            //     ->editColumn('chapter', function($Chapters){
            //         return $Chapters;
            //     })
            //     ->addColumn('action',
            //         '<a href="{{route(\'EditQuestion\',[$id])}}" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i>&nbsp; Edit Question</a>'
            //     )
            //     ->rawColumns(['action'])
            //     ->make(true);
        // }
        $data['id'] = $request->id;
        return view('manage_question.question.chapter_view',$data);
    }

    public function addQuestion(Request $request)
    {
        $data['staffSubjectAssignedId'] = $request->id;
        $data['Chapter'] = Chapter::where('staff_subject_assign_id',$request->id)->get();
        $data['QuestionTypes'] = QuestionTypes::get();
        $data['QuestionModel'] = QuestionModel::get();
        $data['PreparationTypes'] = PreparationTypes::get();
        $data['Years'] = Years::get();
        return view('manage_question.question.add',$data);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            if($request->question['question_name']){
                foreach ($request->question['question_name'] as $key => $question_name) {
                    $Questions = new Questions();
                    $Questions->chapter_id = $request->chapter_id;
                    $Questions->preparation_type_id = $request->preparation_type_id;
                    $Questions->question_type_id = $request->question_type_id;
                    $Questions->segregation_id = $request->segregation_id;
                    $Questions->question_name = $question_name;
                    if(isset($request->question[$key]['answer_option'])){
                        $Questions->answer_option = serialize($request->question[$key]['answer_option']);
                    }
                    $Questions->answer = serialize($request->question[$key]['answer']);
                    $Questions->save();
                    foreach ($request->question[$key]['year'] as $yearkey => $year) {
                        $QuestionYears = new QuestionYears();
                        $QuestionYears->question_id = $Questions->id;
                        $QuestionYears->chapter_id = $request->chapter_id;
                        $QuestionYears->preparation_type_id = $request->preparation_type_id;
                        $QuestionYears->question_type_id = $request->question_type_id;
                        $QuestionYears->segregation_id = $request->segregation_id;
                        $QuestionYears->year = $request->question[$key]['year'][$yearkey];
                        $QuestionYears->save();
                    }
                }
            }
            DB::commit();
            return back()->with('success', 'Questions Added Successfully');
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning', 'Questions Cannot Be Added');
        }
    }

    public function EditQuestion(Request $request)
    {
        $data['staffSubjectAssignedId'] = $request->staff_subject_assign_id;
        $data['chapter_id'] = $request->chapter_id;
        $data['preparation_type_id'] = $request->preparation_type_id;
        $data['question_type_id'] = $request->question_type_id;
        $data['segregation_id'] = $request->segregation_id;
        $data['Chapter'] = Chapter::where('staff_subject_assign_id',$request->staff_subject_assign_id)->get();
        $data['Questions'] = Questions::where([['chapter_id',$request->chapter_id],['preparation_type_id',$request->preparation_type_id],['question_type_id',$request->question_type_id],['segregation_id',$request->segregation_id]])->get();
        $data['QuestionTypes'] = QuestionTypes::get();
        $data['QuestionModel'] = QuestionModel::get();
        $data['PreparationTypes'] = PreparationTypes::get();
        $data['Years'] = Years::get();
        return view('manage_question.question.edit',$data);
    }

    public function QuestionUpdate(Request $request)
    {
        // return $request->all();
        DB::beginTransaction();
        try {
            if($request->question['question_name']){
                $Questions = Questions::where([['chapter_id',$request->chapter_id],['preparation_type_id',$request->preparation_type_id],['question_type_id',$request->question_type_id],['segregation_id',$request->segregation_id]])->get();
                foreach ($Questions->pluck("id") as $key => $value) {
                    if (in_array($value, $request->question["question_id"])) {
                        $Questions = Questions::findorfail($value);
                    }else{
                        $QuestionYearsdelete = QuestionYears::where('question_id',$value)->delete();
                        $Questionsdelete = Questions::findorfail($value)->delete();
                    }
                }
                foreach ($request->question['question_name'] as $key => $question_name) {
                    if (isset($request->question["question_id"][$key])) {
                        $Questions = Questions::findorfail($request->question["question_id"][$key]);
                    } else {
                        $Questions = new Questions;
                    }
                    $Questions->chapter_id = $request->chapter_id;
                    $Questions->preparation_type_id = $request->preparation_type_id;
                    $Questions->question_type_id = $request->question_type_id;
                    $Questions->segregation_id = $request->segregation_id;
                    $Questions->question_name = $question_name;
                    if(isset($request->question[$key]['answer_option'])){
                        $Questions->answer_option = serialize($request->question[$key]['answer_option']);
                    }
                    $Questions->answer = serialize($request->question[$key]['answer']);
                    $Questions->save();
                    if (!empty($request->question)) {
                        $QuestionYearscount = QuestionYears::where('question_id',$Questions->id)->get()->count();
                        $QuestionYears = QuestionYears::where('question_id',$Questions->id)->get();
                        if($QuestionYearscount>0){
                            foreach ($QuestionYears->pluck("id") as $keys => $value) {
                                if(isset($request->question[$key]["year"])){
                                    if (in_array($value, $request->question[$key]["year"])) {
                                        $QuestionYears = QuestionYears::findorfail($value);
                                    }
                                }else{
                                    $QuestionYears = QuestionYears::findorfail($value)->delete();
                                }
                            }
                        }
                        if (isset($request->question[$key]['year'])) {
                            foreach ($request->question[$key]['year'] as $yearkey => $year) {
                                if (isset($request->question[$key]["year_id"][$yearkey])) {
                                    $QuestionYears = QuestionYears::findorfail($request->question[$key]["year_id"][$yearkey]);
                                } else {
                                    $QuestionYears = new QuestionYears;
                                }
                                $QuestionYears->question_id = $Questions->id;
                                $QuestionYears->chapter_id = $request->chapter_id;
                                $QuestionYears->preparation_type_id = $request->preparation_type_id;
                                $QuestionYears->question_type_id = $request->question_type_id;
                                $QuestionYears->segregation_id = $request->segregation_id;
                                $QuestionYears->year = $request->question[$key]['year'][$yearkey];
                                $QuestionYears->save();
                            }
                        }
                    }
                }
            }
            DB::commit();
            return redirect(URL::to('/').'/questions/view-chapter/'.$request->staffSubjectAssignedId)->with('success', 'Questions Added Successfully');
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning', 'Questions Cannot Be Added');
        }
    }

    public function ViewQuestion(Request $request)
    {
        $data['Questions'] = Questions::where('chapter_id',$request->id)->groupBy(['preparation_type_id','question_type_id','segregation_id'])->get();
        return view('manage_question.question.question_view',$data);
    }

    public function QuestionDetails (Request $request)
    {
        $data['Questions'] = Questions::where([['chapter_id',$request->chapter_id],['preparation_type_id',$request->preparation_type_id],['question_type_id',$request->question_type_id],['segregation_id',$request->segregation_id]])->get();
        return view('manage_question.question.question_details',$data);
    }

    public function getSegregation(Request $request)
    {
        return Segregation::where('question_type_id',$request->question_type_id)->get();
    }

}
