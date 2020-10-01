<?php

namespace App\Http\Controllers\QuestionPaperManage;

use App\Http\Controllers\Controller;
use App\CreateQuestionPaper;
use App\CreatedQuestions;
use App\ExamInstructions;
use App\Segregation;
use App\QuestionTypes;
use App\PreparationTypes;
use App\Questions;
use App\QuestionPaperUi;
// use Response;
use Illuminate\Http\Response;
use App\AutomaticQuestionDetails;
use App\Chapter;
use App\AutomaticQuestion;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\Facades\DataTables;

class CreateQuestionPaperController extends Controller
{
    
    public function index()
    {
       
    }
	public function QuestionPaperLists(){
		 $data['QuestionPapers'] =CreateQuestionPaper::get();
		 return view('create_question_paper.view',$data);
	}
	public function CreateQuestionPaper(){
		$data['QuestionTypes'] = Questions::
								 leftJoin('question_types','question_types.id','=','questions.question_type_id')
								 ->groupBy('questions.question_type_id')
								 ->get();
		$data['chapters']=Chapter::get();
		$data['PreparationTypes']=PreparationTypes::get();
		$data['AutomaticQuestion'] = AutomaticQuestion::get();						 
			foreach($data['QuestionTypes'] as $key=>$value){
				$id=$value->id;
				$data['QuestionTypes'][$key]['segregations']=$this->GetQuestiontypeSegregations($id);
			}
			// print_r($data['QuestionTypes']);
		return view('create_question_paper.create',$data);
	}
	public function GetQuestiontypeSegregations($id){
		 return $segregations   = Segregation::where('question_type_id',$id)->get();
		
	}
	public function GetManualQuestions(Request $request){
		try {
		$preperation_type=$request->preperation_type;
				$CreateQuestionPaper =new CreateQuestionPaper;
				$CreateQuestionPaper->exam_name=$request->exam_qp_name;
				$CreateQuestionPaper->blue_print_name=$request->blue_print_name;
				$CreateQuestionPaper->save();
		$chapter_id=array();
		$selectedsegregation_id=array();
		foreach($request->chapters as $key=>$value){
		 $chapter_id[]=$value;
		}	 
		foreach($request->segregations as $key=>$segregations){
		 $selectedsegregation_id[]=$segregations;
		}
		
		$data['Segregations'] = Segregation::
								leftJoin('question_types','question_types.id','=','segregations.question_type_id')
								->whereIn('segregations.id',$selectedsegregation_id)
								->select('segregations.id as seg_id','segregations.*','question_types.*')
								->get()->toArray();
			foreach($data['Segregations'] as $key=>$segs){

				$segregation_id=$segs['seg_id'];
				$data['Segregations'][$key]['count']=getChapterSegregationPreperationTypeQuestionCount($chapter_id,$segregation_id);
				$data['Segregations'][$key]['questions']=$this->get_segregation_questions($segregation_id,$chapter_id,$preperation_type);
			}
			
			foreach($data['Segregations'] as $skey=>$value){
				foreach($value['questions'] as $qkey=>$questions){
					
					$store=StoreQuestions($questions['id'],$CreateQuestionPaper->id); //Question Paper Management
				}
			}
				$message['status']="success";
				$message['id']=$CreateQuestionPaper->id;
				$message['message']="Stored Successfully";
				return response()->json($message);
				}catch (Exception $e){
					return response()->json(['error'=>'Failed!']);
				}
		 // return view('create_question_paper.get_exam_questions',$data)->render();
		
				
	}
	
