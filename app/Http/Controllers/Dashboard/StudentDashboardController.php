<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\StaffScheduleClass;
use App\Student;
use App\User;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $data['Student'] = Student::where('id',auth()->user()->user_id)->first();
        $data['StudentClasses'] = StaffScheduleClass::where('class',$data['Student']->student_class)->get();
        return view('dashboard.student_dashboard',$data);
    }

    public function playVideo()
    {
        return 1;
    }
}
