<?php

namespace App\Http\Controllers;

use App\ClassSection;
use App\Record;
use App\Student;
use App\Homework;
use App\StudentHomeworkList;
use App\StaffScheduleClass;
use App\StaffSubjectAssign;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\ImageManagerStatic as Image;

class StudentController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth']);
        // $this->middleware('auth:student');
        $this->middleware('permission:student_view|student_create|student_update|student_delete|all_section_student_view|assigned_section_student_view', ['only' => ['index','show','create','store','edit','update','destroy']]);
        $this->middleware('permission:student_view|student_create|student_update|student_delete', ['only' => ['index','show','create','store','edit','update','destroy']]);
        $this->middleware('permission:student_view', ['only' => ['index']]);
        // $this->middleware('permission:all_section_student_view|assigned_section_student_view', ['only' => ['index']]);
        $this->middleware('permission:student_create', ['only' => ['create','store']]);
        $this->middleware('permission:student_update', ['only' => ['edit','update']]);
        $this->middleware('permission:student_delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(auth()->user()->user_type=="Admin" || auth()->user()->user_type=="super_admin"){
            $data['StaffSubjectAssign'] = ClassSection::get()->unique('class');
        }elseif (auth()->user()->user_type=="Student") {
            $data['StaffSubjectAssign'] = [];
        }else{
            if (auth()->user()->hasPermissionTo('all_section_student_view')) {
                $data['StaffSubjectAssign'] = StaffSubjectAssign::get()->unique('class');
            }
            if (auth()->user()->hasPermissionTo('assigned_section_student_view')) {
                $data['StaffSubjectAssign'] = StaffSubjectAssign::where('staff_id',auth()->user()->user_id)->get()->unique('class');
            }
        }

        if (request()->ajax()) {
            $Student =  Student::where([['student_class',$request->class_id],['section_id',$request->section_id]])->get();
            return DataTables::of($Student)
                ->addIndexColumn()
                ->addColumn('section_id', function ($Student) {
                    return $Student->ClassSection->section;
                })
                ->addColumn('action',
                    '<a href="{{ action("StudentController@edit",$id) }}" class="btn EditInstitution" id="{{ $id }}">
                        <i class="fa fa-pencil text-aqua"></i>
                    </a>
                    <a href="#" id="{{ $id }}" class="btn DeleteStudent" data-toggle="modal" data-target="#DeleteModel">
                        <i class="fa fa-trash-o" style="color:red;"></i>
                    </a>'
                )
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('student.view',$data);
    }

    public function getStaffSection(Request $request)
    {
        if(auth()->user()->user_type=="Admin" || auth()->user()->user_type=="super_admin"){
            return Student::where([['student_class',$request->class]])->with('ClassSection')->get()->unique('section_id');
        }else{
            if (auth()->user()->hasPermissionTo('all_section_student_view')) {
                return StaffSubjectAssign::where('class',$request->class)->with('ClassSection')->get()->unique('section_id');
            }
            if (auth()->user()->hasPermissionTo('assigned_section_student_view')) {
                return StaffSubjectAssign::where([['staff_id',auth()->user()->user_id],['class',$request->class]])->with('ClassSection')->get()->unique('section_id');
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['ClassSection'] = ClassSection::get()->unique('class');
        $data['Subject'] = Subject::get()->unique('class');
        $data['roles'] = Role::where('is_default',0)->get();
        return view('student.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'student_name' => ['required'],
            'student_class' => ['required'],
            'section_id' => ['required'],
            'dob' => ['required'],
            'mobile_number' => ['required', 'numeric', 'digits_between:10,11', 'unique:users,mobile_number'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'gender' => ['required'],
            'responsible' => ['required'],
            'person_name' => ['required'],
            'person_number' => ['required ', 'numeric', 'digits_between:10,11'],
        ]);
        DB::beginTransaction();
        try{
            $Student = new Student;
            $Student->student_name = $request->student_name;
            $Student->student_class = $request->student_class;
            $Student->section_id = $request->section_id;
            $Student->dob = date('Y-m-d',strtotime($request->dob));
            $Student->country_code = $request->country_code;
            $Student->mobile_number = $request->mobile_number;
            $Student->email = $request->email;
            $Student->gender = $request->gender;
            $Student->responsible = $request->responsible;
            $Student->person_name = $request->person_name;
            $Student->person_number = $request->person_number;
            $Student->photo = $request->photo;
            if (isset($request->photo)) {
                $photos = $request->file('photo');
                $Student->photo = $this->uploadImages($photos, "student_" . $request->student_name, "student");
            }
            $Student->save();

            $roles = $request->roles;

            $User = User::create([
                'name' => $Student->student_name,
                'email' => $Student->email,
                'password' => Hash::make($Student->mobile_number),
                'user_id' => $Student->id,
                'user_type' => 'Student',
                'country_code' => $Student->country_code,
                'mobile_number' => $Student->mobile_number,
            ]);
            $User->assignRole($roles);
            DB::commit();
            return back()->with('success','Student Added Successfully!');
        }catch (Exception $e){
            DB::rollBack();
            return back()->with('error','Student Cannot be Added!')->withInput();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['Students'] = Student::find($id);
        $data['ClassSection'] = ClassSection::get()->unique('class');
        $data['Subject'] = Subject::get()->unique('class');
        $data['User'] = User::where('email',$data['Students']->email)->first();
        $data['roles'] = Role::where('is_default',0)->get();
        $data['Role'] = DB::table('model_has_roles')->where('model_id',$data['User']->id)->pluck('role_id');
        return view('student.add',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $StudentUser = User::where([['user_id',$id],['user_type','Student']])->first();
        $this->validate($request, [
            'student_name' => ['required'],
            'student_class' => ['required'],
            'section_id' => ['required'],
            'dob' => ['required'],
            'mobile_number' => ['required', 'numeric', 'digits_between:10,11','unique:users,mobile_number,'.$StudentUser->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$StudentUser->id],
            'gender' => ['required'],
			'responsible' => ['required'],
            'person_name' => ['required'],
            'person_number' => ['required ', 'numeric', 'digits_between:10,11'],
        ]);
        DB::beginTransaction();
        try{
            $Student = Student::find($id);
            $Student->student_name = $request->student_name;
            $Student->student_class = $request->student_class;
            $Student->section_id = $request->section_id;
            $Student->dob = date('Y-m-d',strtotime($request->dob));
            $Student->country_code = $request->country_code;
            $Student->mobile_number = $request->mobile_number;
            $Student->email = $request->email;
            $Student->gender = $request->gender;
			$Student->responsible = $request->responsible;
            $Student->person_name = $request->person_name;
            $Student->person_number = $request->person_number;
            $Student->photo = $request->photo;
            if (isset($request->photo)) {
                $photos = $request->file('photo');
                $Student->photo = $this->uploadImages($photos, "student_" . $request->student_name, "student");
            }
            $Student->save();

            $roles = $request->roles;

            $StudentUser = User::where([['user_id',$Student->id],['user_type','Student']])->first();

            $UserStudent = User::findorfail($StudentUser->id);
            $UserStudent->name = $Student->student_name;
            $UserStudent->email = $Student->email;
            $UserStudent->password = Hash::make($Student->mobile_number);
            $UserStudent->user_id = $Student->id;
            $UserStudent->user_type = 'Student';
            $UserStudent->country_code = $Student->country_code;
            $UserStudent->mobile_number = $Student->mobile_number;
            $UserStudent->save();

            DB::table('model_has_roles')->where('model_id',$StudentUser->id)->delete();
            $UserStudent->assignRole($roles);
            DB::commit();
            return back()->with('success','Student Updated Successfully!');
        }catch (Exception $e){
            DB::rollBack();
            return back()->with('success','Student Cannot be Updated!')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Student = Student::find($id);
        $User = User::where('email',$Student->email)->first()->delete();
        $Student = Student::find($id)->delete();
        return back()->with('success','Student Deleted Successfully!');
    }

    public function delete(Request $request)
    {
        $Student = Student::find($request->student_id);
        $User = User::where('email',$Student->email)->first()->delete();
        $Student = Student::find($request->student_id)->delete();
        $Data['status'] = 'success';
        $Data['message'] = 'Student Deleted Successfully!';
        return response()->json($Data);
    }

    public function submithomework(Request $request){
        if (isset($request->homework_file)) {
            $files = $request->file('homework_file');
            $document = '/public/uploads/homeworks/'.$files->getClientOriginalName();
            $files->move(public_path().'/uploads/homeworks/',$document);
            $SubmitHomework=new StudentHomeworkList();
            $SubmitHomework->homework_id=$request->homework_id;
            $SubmitHomework->student_id=auth()->user()->id;
            $SubmitHomework->homework_attachment=$document;
            $SubmitHomework->submitted_on=date('d-m-Y');
            $SubmitHomework->status="Pending";
            $SubmitHomework->save();
            $Data['status'] = 'success';
            $Data['message'] = 'Homework Submitted Successfully';
            return response()->json($Data);
        }else{
             $Data['status'] = 'error';
			 $Data['message'] = 'Homework Not Submitted!';
             return response()->json($Data);
         }
    }

    public function uploadImages($file, $newName, $subFolder)
    {
        $folder = "uploads/" . $subFolder;
        if ($file != null) {
            $fileExtension = $file->getClientOriginalExtension();
            $newFileName = $newName . "." . $fileExtension;
            $tmpFile = Image::make($file->getRealPath())->encode($fileExtension, 50);
            Storage::put($folder . "/" . $newFileName, $tmpFile);
        } else {
            $newFileName = "";
        }
        return "app/" . $folder . "/" . $newFileName;
    }

    public function viewscreenshare($id){
        $data['class_details']= DB::table('onlineclass')->where([['status', 1], ['session_id', $id]])->get()->toArray();
        if(empty($data['class_details']) ||  $data['class_details']==null)
        {
            return Redirect::to('home');
        }
        return  view('viewscreenshare',$data);
    }

    public function Playvideos(Request $request){
        return Record::where([['staff_id',$request->staff_id],['class_id',$request->class_id],['section_id',$request->section_id]])->get();
    }

    public function getStudent(Request $request){
        $Student= Student::where([['students.student_class',$request->class_id], ['students.section_id', $request->section_id],['users.user_type', 'Student']])
        ->leftJoin('users','students.id','users.user_id')
        ->get()
        ->toArray();
        foreach($Student as $key=>$value){
            $stdid= $value['id'];
            $Student[$key]['submitted'] =$this->check($stdid,$request->homework_id);
        }
        return $Student;
    }

    public function check($stdid,$homework_id){
        return  $submittedhomeworks = StudentHomeworkList::where([['homework_id', $homework_id], ['student_id', $stdid]])
        ->get()->toArray();
    }
}