	public function get_segregation_questions($segregation_id,$chapter_id,$preperation_type){
		if($preperation_type==0){
			return  Questions::whereIn('chapter_id',$chapter_id)->where([['segregation_id',$segregation_id]])->get()->toArray();	
		}else{
			return  Questions::whereIn('chapter_id',$chapter_id)->where([['segregation_id',$segregation_id],['preparation_type_id',$preperation_type]])->get()->toArray();	
		}
		
	}
	public function GetAutomatedQuestions(Request $request){
		try {
				$blueprint_id= $request->blue_print_name;
				$CreateQuestionPaper =new CreateQuestionPaper;
				$CreateQuestionPaper->exam_name=$request->exam_qp_name;
				$CreateQuestionPaper->blue_print_name=$request->blue_print_name;
				$CreateQuestionPaper->save();
		$chapter_id=array();
		$selectedsegregation_id=array();
		foreach($request->chapters as $key=>$value){
		 $chapter_id[]=$value;
		}	 
		foreach($request->segregations as $key=>$segregations){
		 $selectedsegregation_id[]=$segregations;
		}
		  $data['Segregations'] = Segregation::
								  leftJoin('question_types','question_types.id','=','segregations.question_type_id')
								->leftJoin('questions','questions.segregation_id','=','segregations.id')
								->whereIn('segregations.id',$selectedsegregation_id)
								->select('segregations.id as seg_id','segregations.*','question_types.*')
								->groupBy('segregations.id')
								->get()->toArray();
			foreach($data['Segregations'] as $key=>$segs){

			$segregation_id=$segs['seg_id'];
			$Totalquestionscount=Questions::whereIn('chapter_id',$chapter_id)->where([['segregation_id',$segregation_id]])->count();
			$takenQuestions=getAutomtedSegregationQuestionCount($segregation_id,$chapter_id,$blueprint_id);
			$data['Segregations'][$key]['takenQuestions']=getAutomtedSegregationQuestionCount($segregation_id,$chapter_id,$blueprint_id);
			$data['Segregations'][$key]['questionsnos']=UniqueRandomNumbersWithinRange(0,$Totalquestionscount,$takenQuestions);
			$data['Segregations'][$key]['Questions']=Questions::whereIn('chapter_id',$chapter_id)->where([['segregation_id',$segregation_id]])->get()->toArray();
			}
			
			foreach($data['Segregations'] as $skey=>$value){
				foreach($value['Questions'] as $qkey=>$questions){
					
					$store=StoreQuestions($questions['id'],$CreateQuestionPaper->id); //Question Paper Management
				}
			}
				$message['status']="success";
				$message['id']=$CreateQuestionPaper->id;
				$message['message']="Stored Successfully";
					return response()->json($message);
				}catch (Exception $e){
					return response()->json(['error'=>'Failed!']);
				}
			 // return view('create_question_paper.get_automatic_questions',$data)->render();
	}
	
	// public function ShowQuestions(Request $request){
		 // try {
				// $CreateQuestionPaper =new CreateQuestionPaper;
				// $CreateQuestionPaper->exam_name=$request->exam_name;
				// $CreateQuestionPaper->blue_print_name=$request->blue_print_name;
				// $CreateQuestionPaper->save();
				
				// foreach($request->question_id as $key=>$question_id){
				// $selectedquestion_id[]=$question_id;
				// }
		
				// $QuestionsDetails = Questions::whereIn('id',$selectedquestion_id)->get();				
					// foreach($QuestionsDetails as $key=>$details){
						// $CreatedQuestions =new CreatedQuestions;
						// $CreatedQuestions->create_question_paper_id=$CreateQuestionPaper->id;
						// $CreatedQuestions->question_id=$details->id;
						// $CreatedQuestions->segregation_id=$details->segregation_id;
						// $CreatedQuestions->save();
					// }
					// $QuestionPaperUi=new QuestionPaperUi;
					// $QuestionPaperUi->create_question_paper_id=$CreateQuestionPaper->id;
					// $QuestionPaperUi->font_family="Times New Roman";
					// $QuestionPaperUi->font_size="14";
					// $QuestionPaperUi->line_spacing="20";
					// $QuestionPaperUi->question_spacing="20";
					// $QuestionPaperUi->save();
				// $data['status']="success";
				// $data['id']=$CreateQuestionPaper->id;
				// $data['message']="Stored Successfully";
				// return response()->json($data);
			 // }catch (Exception $e){
            // return response()->json(['error'=>'Failed!']);
        // }
	// }

	public function takenQuestions($segregation_id,$chapter_id,$blueprint_id){
		 	return $AutomaticQuestionDetails=  AutomaticQuestionDetails::whereIn('chapter_id',$chapter_id)
			->where([['segregation_id',$segregation_id],['automatic_question_id',$blueprint_id]])
			->sum('question_count');
	}

	public function ChapterBasedQuestionstore($id){
		$data['id']=$id;
		$data['PaperDetails']= CreateQuestionPaper::find($id);
		$data['ExamQuestions']= CreatedQuestions::
		where([['created_questions.create_question_paper_id',$id]])
		->leftJoin('segregations','segregations.id','=','created_questions.segregation_id')
		->groupBy('created_questions.segregation_id')
		->orderBy('created_questions.segregation_id','asc')
		->get()->toArray();
		foreach($data['ExamQuestions'] as $key=>$value){
			$segregation_id=$value['segregation_id'];
			$data['ExamQuestions'][$key]['questions']=$this->getQuestions($id,$segregation_id);
		}
		 return view('create_question_paper.store',$data);
	}

