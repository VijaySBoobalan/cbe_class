<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StaffScheduleClass;
use App\Student;

class HomeController extends Controller
{
    /**
     * Only Authenticated users for "admin" guard
     * are allowed.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:student');
        $this->middleware('verified');
    }

    /**
     * Show Admin Dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data['Student'] = Student::where('id',auth()->user()->user_id)->first();
        return $data['StudentClasses'] = StaffScheduleClass::where([['class',$data['Student']->student_class],['section_id',$data['Student']->section_id]])->get();
        return view('dashboard.student_dashboard',$data);
    }
}
