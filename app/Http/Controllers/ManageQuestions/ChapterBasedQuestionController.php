<?php

namespace App\Http\Controllers\ManageQuestions;

use App\ChapterBasedQuestion;
use App\ChapterBasedQuestionDetails;
use App\ChapterQuestionInstructions;
use App\ClassSection;
use App\Chapter;
use App\Subject;
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

class ChapterBasedQuestionController extends Controller
{
   
    public function index()
    {
        //
    }
	
	 public function ChapterBasedQuestion(){
		$data['ClassSection']=ClassSection::get();
		$data['chapters']=Chapter::get()->toArray();
		  foreach($data['chapters'] as $key=>$chapters){
			  $chapter_id=$chapters['id'];
			  $data['chapters'][$key]['count']= Questions::where([['chapter_id',$chapter_id]])->count();	
		  }
		 
        return view('manage_question.chapter_based_questions.chapter_based_view',$data);
	}
	public function getSubjectChapterList(Request $request){
			$data['class_id'] =$request->class_id;
			$data['Subject'] = Subject::where('id',$request->id)->get()->first();
			$data['chapters']=Chapter::where('subject_id',$request->id)->get()->toArray();
		  foreach($data['chapters'] as $key=>$chapters){
			  $chapter_id=$chapters['id'];
			  $data['chapters'][$key]['count']= Questions::where([['chapter_id',$chapter_id]])->count();	
		  }
		 return view('manage_question.chapter_based_questions.subject_chapter_based_view',$data); 
	}
	public function ChapterQuestionDetails(Request $request){
		$id=$request->id;
		$data['class_id']=$request->class_id;
		$data['Chapters'] = Chapter::find($id);
		 
        $data['Segregations'] = Segregation::get();
        // $data['Questions'] = Questions::where('chapter_id',$id)->get();
		return view('manage_question.chapter_based_questions.chapter_questions',$data);
	}
	