    public function getQuestions($id,$segregation_id){
		return CreatedQuestions::
		where([['created_questions.create_question_paper_id',$id],['created_questions.segregation_id',$segregation_id]])
		->leftJoin('questions','questions.id','=','created_questions.question_id')
		->get()->toArray();
	}
	public function StoreExamQuestionInstructions(Request $request){
			$CreateQuestionPaper = CreateQuestionPaper::findorfail($request->id);
            $CreateQuestionPaper->exam_time = $request->exam_time;
            $CreateQuestionPaper->subject = $request->subject;
            $CreateQuestionPaper->marks = $request->marks;
            $CreateQuestionPaper->main_note = $request->main_note;
            $CreateQuestionPaper->footer_note = $request->footer_note;
            $CreateQuestionPaper->save();		
		foreach($request->segregation_ids as $key=>$segregation_ids){ 
			foreach($request->secondary_note as $skey=>$secondary_notes){
				if($key == $skey)
				{
					$ExamInstructions =new ExamInstructions;
					$ExamInstructions->create_question_paper_id =$request->id;
					$ExamInstructions->segregation_id =$segregation_ids;
					$ExamInstructions->segregation_notes =$secondary_notes;
					$ExamInstructions->save();
				}
			}
		}
		
		return redirect('/question-paper-lists')->with('success','Exam Question Paper Added Successfully!');
	}
	public function UpdateExamQuestionInstructions(Request $request){
		$request->id;
			$CreateQuestionPaper = CreateQuestionPaper::findorfail($request->id);
            $CreateQuestionPaper->exam_name = $request->exam_name;
            $CreateQuestionPaper->exam_time = $request->exam_time;
            $CreateQuestionPaper->subject = $request->subject;
            $CreateQuestionPaper->marks = $request->marks;
            $CreateQuestionPaper->main_note = $request->main_note;
            $CreateQuestionPaper->footer_note = $request->footer_note;
            $CreateQuestionPaper->save();
		foreach($request->segregation_ids as $sskey=>$segregation_ids){ 
				  $ExamInstructionsDetails = ExamInstructions::where([['create_question_paper_id',$request->id],['id',$segregation_ids]])->get();
				 foreach ($ExamInstructionsDetails->pluck("id") as $key => $value) {
                           if($segregation_ids==$value){
							    $ExamInstructionsDetails = ExamInstructions::find($value);
								foreach($request->secondary_note as $skey=>$secondary_notes){
									if($skey==$value){
									$ExamInstructionsDetails->segregation_notes =$secondary_notes;
									$ExamInstructionsDetails->save();
									}
								}
                        }
		}	
		}	
		return redirect('/exam-question-edit/'.$request->id)->with('success','Paper Instructions Updated Successfully!');			
	}

