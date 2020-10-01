<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Batch;
use App\Batchstudents;
use App\ClassSection;
use App\Student;
use App\User;
use DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['ClassSection'] = ClassSection::get()->unique('class');
        if (request()->ajax()) {
            $Batches =  Batch::get();
            return DataTables::of($Batches)
                ->addIndexColumn()
				 ->addColumn('total_students', function ($Batch) {
					return $this->get_total_students($Batch->id);
					})
                ->addColumn('action', function ($Batch) {
                    $btn = "";
                    if(!auth()->user()->hasAnyPermission('batch_update','batch_delete')){
                        $btn .= '<p>-</p>';
                    }
                    if(auth()->user()->hasPermissionTo('batch_update')){
                        $btn .= '<a href="#" class="btn EditBatch" id="'.$Batch->id.'" data-toggle="modal" data-target="#editBatchModal"><i class="fa fa-pencil text-aqua"></i></a>';
                    }
                    if(auth()->user()->hasPermissionTo('batch_delete')){
                        $btn .= '<a href="#" id="'.$Batch->id.'" class="btn DeleteBatch" data-toggle="modal" data-target="#DeleteModel"><i class="fa fa-trash-o" style="color:red;"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.batch.view',$data);
    }
	function get_total_students($Batch){
		// return $Batch;
		    return    $StudentTotalCount = Batchstudents::where([['batch_id',$Batch]])->get()->count();
	}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function Batchstore (Request $request){
        // try{
            $Batch = new Batch;
            $Batch->batch_name = $request->batch_name;
            $Batch->batch_type = $request->batch_type;
            $Batch->class_id = $request->student_class;
            $Batch->section_id = $request->section_id;
            $Batch->save();
			$student_list = $request->sel_student;
			foreach($student_list as $students){
				$Batchstudents = new Batchstudents;
				$Batchstudents->batch_id=$Batch->id;
				$Batchstudents->student_id=$students;
				$Batchstudents->save();
			}
            
            $Data['status'] = 'success';
            $Data['message'] = 'Batch Added Successfully';
            return response()->json($Data);
        // }catch (Exception $e){
            // $Data['status'] = 'error';
            // $Data['message'] = 'Something Went Wrong ! Please Try Again.';
            // return response()->json($Data);
        // }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    
    public function Batchedit(Request $request){
        try {
			$Data['batch_id'] = request('batch_id');
            $Data['Batches'] = Batch::findorfail(request('batch_id'));
			// echo $Data['Batches']->class_id;
			// echo $Data['Batches']->section_id;
			if(!empty($Data['Batches']->class_id)){
			$Data['Students']=$this->studentList($Data['Batches']->class_id,$Data['Batches']->section_id);	
			}else{
			$Data['Students']=	$this->getAllStudents();
			}
			$Data['allotedStudents'] = Batchstudents::where([['batch_id',request('batch_id')]])->get();
			
            $Data['status'] = 'success';
		
			return view('master.batch.editdata',$Data)->render();
        }catch (Exception $e){
            return response()->json(['error'=>'Batch Not Found!']);
        }
    }
	 public function StudentList($class_id,$section_id)
    {

						return	$Students=User::where([['students.student_class',$class_id],['students.section_id',$section_id],['user_type','Student']])
								      ->leftJoin('students','students.id','users.user_id')
									    ->leftJoin('class_sections','class_sections.id','students.section_id')
									  ->select('users.id as u_id','users.*','students.*','class_sections.*')
									  ->get();
									
										
    }
	public function getAllStudents(){
		 return $Student= User::where([['users.user_type', 'Student']])
        ->leftJoin('students','students.id','users.user_id')
        ->leftJoin('class_sections','class_sections.id','students.section_id')
		->select('users.id as u_id','users.*','students.*','class_sections.*')
        ->get();
	} 
    /**
     * Display the specified resource.
     *
     * @param  \App\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function show(Batch $batch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function edit(Batch $batch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Batch $batch)
    {
        //
    }
    public function BatchUpdate (Request $request)
    {
        try {
			$student_list=$request->sel_student;
            $Batches = Batch::findorfail($request->batch_id);
            $Batches->batch_name = $request->batch_name;
            $Batches->save();
			$Batchstudentslist=Batchstudents::where('batch_id',$request->batch_id)->get();
			// print_r($Batchstudentslist);
			if(empty($Batchstudentslist)){
				foreach($student_list as $students){
				$Batchstudents = new Batchstudents;
				$Batchstudents->batch_id=$request->batch_id;
				$Batchstudents->student_id=$students;
				$Batchstudents->save();
				}
			}else{
				$allostudents=array();
				foreach($Batchstudentslist->pluck('student_id') as $alstudents){
					 $allostudents[]=$alstudents; 
				}
				foreach($allostudents as $alstu){
					 if(!in_array($alstu,$student_list)){
						 DB::table('batchstudents')->where([['student_id',$alstu],['batch_id',$request->batch_id]])->delete();
					 }
				}
				 $new_students=array_diff($student_list,$allostudents);
				 foreach($new_students as $nstd){
						$Batchstudents = new Batchstudents;
						$Batchstudents->batch_id=$request->batch_id;
						$Batchstudents->student_id=$nstd;
						$Batchstudents->save();
				 }
			}
            $Data['status'] = 'success';
            $Data['message'] = 'Batch Updated Successfully';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error'.$e;
            $Data['message'] = 'Something Went Wrong !';
            return response()->json($Data);
        }
    }

    public function BatchDelete(Request $request){
        try {
            $Batch = Batch::findorfail($request->batchId)->delete();
            $Data['status'] = 'success';
            $Data['message'] = 'Batch Deleted Successfully';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            $Data['message'] = 'Something Went Wrong !';
            return response()->json($Data);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Batch $batch)
    {
        //
    }
}
