<?php

namespace App\Http\Controllers\ManageQuestions;

use App\AutomaticQuestion;
use App\ClassSection;
use App\Subject;
use App\AutomaticQuestionChapters;
use App\AutomaticQuestionDetails;
use App\AutomaticQuestions;
use App\PreparationTypes;
use App\Segregation;
use App\Chapter;
use App\Questions;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AutomaticQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
	public function automatic_questions_view(){
	
		   if (request()->ajax()) {
            // if(auth()->user()->user_type == 'Staff'){
                // $AutomaticQuestions = AutomaticQuestion::where('prepared_staff_id',auth()->user()->user_id);
            // }else{
                $AutomaticQuestions = AutomaticQuestion::leftJoin('subjects','subjects.id','=','automatic_questions.subject_id')->select('automatic_questions.id as automatic_q_id','automatic_questions.*','subjects.*')->get();
            // }
            return DataTables::of($AutomaticQuestions)
                ->addIndexColumn()
                ->addColumn('action',
                    '<a href="{{route(\'editAutomaticQuestions\',[$automatic_q_id])}}" class="btn btn-xs btn-primary"><i class="fa fa-pencil text-aqua"></i>&nbsp; Edit</a>'
                )
                ->rawColumns(['action'])
                ->make(true);
        }
		 return view('manage_question.automtaic_questions.view');
	}
    public function AddAutomaticQuestion(){
        $data['PreparationTypes'] = PreparationTypes::get();
		$data['ClassSection'] = ClassSection::get()->unique('class');
        return view('manage_question.automtaic_questions.add',$data);
    }
	public function AutomaticQuestionstore(Request $request){
	   $AutomaticQuestion=new AutomaticQuestion();
       $AutomaticQuestion->name=$request->blue_print_name;
       $AutomaticQuestion->creating_type=$request->creating_type;
       $AutomaticQuestion->class=$request->class;
       $AutomaticQuestion->subject_id=$request->subject;
       $AutomaticQuestion->prepared_staff_id=auth()->user()->user_id;
       $AutomaticQuestion->preperation_type=$request->preparation_type_id;
	     $AutomaticQuestion->save();
	  foreach ($request->questions as $chapterkey => $segregarionDetails) {
            $AutomaticQuestionChapters = new AutomaticQuestionChapters;
            $AutomaticQuestionChapters->automatic_question_id = $AutomaticQuestion->id;
            $AutomaticQuestionChapters->chapter_id = $chapterkey;
            $AutomaticQuestionChapters->save();
            foreach ($segregarionDetails as $segregationkey => $PreparationTypes) {
                foreach ($PreparationTypes as $preparationkey => $PreparationType) {
                    $AutomaticQuestionDetails = new AutomaticQuestionDetails;
                    $AutomaticQuestionDetails->automatic_question_id = $AutomaticQuestion->id;
                    $AutomaticQuestionDetails->chapter_id = $chapterkey;
                    $AutomaticQuestionDetails->preparation_type_id = $preparationkey;
                    $AutomaticQuestionDetails->segregation_id = $segregationkey;
                    $AutomaticQuestionDetails->question_count = $PreparationType;
                    $AutomaticQuestionDetails->save();
                   
                }
            }
        }
        return redirect('question/add-automatic-questions')->with('success','Question Created Successfully');
	}

	public function editAutomaticQuestions(Request $request){
		// return  $request->id;
		$data['PreparationTypes'] = PreparationTypes::get();
        $data['AutomaticQuestions'] = AutomaticQuestion::where([['id',$request->id]])->get()->first();
		$data['class'] = $data['AutomaticQuestions']->class;
		$data['subject'] =Subject::where('id',$data['AutomaticQuestions']->subject_id)->get()->first();
		// print_r($data['subject']);
        $data['AutomaticQuestionChapters'] = AutomaticQuestionChapters::where('automatic_question_id',$request->id)->get();
        $preparation_id = $data['AutomaticQuestions']->preparation_type;
		$chapters=Chapter::where([['subject_id',$data['AutomaticQuestions']->subject_id],['class',$data['AutomaticQuestions']->class]])->get();
		$chapter_ids=array();
		foreach($chapters as $c){
			$chapter_ids[]=$c->id;
		}
		$preparation_id = $request->preparation_type_id;
        $data['Questions'] = Questions::whereIn('chapter_id',$chapter_ids)->get()->unique('chapter_id');
        $data['segregations'] = Segregation::get();
        if(0 == $preparation_id){
            $data['PreparationTypes'] = PreparationTypes::get();
            $data['PreparationTypeCount'] = PreparationTypes::get()->count();
        }else{
            $data['PreparationTypes'] = PreparationTypes::where('id',$preparation_id)->get();
            $data['PreparationTypeCount'] = PreparationTypes::where('id',$preparation_id)->get()->count();
        }
        return view('manage_question.automtaic_questions.edit',$data);
	}
	public function update(Request $request,$id){
	  $loop = 0;
        // print_r($request->chapter['chapter_id']); 
        DB::beginTransaction();
        $AutomaticQuestions = AutomaticQuestion::findorfail($id);
        $AutomaticQuestions->name = $request->blue_print_name;
       
        $AutomaticQuestions->creating_type = $request->creating_type;
        $AutomaticQuestions->prepared_staff_id = auth()->user()->user_id;
        $AutomaticQuestions->save();
        $AutomaticQuestionChapters = AutomaticQuestionChapters::where('automatic_question_id',$id)->get();
        if (!$AutomaticQuestionChapters->isEmpty()) {
            foreach ($AutomaticQuestionChapters->pluck("id") as $key => $value) {
                if (in_array($value, $request->chapter['chapter_id'])) {
                    $AutomaticQuestionChapters = AutomaticQuestionChapters::find($value);
                }else{
                    $AutomaticQuestionChapters = new AutomaticQuestionChapters;
                }
            }
        }else{
            $AutomaticQuestionChapters = new AutomaticQuestionChapters;
        }
        foreach ($request->questions as $chapterkey => $segregarionDetails) {
            if (isset($request->chapter['chapter_id'][$loop])) {
                $AutomaticQuestionChapters = AutomaticQuestionChapters::find($request->chapter['chapter_id'][$loop]);
            } else {
                $AutomaticQuestionChapters = new AutomaticQuestionChapters;
            }
            $loop++;
            $AutomaticQuestionChapters->automatic_question_id = $AutomaticQuestions->id;
            $AutomaticQuestionChapters->chapter_id = $chapterkey;
            $AutomaticQuestionChapters->save();
            foreach ($segregarionDetails as $segregationkey => $PreparationTypes) {
                foreach ($PreparationTypes as $preparationkey => $PreparationType) {
                    $AutomaticQuestionDetails = AutomaticQuestionDetails::where([['automatic_question_id',$id],['chapter_id',$chapterkey],['segregation_id',$segregationkey],['preparation_type_id',$preparationkey]])->get();
                    if (!$AutomaticQuestionDetails->isEmpty()) {
                        foreach ($AutomaticQuestionDetails->pluck("id") as $key => $value) {
                            if (in_array($value, $request->question['question_id'])) {
                                $AutomaticQuestionDetails = AutomaticQuestionDetails::find($value);
                            }else{
                                $AutomaticQuestionDetails = new AutomaticQuestionDetails;
                            }
                        }
                    }else{
                        $AutomaticQuestionDetails = new AutomaticQuestionDetails;
                    }
                    $AutomaticQuestionDetails->automatic_question_id = $AutomaticQuestions->id;
                    $AutomaticQuestionDetails->chapter_id =$chapterkey;
                    $AutomaticQuestionDetails->segregation_id = $segregationkey;
                    $AutomaticQuestionDetails->preparation_type_id = $preparationkey;
                    $AutomaticQuestionDetails->question_count = $PreparationType;
                    $AutomaticQuestionDetails->save();
                }
            }
        }
        DB::commit();
        return back()->with('success','Question Created Successfully');
        DB::rollBack();
	}
	public function getQuestionDetails(Request $request){
		$data['blue_print_name']=$request->blue_print_name;
        $data['creating_type']=$request->creating_type;
        $data['class']=$request->student_class;
        $data['subject_details']=$request->subject_details;
        $data['preparation_type_id']=$request->preparation_type_id;
		$chapters=Chapter::where([['subject_id',$request->subject_details],['class',$request->student_class]])->get();
		$chapter_ids=array();
		foreach($chapters as $c){
			$chapter_ids[]=$c->id;
		}
		$preparation_id = $request->preparation_type_id;
        $data['Questions'] = Questions::whereIn('chapter_id',$chapter_ids)->get()->unique('chapter_id');
        $data['segregations'] = Segregation::get();
        if(0 == $preparation_id){
            $data['PreparationTypes'] = PreparationTypes::get();
            $data['PreparationTypeCount'] = PreparationTypes::get()->count();
        }else{
            $data['PreparationTypes'] = PreparationTypes::where('id',$preparation_id)->get();
            $data['PreparationTypeCount'] = PreparationTypes::where('id',$preparation_id)->get()->count();
        }
	
		return view('manage_question.automtaic_questions.automatic_questions_datas',$data)->render();
	}
	public function GetSegregationTotal(Request $request){
		 $segregation_id = $request->segregation_id;
		 $currenVale = $request->currenVale;
		$total= getSegregationBasedMarks($segregation_id,$currenVale);
		$data=array(
		"total"=>$total
		);
			
		// return response()->json($data);
		return json_encode($data);
	}
	public function get_preperations($segration_id,$selectedpreperation_type_id ){
	
		$preperation_types= PreparationTypes::get()->toArray();
	
		foreach($preperation_types as $key=>$value){
			$preperation_type_id=$value['id'];
			$preperation_types[$key]['preperation_type_count']= getpreperationQuestionCount($segration_id,$preperation_type_id);		
		}
		
		return $preperation_types;
	}
	
   public function Validate_questions(Request $request){

        $preparation_type=$request->preparation_type_id;
        $segregation_id=$request->segregation_id;
        $taken_questions=$request->taken_questions;
	    if(empty($preperation_type)){
            $QuestionCount = Questions::where([['segregation_id',$segregation_id]])->count();
        }else{
            $QuestionCount = Questions::where([['segregation_id',$segregation_id],['preparation_type_id',$preperation_type]])->count();
        }
        if($taken_questions > $QuestionCount ){
            $Data['message']="error";

        }else{
            $Data['message']="success";

        }
		return response()->json($Data);
    }

}