	  public function prepareQuestion(Request $request)
    {
        $data['ClassSection'] = ClassSection::get()->unique('class')->toArray();
		$data['class_id'] = $request->class_id;
		$data['pattern_prefix'] = $request->pattern_prefix;
		$data['chapter_questions'] = $request->chapter_question;
		$data['chapter_id'] = $request->chapter_id;	
        return view('manage_question.chapter_based_questions.question_prepare',$data)->render();
    }
	public function changeQuestion(Request $request){
		$data['selected_question_id'] = $request->question_id;
		$data['row_id'] = $request->row_id;
		$segregation_id = $request->segregation_id;
		$chapter_id = $request->chapter_id;
		$chapterQuestionsid = $request->chapterQuestionsid;		
		$Questions= ChapterBasedQuestionDetails::where([['chapter_based_question_id',$chapterQuestionsid],['segregation_id',$segregation_id]])->get();
		$questionids=array();
		foreach($Questions as $ques_ids){
			$questionids[]= $ques_ids->question_id;
		}
		
		$data['questions']= Questions::whereNotIn('id', $questionids)->where([['segregation_id',$segregation_id],['chapter_id',$chapter_id]])->get()->toArray();
		// print_r($otherquestions);
	  return response()->json($data);
	}
	public function replaceQuestion(Request $request){
		$question_id = $request->question_id;
		$removing_question_id = $request->removing_question_id;
		$chapter_based_id = $request->chapter_based_id;
		// $update=DB::table('chapter_based_question_details')->where('id', $removing_question_id)->update(['question_id'],$question_id);
		$update= DB::update('update chapter_based_question_details set question_id = ? where id = ?',[$question_id,$removing_question_id]);		
		$data['message']="Succesfully replaced";
		
		$chapterQuestions= ChapterBasedQuestionDetails::
		where([['chapter_based_question_id',$chapter_based_id]])
		->leftJoin('segregations','segregations.id','=','chapter_based_question_details.segregation_id')
		->groupBy('segregation_id')
		->select('chapter_based_question_details.id as row_id','chapter_based_question_details.*','segregations.*')
		->get();
		$html="";
		$html="<div class='newchanged'>";
		
		foreach($chapterQuestions as $key=>$value){
			$html .= "<div class='dynsegregations'>";
			$html .="<p>" .$segregation_name= $value->segregation."</p>";
			 $segregation_id= $value->segregation_id;
			$questions= ChapterBasedQuestionDetails::
			where([['chapter_based_question_details.segregation_id',$segregation_id],['chapter_based_question_id',$chapter_based_id]])
			->leftJoin('chapter_based_questions','chapter_based_questions.id','=','chapter_based_question_details.chapter_based_question_id')
			->leftJoin('questions','questions.id','=','chapter_based_question_details.question_id')
			->get();
			foreach($questions as $q){
				$html .='<a ="#" data-chapter_id="'.$q->chapter_id .'"data-chapterQuestionsid="'.$value->chapter_based_question_id .'"data-row_id="'.$value->row_id .'"data-segregation_id="'.$segregation_id .'"data-question_id="'.$value->question_id .'"data-toggle="modal" data-target="#QuestionsList"class="btn btn-sm btn-success change_question"style="float:right">Change</a>';
				$html .= $q->question_name;
				if($q->answer_option){
				foreach(unserialize($q->answer_option) as $key2 => $Que){
                            $html .="<span> <b>(*)</b> </span>)". strip_tags($Que) ;
				}
				}
			}
			$html .= "</div>";
		}
		$html .= "</div>";
		echo $html;
		// return response()->json($data);
	}
	public function addQuestion(Request $request){
		
		$newQuestion = new ChapterBasedQuestionDetails;
		$newQuestion->chapter_based_question_id = $request->chapter_based_id;
		$newQuestion->segregation_id = $request->segregation_id;
		$newQuestion->question_id =  $request->question_id;
		$newQuestion->save();
		$chapterQuestions= ChapterBasedQuestionDetails::
		where([['chapter_based_question_id',$request->chapter_based_id]])
		->leftJoin('segregations','segregations.id','=','chapter_based_question_details.segregation_id')
		->groupBy('segregation_id')
		->select('chapter_based_question_details.id as row_id','chapter_based_question_details.*','segregations.*')
		->get();
		$html="";
		$html="<div class='newchanged'>";
		
		foreach($chapterQuestions as $key=>$value){
			$html .= "<div class='dynsegregations'>";
			$html .="<p>" .$segregation_name= $value->segregation."</p>";
			 $segregation_id= $value->segregation_id;
			$questions= ChapterBasedQuestionDetails::
			where([['chapter_based_question_details.segregation_id',$segregation_id],['chapter_based_question_id',$request->chapter_based_id]])
			->leftJoin('chapter_based_questions','chapter_based_questions.id','=','chapter_based_question_details.chapter_based_question_id')
			->leftJoin('questions','questions.id','=','chapter_based_question_details.question_id')
			->get();
			foreach($questions as $q){
				$html .='<a ="#" data-chapter_id="'.$q->chapter_id .'"data-chapterQuestionsid="'.$value->chapter_based_question_id .'"data-row_id="'.$value->row_id .'"data-segregation_id="'.$segregation_id .'"data-question_id="'.$value->question_id .'"data-toggle="modal" data-target="#QuestionsList"class="btn btn-sm btn-success change_question"style="float:right">Change</a>';
				$html .= $q->question_name;
				if($q->answer_option){
				foreach(unserialize($q->answer_option) as $key2 => $Que){
                            $html .="<span> <b>(*)</b> </span>)". strip_tags($Que) ;
				}
				}
			}
			$html .= "</div>";
		}
		$html .= "</div>";
		echo $html;
	}
	public function Question_instructions(Request $request){
		$ChapterQuestionInstructions=new ChapterQuestionInstructions;
		$ChapterQuestionInstructions->chapter_based_question_id=$request->chapter_question_id;
		$ChapterQuestionInstructions->school_name=$request->schoolname;
		$ChapterQuestionInstructions->class_id=$request->class_id;
		$ChapterQuestionInstructions->hours=$request->hours;
		$ChapterQuestionInstructions->marks=$request->marks;
		$ChapterQuestionInstructions->date=$request->date;
		$ChapterQuestionInstructions->instructions=$request->instructions;
		$ChapterQuestionInstructions->save();
		$data['message']="Details Succesfully saved";
		$data['status']="success";
		 return response()->json($data);
	}
	
