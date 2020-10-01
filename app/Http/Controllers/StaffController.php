<?php

namespace App\Http\Controllers;

use App\Staff;
use App\StaffSubjectAssign;
use App\User;
use App\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:staff_view|staff_create|staff_update|staff_delete', ['only' => ['index','show','create','store','edit','update','destroy']]);
        $this->middleware('permission:staff_view', ['only' => ['index']]);
        $this->middleware('permission:staff_create', ['only' => ['create','store']]);
        $this->middleware('permission:staff_update', ['only' => ['edit','update']]);
        $this->middleware('permission:staff_delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['Staffs'] = Staff::get();
        return view('staff.view',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $StaffCount = Staff::get()->count();
        $str = strlen((string)$StaffCount);
        if($StaffCount == 0){
            $data['staff_id'] = "tts_00".++$StaffCount;
        }else{
            $LastStaff = Staff::get()->last();
            $LastStaff->staff_id_no;
            $staffid = explode('_',$LastStaff->staff_id_no);
            $data['staff_id'] = "tts_00".++$staffid[1];
        }
        $data['roles'] = Role::where('is_default',0)->get();
        return view('staff.add',$data);
    }

	public function screenshare(Request $request){
        $data['scheduleclass_id'] = $request->scheduleclass_id;
        $data['class_id'] = $request->class_id;
        $data['section_id'] = $request->section_id;
        $data['subject_id'] = $request->subject_id;
        $data['class'] = DB::table('subjects')->pluck('class','class')->unique();
        $data['Student']= Student::where([['students.student_class',$request->class_id], ['students.section_id', $request->section_id],['users.user_type', 'Student']])
        ->leftJoin('users','students.id','users.user_id')
        ->get()
        ->toArray();
		return  view('live_screen',$data);
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
            'staff_id_no' => ['required', 'unique:staff'],
            'staff_name' => ['required'],
            'dob' => ['required'],
            'qualification' => ['required', 'string'],
            'mobile_number' => ['required', 'numeric', 'digits_between:10,11', 'unique:users,mobile_number'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        ]);
        DB::beginTransaction();
        try{
            // $StaffCount = Staff::get()->count();
            // $str = strlen((string)$StaffCount);
            // if($StaffCount == 0){
            //     $staff_id = "tts_00".++$StaffCount;
            // }else{
            //     if($str >= 1){
            //         $staff_id = "tts_00".++$StaffCount;
            //     }elseif($str >= 2){
            //         $staff_id = "tts_0".++$StaffCount;
            //     }elseif($str >= 3){
            //         $staff_id = "tts_".++$StaffCount;
            //     }
            // }
            $Staff = new Staff;
            $Staff->staff_id_no = $request->staff_id_no;
            $Staff->staff_name = $request->staff_name;
            $Staff->dob = date('Y-m-d',strtotime($request->dob));
            $Staff->qualification = $request->qualification;
            $Staff->mobile_number = $request->mobile_number;
            $Staff->email = $request->email;
            $Staff->save();
            $roles = $request->roles;
            $User = User::create([
                'name' => $Staff->staff_name,
                'email' => $Staff->email,
                'password' => Hash::make($Staff->mobile_number),
                'user_id' => $Staff->id,
                'user_type' => 'Staff',
                'mobile_number' => $Staff->mobile_number,
            ]);
            $User->assignRole($roles);
            DB::commit();
            return back()->with('success','Staff Added Successfully!');
        }catch (Exception $e){
            DB::rollBack();
            return back()->with('error','Staff Cannot Be Added!')->withInput();
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
        $data['Staffs'] = Staff::find($id);
        $data['roles'] = Role::where('is_default',0)->get();
        $data['User'] = User::where('email',$data['Staffs']->email)->first();
        $data['Role'] = DB::table('model_has_roles')->where('model_id',$data['User']->id)->pluck('role_id');
        return view('staff.add',$data);
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
        $StaffUser = User::where([['user_id',$id],['user_type','Staff']])->first();
        $this->validate($request, [
            'staff_id_no' => ['required'],
            'staff_name' => ['required'],
            'dob' => ['required'],
            'qualification' => ['required', 'string'],
            'mobile_number' => ['required', 'numeric', 'digits_between:10,11','unique:users,mobile_number,'.$StaffUser->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$StaffUser->id],
        ]);
        DB::beginTransaction();
        try{
            $Staff = Staff::find($id);
            $Staff->staff_id_no = $request->staff_id_no;
            $Staff->staff_name = $request->staff_name;
            $Staff->dob = date('Y-m-d',strtotime($request->dob));
            $Staff->qualification = $request->qualification;
            $Staff->mobile_number = $request->mobile_number;
            $Staff->email = $request->email;
            $Staff->save();

            $roles = $request->roles;

            $StaffUser = User::where([['user_id',$Staff->id],['user_type','Staff']])->first();

            $UserStaff = User::findorfail($StaffUser->id);
            $UserStaff->name = $Staff->staff_name;
            $UserStaff->email = $Staff->email;
            $UserStaff->password = Hash::make($Staff->mobile_number);
            $UserStaff->user_id = $Staff->id;
            $UserStaff->user_type = 'Staff';
            $UserStaff->mobile_number = $Staff->mobile_number;
            $UserStaff->save();

            DB::table('model_has_roles')->where('model_id',$StaffUser->id)->delete();

            $UserStaff->assignRole($roles);
            DB::commit();
            return redirect('/staff')->with('success','Staff Updated Successfully!');
        }catch (Exception $e){
            DB::rollBack();
            return back()->with('error','Staff Cannot Be Updated!')->withInput();
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
        $Staff = Staff::find($id);
        $StaffSubjectAssign = StaffSubjectAssign::where('staff_id',$Staff->id)->get()->count();
        if($StaffSubjectAssign == 0){
            $User = User::where('email',$Staff->email)->first()->delete();
            $Staff = Staff::find($id)->delete();
            return back()->with('success','Staff Deleted Successfully!');
        }else{
            return back()->with('error','Staff Cannot be Deleted.Because this Staff Assigned for subjects.');
        }
    }
}