	public function exam_questionpreview(Request $request){
		$data['id']=$request->id;
		$data['QuestionPaperUi']= QuestionPaperUi::where([['create_question_paper_id',$request->id]])->get()->first();
		$data['PaperDetails']= CreateQuestionPaper::find($request->id);
		$data['ExamQuestions']= CreatedQuestions::
		where([['created_questions.create_question_paper_id',$request->id]])
		->leftJoin('segregations','segregations.id','=','created_questions.segregation_id')
		->groupBy('created_questions.segregation_id')
		->orderBy('created_questions.segregation_id','asc')
		->get()->toArray();
		foreach($data['ExamQuestions'] as $key=>$value){
			$segregation_id=$value['segregation_id'];
			$data['ExamQuestions'][$key]['count']=$this->countQuestionsnew($request->id,$segregation_id);
			$data['ExamQuestions'][$key]['questions']=$this->getQuestionsnew($request->id,$segregation_id);
		}
		
	
		 return view('create_question_paper.preview',$data);
	}
	public function getPreviewDatas(Request $request){
		
		  $data['id']=$request->paper_id;
		  $data['QuestionPaperUi']= QuestionPaperUi::where([['create_question_paper_id',$request->paper_id]])->get()->first();
		$data['PaperDetails']= CreateQuestionPaper::find($request->paper_id);
		  $data['ExamQuestions']= CreatedQuestions::
		where([['created_questions.create_question_paper_id',$request->paper_id]])
		->leftJoin('segregations','segregations.id','=','created_questions.segregation_id')
		->groupBy('created_questions.segregation_id')
		->orderBy('created_questions.segregation_id','asc')
		->get()->toArray();
		foreach($data['ExamQuestions'] as $key=>$value){
			$segregation_id=$value['segregation_id'];
			$data['ExamQuestions'][$key]['count']=$this->countQuestionsnew($request->paper_id,$segregation_id);
			$data['ExamQuestions'][$key]['questions']=$this->getQuestionsnew($request->paper_id,$segregation_id);
		}
		// print_r($data['PaperDetails']);
		 return view('create_question_paper.previewQuestionData',$data)->render();
	}
	public function UpdateQuestionPaperUi(Request $request){
		$QuestionPaperUi= QuestionPaperUi::where([['create_question_paper_id',$request->question_paper_id]])->get();
		
			 $id=$QuestionPaperUi->pluck('id');
			$element=$request->element;
			$QuestionPaperUi=QuestionPaperUi::find($id[0]);
			$QuestionPaperUi->font_family=$request->font_family;
			$QuestionPaperUi->font_size=$request->font_size;
			$QuestionPaperUi->line_spacing=$request->line_height;
			$QuestionPaperUi->question_spacing=$request->question_space;
			$QuestionPaperUi->$element=$request->value;
			$QuestionPaperUi->save();
		
	}
	 public function downloadFile()
    {
    	
    }
	 public function getQuestionsnew($id,$segregation_id){
	  return $data['questions']=CreatedQuestions::
		where([['created_questions.create_question_paper_id',$id],['created_questions.segregation_id',$segregation_id],['status',0]])
		->leftJoin('questions','questions.id','=','created_questions.question_id')
		->select('created_questions.id as row_id','questions.*','created_questions.*')
		->get()->toArray();
	}
	