    public function ChapterQuestionStore(Request $request)
    {	
	 $Segregations = Segregation::get();
	 // foreach($Segregations as $s){
		 // echo $s->QuestionTypes->question_type;
	 // }
		
		$ChapterBasedQuestions =new ChapterBasedQuestion;
		$ChapterBasedQuestions->pattern_prefix =$request->pattern_prefix;
		$ChapterBasedQuestions->chapter_id =$request->chapter_id;
		
		$ChapterBasedQuestions->save;
    }
	public function ChapterBasedQuestionList(){
		$data['chapter_questions'] = ChapterBasedQuestion::leftJoin('chapters','chapters.id','=','chapter_based_questions.chapter_id')
									->leftJoin('subjects','subjects.id','=','chapters.subject_id')
									->select('chapter_based_questions.id as chapter_q_id','chapters.*','chapter_based_questions.*','subjects.*')
									->get();
				foreach($data['chapter_questions'] as $key=>$patterns){
				 $id=$patterns->chapter_q_id;
				 $data['chapter_questions'][$key]['details']= ChapterBasedQuestionDetails::
		where([['chapter_based_question_id',$id]])
		->leftJoin('segregations','segregations.id','=','chapter_based_question_details.segregation_id')
		->groupBy('segregation_id')
		->select('chapter_based_question_details.*','segregations.segregation')
		->get();
		$data['segregations']=Segregation::get();
		foreach($data['chapter_questions'][$key]['details'] as $detailkey=>$segregation_details){
			$segregation_id= $segregation_details->segregation_id;
			$data['chapter_questions'][$key]['details'][$detailkey]['questions']=getpreperationQuestionStored($id,$segregation_id);
		}	
				}	
								
				// print_r($data['chapter_questions']);		
		 return view('manage_question.chapter_based_questions.chapter_question_list',$data);				
	}
	public function ChapterBasedQuestionedit(Request $request){
		$data['id'] = $request->id;
		$id = $request->id;
		$chapter_id= $request->chapter_id;
		$data['ClassSection'] = ClassSection::get()->unique('class')->toArray();
		$data['ChapterBasedQuestion'] = ChapterBasedQuestion::find($id);
		$data['QuestionInstructions'] = ChapterQuestionInstructions::where('chapter_based_question_id',$id)->get()->first()->toArray();
		$data['Chapters'] = Chapter::find($chapter_id); 
        $data['Segregations'] = Segregation::get();
        $data['chapterQuestions']= ChapterBasedQuestionDetails::
		where([['chapter_based_question_id',$id]])
		->leftJoin('segregations','segregations.id','=','chapter_based_question_details.segregation_id')
		->groupBy('segregation_id')
		->select('chapter_based_question_details.id as row_id','chapter_based_question_details.*','segregations.*')
		->get()->toArray();
		return view('manage_question.chapter_based_questions.editchapter_questions',$data);
	}
	public function ChapterquestioneditSegregation(Request $request){
		 $id=$request->id;
		
		 $data['chapterQuestions']= ChapterBasedQuestionDetails::
		where([['chapter_based_question_id',$id],['chapter_based_question_details.segregation_id',$request->segregationId]])
		->leftJoin('segregations','segregations.id','=','chapter_based_question_details.segregation_id')
		->leftJoin('questions','questions.id','=','chapter_based_question_details.question_id')
		->select('chapter_based_question_details.id as row_id','questions.*','chapter_based_question_details.*','segregations.*')
		->get();
		return view('manage_question.chapter_based_questions.editsegregation_questions',$data);
	}
	public function ChapterBasedQuestionpreview(Request $request){
		
		$data['id'] = $request->id;
		$id = $request->id;
		$chapter_id= $request->chapter_id;
		$data['ClassSection'] = ClassSection::get()->unique('class')->toArray();
		$data['ChapterBasedQuestion'] = ChapterBasedQuestion::find($id);
		$data['QuestionInstructions'] = ChapterQuestionInstructions::where('chapter_based_question_id',$id)->get()->first()->toArray();
		$data['Chapters'] = Chapter::find($chapter_id); 
        $data['Segregations'] = Segregation::get();
        $data['chapterQuestions']= ChapterBasedQuestionDetails::
		where([['chapter_based_question_id',$id]])
		->leftJoin('segregations','segregations.id','=','chapter_based_question_details.segregation_id')
		->groupBy('segregation_id')
		->select('chapter_based_question_details.id as row_id','chapter_based_question_details.*','segregations.*')
		->get();
		return view('manage_question.chapter_based_questions.perviewchapter_questions',$data)->render();
	}
	public function UpdateChapterbaseddetails(Request $request){
		// echo "hai";
		 $ChapterBasedQuestion = ChapterBasedQuestion::find($request->id);
        $ChapterBasedQuestion->pattern_prefix = $request->pattern_prefix;
        $ChapterBasedQuestion->save();
		$update= DB::update('update chapter_question_instructions set school_name = ? ,class_id = ? ,hours = ? ,marks = ? ,	date = ? , instructions = ? where id = ?',[$request->schoolname,$request->class_id,$request->hours,$request->marks,$request->date,$request->instructions,$request->id]);		

		return redirect('/chapter-question-list')->with('success','Details Updated Successfully!');
		 }
	public function ChapterBasedQuestiondelete($id){
	
		$ChapterBasedQuestion=ChapterBasedQuestion::find($id)->delete();
		// $Staff = Staff::find($id)->delete();
		 return back()->with('success','Deleted Successfully!');
	}
}
