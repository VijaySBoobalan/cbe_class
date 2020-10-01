<?php

namespace App\Http\Controllers\ExamManagement;

use App\Http\Controllers\Controller;
use App\ExamManagement;
use App\ExamManagementQuestions;
use App\StudentAnswer;
use App\PreparationTypes;
use App\Questions;
use App\Segregation;
use App\Subject;
use App\Chapter;
use App\Batch;
use App\Batchstudents;
use App\AlloctedExamBatch;
use App\AlloctedExamBatchStudents;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\Facades\DataTables;

class ExamManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('exam_management.view');
    }
	public function Exams($id){
		$data['id'] = $id;
		$data['Exams']=ExamManagement::where([['exam_type_id',$id]])->get();
		foreach($data['Exams'] as $key=>$Exam_details){
			$exam_id=$Exam_details->id;
			$data['Exams'][$key]['question_count']=ExamManagementQuestions::where('exam_management_id',$exam_id)->count();
			$data['Exams'][$key]['reports']=StudentAnswer::where('exam_id',$exam_id)->leftJoin('users','users.id','=','student_answers.student_id')->groupBy('student_id')->get();
		}
		 return view('exam_management.exams_view',$data);
	}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CreateExam($id)
    {
		$data['id'] = $id;
		$data['Subject']=Subject::get();
		$data['Chapter']=Chapter::get();
		$data['PreparationTypes']=PreparationTypes::get();
       return view('exam_management.exam_form',$data);
    }
	public function ViewExamReport($id){
		  $data['Exams']=ExamManagement::where([['exam_management.id',$id]])
						->leftJoin('allocted_exam_batches','allocted_exam_batches.exam_id','=','exam_management.id')
						->leftJoin('batches','batches.id','=','allocted_exam_batches.batch_id')
						->select('batches.*','allocted_exam_batches.id as allcocated_batch_id','allocted_exam_batches.*','exam_management.*')
						->get();
						
						foreach($data['Exams'] as $key =>$exam_details){
							 $allcocated_batch_id=$exam_details['allcocated_batch_id'];
							$data['Exams'][$key]['batch_students']=AlloctedExamBatchStudents::where('allocted_exam_batche_id',$allcocated_batch_id)
																	->leftJoin('users','users.id','=','allocted_exam_batch_students.student_id')
																	->get();									
						}
						// print_r($data['Exams']);
		  return view('exam_management.exam_report',$data);
	}
	public function get_chapters(Request $request){
		// echo $request->subject_id;
		$data['subjects']=Subject::where([['subjects.id',$request->subject_id]])
						->get();
						foreach($data['subjects'] as $key=>$sub){
							$subject_id=$sub->id;
							$data['subjects'][$key]['subjectChapters']=Chapter::where([['subject_id',$subject_id]])->get();
						}
		return view('exam_management.subject_chapters_list',$data)->render();
	}
	
	public function AllocateExam($id){
		
		$data['exam_id'] =$id;
		$data['batches'] = Batch::get()->toArray();
		$data['ExamDetails']=ExamManagement::where([['id',$id]])->get()->first();
		// print_r($data['batches']);
		return view('exam_management.allocate_exam',$data);
	}
	public function get_batch_students(Request $request){
		$data['getBatch']=Batch::where([['id',$request->batch_id]])->get()->first();
		$data['studentlist'] =Batchstudents::where([['batch_id',$request->batch_id]])
							   ->leftJoin('users','users.id','=','batchstudents.student_id')
							   ->get();
							   // print_r($data['getBatch']);
							   // return response()->json($data);
		return view('exam_management.get_batch_student_list',$data)->render();
	}
	public function StoreAllocations(Request $request){
		
		 DB::beginTransaction();
        try {
		foreach($request->batchdetails['batch_id'] as $key=>$value){
				
				$AlloctedExamBatch = new AlloctedExamBatch;
				$AlloctedExamBatch->exam_id = $request->exam_id; 
				$AlloctedExamBatch->batch_id = $request->batchdetails['batch_id'][$key]; 
				$AlloctedExamBatch->from_date = $request->batchdetails['start_date'][$key]; 
				$AlloctedExamBatch->to_date = $request->batchdetails['end_date'][$key]; 
				$AlloctedExamBatch->password = $request->batchdetails['password'][$key];
				$AlloctedExamBatch->save(); 	
				
			
			foreach($request->batchdetails['students'][$value] as $skey=>$students){
				// echo $students;
				$AlloctedExamBatchStudents = new AlloctedExamBatchStudents;
				$AlloctedExamBatchStudents->allocted_exam_batche_id = $AlloctedExamBatch->id; 
				$AlloctedExamBatchStudents->student_id = $students; 
				$AlloctedExamBatchStudents->save();
			}			
		}
		DB::commit();
            return back()->with('success', 'Exam Allocted Successfully');
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning', 'Exam Alloction Failed');
        }		
		
	}
	
	public function getExamQuestions(Request $request){
		$data['id']= $request->id;
		$data['exam_name']= $request->exam_name;
		$data['exam_time']= $request->exam_time;
		$data['question_from']= $request->question_from;
		$data['preperation_type_id']= $request->preperation_type_id;
		$data['SegregationQuestions']=Questions::whereIn('chapter_id',$request->chapters)
									  ->leftJoin('segregations','segregations.id','=','questions.segregation_id')
									  ->groupBy('segregation_id')->select('segregations.*')
									  ->get();
		foreach($data['SegregationQuestions'] as $key=>$seg){
			$segregation_id=$seg->id;
			$data['SegregationQuestions'][$key]['questions']=Questions::whereIn('chapter_id',$request->chapters)->where([['segregation_id',$segregation_id]])->get();
		}
		// print_r($data['SegregationQuestions']);
		return view('exam_management.get_questions',$data)->render();
	}
	
	public function storeExamQuestions(Request $request){
		 try {
				$ExamManagement =new ExamManagement;
				$ExamManagement->exam_name=$request->exam_name;
				$ExamManagement->question_from=$request->question_from;
				$ExamManagement->exam_type_id=$request->id;
				$ExamManagement->preperation_type_id=$request->preperation_type_id;
				$ExamManagement->exam_hours=$request->exam_time;
				$ExamManagement->save();
				// echo $ExamManagement->id;
		foreach($request->questions as $key=>$question_id){
			$selectedquestion_id[]=$question_id;
		}
		$QuestionsDetails = Questions::whereIn('id',$selectedquestion_id)->get();		
		foreach($QuestionsDetails as $key=>$details){
			$ExamManagementQuestions =new ExamManagementQuestions;
			$ExamManagementQuestions->exam_management_id =$ExamManagement->id;
			$ExamManagementQuestions->question_id=$details->id;
			$ExamManagementQuestions->segregation_id=$details->segregation_id;
			$ExamManagementQuestions->save();
		}
				$data['id']=$request->id;
				$data['message']="Exam Stored Successfully";
				return response()->json($data);
		 }catch (Exception $e){
            return response()->json(['error'=>'Failed!']);
        }
	}
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExamManagement  $examManagement
     * @return \Illuminate\Http\Response
     */
    public function show(ExamManagement $examManagement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExamManagement  $examManagement
     * @return \Illuminate\Http\Response
     */
    public function edit(ExamManagement $examManagement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExamManagement  $examManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExamManagement $examManagement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExamManagement  $examManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamManagement $examManagement)
    {
        //
    }
}
