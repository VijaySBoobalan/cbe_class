<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Questions;
use App\User;
use App\StudentExam;
use App\ExamManagement;
use App\StudentAnswer;
use App\Segregation;
use App\ExamManagementQuestions;
use App\AlloctedExamBatch;
use App\AlloctedExamBatchStudents;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\Facades\DataTables;

class StudentExamController extends Controller
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

    public function write_test(){
		
		$data['Exams'] = AlloctedExamBatchStudents::where([['student_id',auth()->user()->id]])
						 ->leftJoin('allocted_exam_batches','allocted_exam_batches.id','=','allocted_exam_batch_students.allocted_exam_batche_id')
						 ->leftJoin('exam_management','exam_management.id','=','allocted_exam_batches.exam_id')
						->get();
						// print_r($data['Exams']);
		return view('student.exam.exam_lists',$data);
	}
	public function checkpassword(Request $request){
		$inputpassword= $request->password;
		$request->exam_id;
		$AlloctedExamBatch = AlloctedExamBatch::where([['id',$request->exam_id]])->get()->first();
		if($AlloctedExamBatch->password == $request->password){
	   $Data['id'] = $AlloctedExamBatch->exam_id;
	   $Data['status'] = 'success';
       $Data['message'] = 'Password Matched';
      
		}else{
			$Data['status'] = 'failed';
       $Data['message'] = 'Password Mismatched';
		}
		 return response()->json($Data);
	}
	public function start_exam($id){
		$data['Exam_id']= $id;
		$data['Exam']=ExamManagement::where([['exam_management.id',$id]])
					   ->leftJoin('allocted_exam_batches','allocted_exam_batches.exam_id','=','exam_management.id')
					  ->get()->first();
		$data['question']=ExamManagementQuestions::where([['exam_management_id',$id]])
							 ->leftJoin('questions','questions.id','=','exam_management_questions.question_id')
							 ->leftJoin('segregations','segregations.id','=','questions.segregation_id')
							->select('questions.id as q_id','questions.*','segregations.*','exam_management_questions.*')
							->get()->toArray();
							// echo "<pre>";
							// print_r($data['Exam']);
								// echo "<pre>";
		return view('student.exam.start_exam',$data);
	}
	// public function JumptoQuestion(Request $request){
	
		// $data['question']=ExamManagementQuestions::where([['exam_management_id',$request->Exam_id]])
							 // ->leftJoin('questions','questions.id','=','exam_management_questions.question_id')
							 // ->leftJoin('segregations','segregations.id','=','questions.segregation_id')
							 // ->select('questions.id as q_id','questions.*','segregations.*','exam_management_questions.*')
							// ->get()->toArray();
						
							
		// $data['Exam_id']=$request->Exam_id;
		// print_r($data['question']);
				// return view('student.exam.question_form',$data)->render();
	// }
	
	public function submitAnswer(Request $request){
		
		$StudentAnswersubmit= StudentAnswer::where([['exam_id',$request->Exam_id],['question_id',$request->question_id],['student_id',auth()->user()->id]])->get()->first();
		 if (!empty($StudentAnswersubmit)) {
			// print_r($StudentAnswersubmit);
			// echo $StudentAnswersubmit->id;
			$StudentAnswer = StudentAnswer::find($StudentAnswersubmit->id);
			$StudentAnswer->studentanswer	=$request->answer;
			$StudentAnswer->save();
		 }else{
		$StudentAnswer =new StudentAnswer;
		$StudentAnswer->exam_id=$request->Exam_id;
		$StudentAnswer->question_id=$request->question_id;
		$StudentAnswer->student_id=auth()->user()->id;
		$StudentAnswer->studentanswer	=$request->answer;
		$StudentAnswer->save();
		 }
	}
	public function FinishExam(Request $request){
		$exam_id =$request->Exam_id;
		$AlloctedExamBatch =AlloctedExamBatch::where([['exam_id',$exam_id]])->get()->first();
	    $allocatedbatch_id=$AlloctedExamBatch->pluck('id');
		$AlloctedExamBatchStudents=AlloctedExamBatchStudents::where([['student_id',auth()->user()->id],['allocted_exam_batche_id',$allocatedbatch_id]])->get();
			foreach($AlloctedExamBatchStudents->pluck('id') as $id){
				$updateStatus = AlloctedExamBatchStudents::find($id);
				$updateStatus->status=1;
				$updateStatus->save();
			}
		$data['status']  = "success";
		$data['message'] = "Exam Completed Successfully";
		// return json_encode($data);
		return response()->json($data);	
	}
	public function Viewstudent_answer(Request $request){
		$data['exam_id']=$request->exam_id;
		$data['student_details']=User::where('users.id',$request->student_id)
								 ->leftJoin('students','students.id','=','users.user_id')
								 ->leftJoin('class_sections','class_sections.id','=','students.section_id')
								 ->select('users.id as student_id','students.*','class_sections.*')
								->get()->first();
		$data['segregations'] = ExamManagementQuestions::where([['exam_management_id',$request->exam_id]])
								->leftJoin('segregations','segregations.id','=','exam_management_questions.segregation_id')
								->groupBy('segregation_id')
								->get();
								
		$data['question']=ExamManagementQuestions::where([['exam_management_id',$request->exam_id]])
							 ->leftJoin('questions','questions.id','=','exam_management_questions.question_id')
							 ->leftJoin('segregations','segregations.id','=','questions.segregation_id')
							 ->select('questions.id as q_id','questions.*','segregations.*','exam_management_questions.*')
							->get();
							foreach($data['question'] as $key=>$que_details){
								 $quest_id=$que_details->q_id;
								 $data['question'][$key]['student_answer']=StudentAnswer::where([['exam_id',$request->exam_id],['student_id',$request->student_id],['question_id',$quest_id]])->get();
							}
		// print_r($data['question']);
		return view('exam_management.view_student_exam_report',$data);
	}
	public function submiteexamReport(Request $request){
		$Exam_id = $request->exam_id;
		$student_id = $request->student_id;
		$StudentAnswer = StudentAnswer::where([['exam_id',$Exam_id],['student_id',$student_id]])->get();
		foreach($StudentAnswer->pluck("id") as $key=>$ids){
			$updateanswer =StudentAnswer::find($ids);
			$updateanswer->answer_description =$request->answer_description[$key];
			$updateanswer->save();
		}
		  return back()->with('success','Report Added Successfully!');
	
	}
	public function viewMyExamReport(Request $request){
		// echo $Exam_id = $request->exam_id;
		$data['question']=ExamManagementQuestions::where([['exam_management_id',$request->exam_id]])
							 ->leftJoin('questions','questions.id','=','exam_management_questions.question_id')
							 ->leftJoin('segregations','segregations.id','=','questions.segregation_id')
							 ->select('questions.id as q_id','questions.*','segregations.*','exam_management_questions.*')
							->get();
							foreach($data['question'] as $key=>$que_details){
								 $quest_id=$que_details->q_id;
								 $data['question'][$key]['student_answer']=StudentAnswer::where([['exam_id',$request->exam_id],['student_id', auth()->user()->id],['question_id',$quest_id]])->get();
							}
								return view('student.exam.examreport',$data);
	}
	public function updateAnswer(){
		
	}
    public function create(Request $request)
    {
       
    }

    
    public function store(Request $request)
    {
        //
    }

   
    public function show(StudentExam $studentExam)
    {
        //
    }

   
    public function edit(StudentExam $studentExam)
    {
        //
    }

   
    public function update(Request $request, StudentExam $studentExam)
    {
        //
    }

   
    public function destroy(StudentExam $studentExam)
    {
        //
    }
}