	public function countQuestionsnew($id,$segregation_id){
	  return $data['questions']=CreatedQuestions::
		where([['created_questions.create_question_paper_id',$id],['created_questions.segregation_id',$segregation_id],['status',0]])
		->leftJoin('questions','questions.id','=','created_questions.question_id')
		->select('created_questions.id as row_id','questions.*','created_questions.*')
		->count();
	}
	public function Getnewquestions(Request $request){
		$data['row_id']=$request->row_id;
		$question_paper_id=$request->question_paper_id;
		$segregation_id=$request->segregation_id;
		$chapter_id=$request->chapter_id;
		$Questions= CreatedQuestions::where([['create_question_paper_id',$question_paper_id],['segregation_id',$segregation_id]])->get();
		$questionids=array();
		foreach($Questions as $ques_ids){
			$questionids[]= $ques_ids->question_id;
		}
		$data['questions']= Questions::whereNotIn('id', $questionids)->where([['segregation_id',$segregation_id],['chapter_id',$chapter_id]])->get()->toArray();
		// print_r($otherquestions);
	  return response()->json($data);
	}
	public function StoreNewQuestion(Request $request){
		$CreatedQuestions = new CreatedQuestions;
		$CreatedQuestions->create_question_paper = $request->question_paper_id;
		$CreatedQuestions->question_id = $request->question_id;
		$CreatedQuestions->segregation_id = $request->segregation_id;
		$CreatedQuestions->save();
		
		$data=array(
		"status"=>"success",
		"message"=>"Added New Question"
		);
		 return response()->json($data);
	}
	public function ReplaceNewQuestion(Request $request){
		$CreatedQuestions = CreatedQuestions::findorfail($request->row_id);
            $CreatedQuestions->question_id = $request->question_id;
            $CreatedQuestions->save();
			$data=array(
				"status"=>"success",
				"message"=>"Question Replaced Successfully"
				);
				return response()->json($data);
	}
	public function Previewedit(Request $request){
			$paper_id= $request->paper_id;
			$operator= $request->submit;
			if($request->parent_row_id){			
				$CreatedQuestions=CreatedQuestions::find($request->parent_row_id)->toArray();
				if($operator=="RESET"){
					foreach($CreatedQuestions as $parentQe){
						foreach(unserialize($parentQe['parent_question_id']) as $parentQuestionIds){
						$questionids=$parentQuestionIds; //get unserialized question id
						$paper_id;
						$GetParentQueRowIds=CreatedQuestions::where([['question_id',$questionids],['create_question_paper_id',$paper_id]])->get()->toArray();
							foreach($GetParentQueRowIds as $rowid){
							$ids=$rowid['id'];
							$UpdatestatusQuestions=CreatedQuestions::find($ids);
							$UpdatestatusQuestions->status=0;
							$UpdatestatusQuestions->save();
							}
						}
						$Updateparent_question_id=CreatedQuestions::find($parentQe['id']);
						$Updateparent_question_id->parent_question_id='';
						$Updateparent_question_id->type='';
						$Updateparent_question_id->save();
					}
				}else{ // NOT RESET
					foreach($CreatedQuestions as $parentQe){
					$Updateparent_question_id=CreatedQuestions::find($parentQe['id']);
					$Updateparent_question_id->type=$operator;
					$Updateparent_question_id->save();
					}
				}
			}else{
				$rowids= $request->row_id;
				$id= array_values($rowids)[0];
				unset($rowids[$id]);
				$CreatedQuestions=CreatedQuestions::find($rowids)->toArray();
				// print_r($CreatedQuestions);
				foreach($CreatedQuestions as $q){
					$ids= $q['id'];
					$question_ids[]= $q['question_id'];
					$UpdatestatusQuestions=CreatedQuestions::find($ids);
					$UpdatestatusQuestions->status=1;
					$UpdatestatusQuestions->save();
				}
				$CreatedQuestions=CreatedQuestions::find($id);
				$CreatedQuestions->parent_question_id=serialize($question_ids);
				$CreatedQuestions->type=$operator;
				$CreatedQuestions->save();
			}
		return redirect('/exam-question-preview/'.$paper_id)->with('success','Exam Question Paper Updated Successfully!');
	}
	public function exam_questionedit(Request $request){
		$data['id']=$request->id;
		$data['PaperDetails']= CreateQuestionPaper::find($request->id);
		$data['ExamQuestions']= ExamInstructions::
		where([['exam_instructions.create_question_paper_id',$request->id]])
		->leftJoin('segregations','segregations.id','=','exam_instructions.segregation_id')
		->select('exam_instructions.id as instruction_id','segregations.*','exam_instructions.*')
		->get()->toArray();
		 return view('create_question_paper.edit',$data);
	}
	public function GetPrintData(Request $request){
		$data['value']=$request->value;
		$data['QuestionPaperUi']= QuestionPaperUi::where([['create_question_paper_id',$request->question_paper_id]])->get()->first();
		$data['PaperDetails']= CreateQuestionPaper::find($request->question_paper_id); 
		$data['ExamQuestions']= CreatedQuestions::
		where([['created_questions.create_question_paper_id',$request->question_paper_id]])
		->leftJoin('exam_instructions','exam_instructions.segregation_id','=','created_questions.segregation_id')
		->leftJoin('segregations','segregations.id','=','created_questions.segregation_id')
		->groupBy('created_questions.segregation_id')
		->orderBy('created_questions.segregation_id','asc')
		->get()->toArray();
		foreach($data['ExamQuestions'] as $key=>$value){
			$segregation_id=$value['segregation_id'];
			$data['ExamQuestions'][$key]['count']=$this->countQuestionsnew($request->question_paper_id,$segregation_id);
			$data['ExamQuestions'][$key]['questions']=$this->getQuestionsnew($request->question_paper_id,$segregation_id);
		}
		 return view('create_question_paper.print_new',$data);
	}
	public function QuestionPaperprint(Request $request){
		$id=$request->exam_id;
		$data['id']=$id;
		$data['PaperDetails']= CreateQuestionPaper::find($id);
		$data['ExamQuestions']= CreatedQuestions::
		where([['created_questions.create_question_paper_id',$id]])
		->leftJoin('exam_instructions','exam_instructions.segregation_id','=','created_questions.segregation_id')
		->leftJoin('segregations','segregations.id','=','created_questions.segregation_id')
		->groupBy('created_questions.segregation_id')
		->orderBy('created_questions.segregation_id','asc')
		->get()->toArray();
		foreach($data['ExamQuestions'] as $key=>$value){
			$segregation_id=$value['segregation_id'];
			$data['ExamQuestions'][$key]['questions']=$this->getQuestionsnew($id,$segregation_id);
		}
		// print_r($data['PaperDetails']);
		 return view('create_question_paper.print',$data)->render();
	}
	public function exam_questiondelete(Request $request){
		$id = $request->id;
		$ChapterBasedQuestion=CreateQuestionPaper::find($id)->delete();
		// $Staff = Staff::find($id)->delete();
		 return back()->with('success','Deleted Successfully!');
	}
    public function destroy(CreateQuestionPaper $createQuestionPaper)
    {
        //
    }
}
