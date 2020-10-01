<?php

use App\FeeGroupTypeDetails;
use App\FeesCollection;
use App\FeesType;
use App\StaffAttendance;
use App\StaffScheduleSubjectDetails;
use App\Student;
use App\User;
use App\Onlineclass;
use App\AutomaticQuestionChapters;
use App\AutomaticQuestionDetails;
use App\Questions;
use App\Segregation;
use App\PreparationTypes;
use App\CreatedQuestions;
use App\QuestionPaperUi;
use App\ChapterBasedQuestionDetails;
use App\StaffScheduleClass;
use App\StudentAssignFeesDetails;
use App\StudentAttendence;
use App\Subject;
use App\StudentAnswer;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Contracts\Permission;

if (!function_exists('getSubjectDetails')) {
    function getSubjectDetails($ClassId)
    {
    $data['schduled_list']=StaffScheduleSubjectDetails::where([['staff_schedule_subject_details.staff_schedule_class_id',$ClassId]])
	->join('subjects','subjects.id','staff_schedule_subject_details.subject_id')
	->select('staff_schedule_subject_details.id as scheduleclass_id','subjects.*','staff_schedule_subject_details.*')
	->get()
	->toArray();

    foreach($data['schduled_list'] as $key=>$list){
	 $scheduled_id = $list['scheduleclass_id'];
		 $data['schduled_list'][$key]['live'] =get_live_class($scheduled_id);
	}
	return $data['schduled_list'];
	}
}

if (!function_exists('get_live_class')) {
	function get_live_class($scheduled_id){
	return  Onlineclass::where([['scheduleclass_id', $scheduled_id],['status',1]])->get()->toArray();
	}
}

if (!function_exists('getPermissionDetails')) {
    function getPermissionDetails($Permission)
    {
        return DB::table('permissions')->where('description',$Permission)->get();
    }
}

if (!function_exists('getFeeGroupedDetails')) {
    function getFeeGroupedDetails($FeeGroupId,$FeeTypeId)
    {
        return FeeGroupTypeDetails::where([['fee_group_type_id',$FeeGroupId],['fee_name_id',$FeeTypeId]])->first();
    }
}

if (!function_exists('getStudentFeeAmount')) {
    function getStudentFeeAmount($FeeGroupId){
        $FeeGroupTypeDetails = FeeGroupTypeDetails::where([['fee_group_type_id',$FeeGroupId]])->pluck('fee_name_id');
        $FeesType = FeesType::whereIn('id',$FeeGroupTypeDetails)->pluck('amount')->toArray();
        return array_sum($FeesType);
    }
}

if (!function_exists('getAssignedStudentFees')) {
    function getAssignedStudentFees($studentId,$FeeGroupId)
    {
        return StudentAssignFeesDetails::where([['student_id',$studentId],['fee_group_id',$FeeGroupId]])->first();
    }
}

if (!function_exists('getStudentFeeAmountYearWise')) {
    function getStudentFeeAmountYearWise($studentId,$class_id){
        $data['FeeGroupTypeDetails'] = 0;
        $FeeGroupTypeDetails = 0;
        $data['FeesCollectionAmount'] = FeesCollection::where([['student_id',$studentId],['class_id',$class_id]])->sum('amount');
        $data['FeesCollectionDiscount'] = FeesCollection::where([['student_id',$studentId],['class_id',$class_id]])->sum('discount_amount');
        $data['StudentFormGroupIds'] = StudentAssignFeesDetails::where([['student_assign_fees_details.student_id',$studentId],['student_assign_fees.class_id',$class_id]])->join('student_assign_fees','student_assign_fees.id','student_assign_fees_details.student_assign_fee_id')->pluck('student_assign_fees_details.fee_group_id');
        if (isset($data['StudentFormGroupIds'])) {
            foreach ($data['StudentFormGroupIds'] as $key => $value) {
                $data['FeeGroupTypeDetails'] += FeeGroupTypeDetails::where('fee_group_type_id',$value)->JOIN('fees_types','fees_types.id','fee_group_type_details.fee_name_id')->sum('fees_types.amount');
            }
        }
        return $data;
    }
}

if (!function_exists('getFeesGroupAmount')) {
    function getFeesGroupAmount($StudentId,$class_id,$FeesGroup){
        $FeeAmount = 0;
        $FeesCollectionAmount = FeesCollection::where([['student_id',$StudentId],['class_id',$class_id],['fee_group_id',$FeesGroup]])->sum('amount');
        $FeesCollectionDiscount = FeesCollection::where([['student_id',$StudentId],['class_id',$class_id],['fee_group_id',$FeesGroup]])->sum('discount_amount');
        $StudentFormGroupIds = StudentAssignFeesDetails::where([['student_assign_fees_details.student_id',$StudentId],['student_assign_fees.class_id',$class_id],['student_assign_fees_details.fee_group_id',$FeesGroup]])->join('student_assign_fees','student_assign_fees.id','student_assign_fees_details.student_assign_fee_id')->pluck('student_assign_fees_details.fee_group_id')->toArray();
        if (isset($StudentFormGroupIds)) {
            foreach ($StudentFormGroupIds as $key => $value) {
                $FeeAmount += FeeGroupTypeDetails::where('fee_group_type_id',$value)->JOIN('fees_types','fees_types.id','fee_group_type_details.fee_name_id')->sum('fees_types.amount');
            }
        }
        // $FeeAmount = FeeGroupTypeDetails::whereIn('fee_group_type_id',$StudentFormGroupIds)->join('fees_types','fees_types.id','fee_group_type_details.fee_name_id')->sum('fees_types.amount');
        return $FeeAmount - ($FeesCollectionAmount + $FeesCollectionDiscount);
    }
}

if (!function_exists('EditFeesGroupAmount')) {
    function EditFeesGroupAmount($StudentId,$class_id,$FeesGroup){
        $FeesCollectionAmount = FeesCollection::where([['student_id',$StudentId],['class_id',$class_id],['fee_group_id',$FeesGroup]])->sum('amount');
        $FeesCollectionDiscount = FeesCollection::where([['student_id',$StudentId],['class_id',$class_id],['fee_group_id',$FeesGroup]])->sum('discount_amount');
        $StudentFormGroupIds = StudentAssignFeesDetails::where([['student_assign_fees_details.student_id',$StudentId],['student_assign_fees.class_id',$class_id],['student_assign_fees_details.fee_group_id',$FeesGroup]])->join('student_assign_fees','student_assign_fees.id','student_assign_fees_details.student_assign_fee_id')->pluck('student_assign_fees_details.fee_group_id')->toArray();
        $FeeAmounts = FeeGroupTypeDetails::whereIn('fee_group_type_id',$StudentFormGroupIds)->join('fees_types','fees_types.id','fee_group_type_details.fee_name_id')->sum('fees_types.amount');
        // $FeeAmount = $FeeAmounts - ($FeesCollectionAmount + $FeesCollectionDiscount);
        return $FeeAmounts;
    }
}

if (!function_exists('getFeesGroupPaidDetails')) {
    function getFeesGroupPaidDetails($StudentId,$class_id,$FeesGroup){
        return $FeesCollectionAmount = FeesCollection::where([['student_id',$StudentId],['class_id',$class_id],['fee_group_id',$FeesGroup]])->get();
    }
}

if (!function_exists('staffClassTaken')) {
    function staffClassTaken($StaffScheduleSubjectDetails){
        $TotalInHours = 0;
        $TotalInMinutes = 0;
        $TakenTime = 0;
        $Totalmins = 0;
        $StaffAttendances = StaffAttendance::where([['staff_id',$StaffScheduleSubjectDetails->staff_id],['class',$StaffScheduleSubjectDetails->class],['section_id',$StaffScheduleSubjectDetails->section_id],['subject_id',$StaffScheduleSubjectDetails->subject_id],['date',date('Y/m/d',strtotime($StaffScheduleSubjectDetails->subject_day))],['to_time','!=',""]])->get();
        if(!empty($StaffAttendances)){
            foreach ($StaffAttendances as $key => $StaffAttendance) {
                $totime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $StaffAttendance->to_time);
                $fromtime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $StaffAttendance->from_time);
                $diff_in_minutes = $totime->diffInMinutes($fromtime);
                $diff_in_hours = $totime->diffInHours($fromtime);
                $TotalInMinutes += $diff_in_minutes;
                $TotalInHours += $diff_in_hours;
            }
        }
        $Totalmins = $TotalInMinutes % 60;
        $TakenTime = $TotalInHours ."hrs:".$Totalmins."mins";
        return $TakenTime;
    }
}

if (!function_exists('staffClassWiseTaken')) {
    function staffClassWiseTaken($StaffScheduleSubjectDetails){
        $TotalInHours = 0;
        $TotalInMinutes = 0;
        $TakenTime = 0;
        $Totalmins = 0;
        $StaffAttendances = StaffAttendance::where([['staff_id',$StaffScheduleSubjectDetails->staff_id],['class',$StaffScheduleSubjectDetails->class],['section_id',$StaffScheduleSubjectDetails->section_id],['subject_id',$StaffScheduleSubjectDetails->subject_id],['subject_schedule_id',$StaffScheduleSubjectDetails->subjectScheduleId],['date',date('Y/m/d',strtotime($StaffScheduleSubjectDetails->subject_day))],['to_time','!=',""]])->get();
        foreach ($StaffAttendances as $key => $StaffAttendance) {
            $totime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $StaffAttendance->to_time);
            $fromtime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $StaffAttendance->from_time);
            $diff_in_minutes = $totime->diffInMinutes($fromtime);
            $diff_in_hours = $totime->diffInHours($fromtime);
            $TotalInMinutes += $diff_in_minutes;
            $TotalInHours += $diff_in_hours;
        }
        $Totalmins = $TotalInMinutes % 60;
        $TakenTime = $TotalInHours ."hrs:".$Totalmins."mins";
        return $TakenTime;
    }
}

if (!function_exists('StaffAttendanceStatus')) {
    function StaffAttendanceStatus($StaffScheduleSubjectDetails){
        $TotalInHours = 0;
        $TotalInMinutes = 0;
        $TakenTime = 0;
        $Totalmins = 0;
        $TakenTotalInMinutes = 0;
        $TakenTotalInHours = 0;
        $StaffAttendances = StaffAttendance::where([['staff_id',$StaffScheduleSubjectDetails->staff_id],['date',date('Y/m/d',strtotime($StaffScheduleSubjectDetails->subject_day))],['to_time','!=',""]])->get();
        if(!empty($StaffAttendances)){
            foreach ($StaffAttendances as $key => $StaffAttendance) {
                $totime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $StaffAttendance->to_time);
                $fromtime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $StaffAttendance->from_time);
                $diff_in_minutes = $totime->diffInMinutes($fromtime);
                $diff_in_hours = $totime->diffInHours($fromtime);
                $TotalInMinutes += $diff_in_minutes;
                $TotalInHours += $diff_in_hours;
            }
        }
        $StaffScheduleSubjectDetail = StaffScheduleSubjectDetails::where([['staff_id',$StaffScheduleSubjectDetails->StaffId],['subject_day',$StaffScheduleSubjectDetails->subject_day]])->get();
        foreach ($StaffScheduleSubjectDetail as $key => $StaffAttendance) {
            $totime = \Carbon\Carbon::createFromFormat('H:i', $StaffAttendance->to_time);
            $fromtime = \Carbon\Carbon::createFromFormat('H:i', $StaffAttendance->from_time);
            $diff_in_minutes = $totime->diffInMinutes($fromtime);
            $diff_in_hours = $totime->diffInHours($fromtime);
            $TakenTotalInMinutes += $diff_in_minutes;
            $TakenTotalInHours += $diff_in_hours;
        }
        $Totalmins = $TakenTotalInMinutes-$TotalInMinutes;

        if($Totalmins<=10){
            return $status = "Present";
        }else{
            return $status = "Absent";
        }
    }
}

if (!function_exists('totalScheduleTakenTime')) {
    function totalScheduleTakenTime($StaffScheduleSubjectDetails){
        $TotalInHours = 0;
        $TotalInMinutes = 0;
        $TakenTime = 0;
        $Totalmins = 0;
        $StaffAttendances = StaffAttendance::where([['date',date('Y/m/d',strtotime($StaffScheduleSubjectDetails->subject_day))],['to_time','!=',""]])->get();
        foreach ($StaffAttendances as $key => $StaffAttendance) {
            $totime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $StaffAttendance->to_time);
            $fromtime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $StaffAttendance->from_time);
            $diff_in_minutes = $totime->diffInMinutes($fromtime);
            $diff_in_hours = $totime->diffInHours($fromtime);
            $TotalInMinutes += $diff_in_minutes;
            $TotalInHours += $diff_in_hours;
        }
        $Totalmins = $TotalInMinutes % 60;
        // $TotalInMinutes = $TotalInMinutes / 60;
        $str = strlen((string)$Totalmins);
        if($str == 1){
            $data['TakenTime'] = $TotalInHours ."hrs:0".$Totalmins."mins";
            $data['TotalTakentime'] = $TotalInHours .".0".$Totalmins;
        }else{
            $data['TakenTime'] = $TotalInHours ."hrs:".$Totalmins."mins";
            $data['TotalTakentime'] = $TotalInHours .".".$Totalmins;
        }
        // $data['TakenTime'] = $TotalInHours ."hrs:".$Totalmins."mins";
        // $data['TotalTakentime'] = $TotalInHours .".".$Totalmins;
        return $data;
    }
}

if (!function_exists('StudentClassTime')) {
    function StudentClassTime($StaffScheduleSubjectDetails){
        $StudentAttendences = StudentAttendence::where([['class',$StaffScheduleSubjectDetails->class],['section_id',$StaffScheduleSubjectDetails->section_id],['subject_id',$StaffScheduleSubjectDetails->subject_id],['subject_schedule_id',$StaffScheduleSubjectDetails->subjectScheduleId],['date',date('Y/m/d',strtotime($StaffScheduleSubjectDetails->subject_day))],['to_time','!=',""]])->get()->unique('student_id')->count();
        $StudentTotalCount = Student::where([['student_class',$StaffScheduleSubjectDetails->class],['section_id',$StaffScheduleSubjectDetails->section_id]])->get()->count();
        return $StudentAttendences."/".$StudentTotalCount;
    }
}

if (!function_exists('AttendTime')) {
    function AttendTime($StaffScheduleSubjectDetails){
        $TakenTotalInHours = 0;
        $TakenTotalInMinutes = 0;
        $classTakenTime = 0;
        $classtakenTotalmins = 0;
        $StaffAttendances = StaffAttendance::where([['staff_id',$StaffScheduleSubjectDetails->staff_id],['class',$StaffScheduleSubjectDetails->class],['section_id',$StaffScheduleSubjectDetails->section_id],['subject_id',$StaffScheduleSubjectDetails->subject_id],['subject_schedule_id',$StaffScheduleSubjectDetails->subjectScheduleId],['date',date('Y/m/d',strtotime($StaffScheduleSubjectDetails->subject_day))],['to_time','!=',""]])->get();
        foreach ($StaffAttendances as $key => $StaffAttendance) {
            $totime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $StaffAttendance->to_time);
            $fromtime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $StaffAttendance->from_time);
            $diff_in_minutes = $totime->diffInMinutes($fromtime);
            $diff_in_hours = $totime->diffInHours($fromtime);
            $TakenTotalInMinutes += $diff_in_minutes;
            $TakenTotalInHours += $diff_in_hours;
        }
        $classtakenTotalmins = $TakenTotalInMinutes % 60;
        // $TakenTotalInMinutes = $TakenTotalInMinutes / 60;
        $classTakenTime = $TakenTotalInHours ."hrs:".$classtakenTotalmins."mins";

        $data['ForTotalTakenTime'] = $classTakenTime;

        $StudentAttendences = StudentAttendence::where([['student_id',$StaffScheduleSubjectDetails->studentId],['class',$StaffScheduleSubjectDetails->class],['section_id',$StaffScheduleSubjectDetails->section_id],['subject_id',$StaffScheduleSubjectDetails->subject_id],['subject_schedule_id',$StaffScheduleSubjectDetails->subjectScheduleId],['to_time','!=',""]])
        ->where('date',date('Y/m/d',strtotime($StaffScheduleSubjectDetails->subject_day)))
        ->get();
        $TotalInHours = 0;
        $TotalInMinutes = 0;
        $TakenTime = 0;
        $Totalmins = 0;

        foreach ($StudentAttendences as $key => $StudentAttendence) {
            $totime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $StudentAttendence->to_time);
            $fromtime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $StudentAttendence->from_time);
            $diff_in_minutes = $totime->diffInMinutes($fromtime);
            $diff_in_hours = $totime->diffInHours($fromtime);
            $TotalInMinutes += $diff_in_minutes;
            $TotalInHours += $diff_in_hours;
        }
        $Totalmins = $TotalInMinutes % 60;
        // $TotalInHours = $TotalInMinutes / 60;
        $str = strlen((string)$Totalmins);
        if($str == 1){
            $data['TakenTime'] = $TotalInHours ."hrs:0".$Totalmins."mins";
        }else{
            $data['TakenTime'] = $TotalInHours ."hrs:".$Totalmins."mins";
        }
        if($str == 1){
            $data['ForTotalAttendTime'] = $TotalInHours .".0".$Totalmins;
        }else{
            $data['ForTotalAttendTime'] = $TotalInHours .".".$Totalmins;
        }


        $PresentCount = 0;
        $AbsentCount = 0;
        $a = $classtakenTotalmins-10;
        if($Totalmins>=$a){
            $data['staus'] = "Present";
            $data['PresentCount'] = ++$PresentCount;
            $data['AbsentCount'] = $AbsentCount;
        }else{
            $data['staus'] = "Absent";
            $data['PresentCount'] = $PresentCount;
            $data['AbsentCount'] = ++$AbsentCount;
        }
        return $data;
    }
}

if (!function_exists('StaffSubjectAssignTime')) {
    function StaffSubjectAssignTime($StaffScedules){
        $TakenTotalInHours = 0;
        $TakenTotalInMinutes = 0;
        $classTakenTime = 0;
        $classtakenTotalmins = 0;
        $StaffAttendances = StaffScheduleSubjectDetails::where([['staff_id',$StaffScedules->StaffId],['subject_day',$StaffScedules->subject_day]])->get();
        foreach ($StaffAttendances as $key => $StaffAttendance) {
            $totime = \Carbon\Carbon::createFromFormat('H:i', $StaffAttendance->to_time);
            $fromtime = \Carbon\Carbon::createFromFormat('H:i', $StaffAttendance->from_time);
            $diff_in_minutes = $totime->diffInMinutes($fromtime);
            $diff_in_hours = $totime->diffInHours($fromtime);
            $TakenTotalInMinutes += $diff_in_minutes;
            $TakenTotalInHours += $diff_in_hours;
        }
        $classtakenTotalmins = $TakenTotalInMinutes % 60;
        return $classTakenTime = $TakenTotalInHours ."hrs:".$classtakenTotalmins."mins";

    }
}

if (!function_exists('StaffSubjectTotalAssignTime')) {
    function StaffSubjectTotalAssignTime($StaffScedules){
        $TakenTotalInHours = 0;
        $TakenTotalInMinutes = 0;
        $classTakenTime = 0;
        $classtakenTotalmins = 0;
        $StaffScedules;
        foreach ($StaffScedules as $key => $StaffScedule) {
            $StaffAttendances = StaffScheduleSubjectDetails::where([['staff_id',$StaffScedule->StaffId],['subject_day',$StaffScedule->subject_day]])->get();
            foreach ($StaffAttendances as $key => $StaffAttendance) {
                $totime = \Carbon\Carbon::createFromFormat('H:i', $StaffAttendance->to_time);
                $fromtime = \Carbon\Carbon::createFromFormat('H:i', $StaffAttendance->from_time);
                $diff_in_minutes = $totime->diffInMinutes($fromtime);
                $diff_in_hours = $totime->diffInHours($fromtime);
                $TakenTotalInMinutes += $diff_in_minutes;
                $TakenTotalInHours += $diff_in_hours;
            }
        }
        $classtakenTotalmins = $TakenTotalInMinutes % 60;
        return $classTakenTime = $TakenTotalInHours ."hrs:".$classtakenTotalmins."mins";

    }
}


if (!function_exists('staffClassTakenTime')) {
    function staffClassTakenTime($StaffScheduleSubjectDetails){
        $TotalInHours = 0;
        $TotalInMinutes = 0;
        $TakenTime = 0;
        $Totalmins = 0;
        foreach ($StaffScheduleSubjectDetails as $key => $StaffScheduleSubjectDetail) {
            $StaffAttendances = StaffAttendance::where([['staff_id',$StaffScheduleSubjectDetail->staff_id],['class',$StaffScheduleSubjectDetail->class],['section_id',$StaffScheduleSubjectDetail->section_id],['subject_id',$StaffScheduleSubjectDetail->subject_id],['date',date('Y/m/d',strtotime($StaffScheduleSubjectDetail->subject_day))],['to_time','!=',""]])->get();
            foreach ($StaffAttendances as $key => $StaffAttendance) {
                $totime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $StaffAttendance->to_time);
                $fromtime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $StaffAttendance->from_time);
                $diff_in_minutes = $totime->diffInMinutes($fromtime);
                $diff_in_hours = $totime->diffInHours($fromtime);
                $TotalInMinutes += $diff_in_minutes;
                $TotalInHours += $diff_in_hours;
            }
        }
        $Totalmins = $TotalInMinutes % 60;
        $TakenTime = $TotalInHours ."hrs:".$Totalmins."mins";
        return $TakenTime;
    }
}


if (!function_exists('StudentAttendance')) {
    function StudentAttendance($StudentAttendences){
        $StudentAttendences = StudentAttendence::where([['student_id',auth()->user()->user_id],['date',$StudentAttendences->date]])->get();
        $TotalInHours = 0;
        $TotalInMinutes = 0;
        $TakenTime = 0;
        $Totalmins = 0;

        foreach ($StudentAttendences as $key => $StudentAttendence) {
            $totime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $StudentAttendence->to_time);
            $fromtime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $StudentAttendence->from_time);
            $diff_in_minutes = $totime->diffInMinutes($fromtime);
            $diff_in_hours = $totime->diffInHours($fromtime);
            $TotalInMinutes += $diff_in_minutes;
            $TotalInHours += $diff_in_hours;
        }
        $Totalmins = $TotalInMinutes % 60;
        // $TotalInHours = $TotalInMinutes / 60;
        $str = strlen((string)$Totalmins);

        if($str == 1){
            $data['ForTotalAttendTime'] = $TotalInHours ."hrs:0".$Totalmins."mins";
        }else{
            $data['ForTotalAttendTime'] = $TotalInHours ."hrs:".$Totalmins."mins";
        }

        if($Totalmins>=30){
            $data['status'] = "Present";
        }else{
            $data['status'] = "Absent";
        }
        return $data;
    }
}

if (!function_exists('getData')) {
    function getData($val){
        return $val;
    }
}

if (!function_exists('getStaffScheduleDatetime')) {
    function getStaffScheduleDatetime($StaffScheduleClasses){
        return $StaffScheduleClasses;
    }
}

if (!function_exists('getQuestionCount')) {
    function getQuestionCount($chapterId){
        return $QuestionCount = Questions::where('chapter_id',$chapterId)->count();
    }
}

if (!function_exists('getQuestionSegregationCount')) {
    function getQuestionSegregationCount($chapterId,$preparation_type_id,$question_type_id,$segregation_id){
        return $QuestionCount = Questions::where([['chapter_id',$chapterId],['preparation_type_id',$preparation_type_id],['question_type_id',$question_type_id],['segregation_id',$segregation_id]])->count();
    }
}
if (!function_exists('getChapterSegregationPreperationTypeQuestionCount')) {
    function getChapterSegregationPreperationTypeQuestionCount($chapterId,$segregation_id){
		// return $chapterId.$segregation_id;
        return $QuestionCount = Questions::whereIn('chapter_id',$chapterId)->where([['segregation_id',$segregation_id]])->count();
    }
}
if (!function_exists('getSegregationQuestionCount')) {
    function getSegregationQuestionCount($segregation_id,$preperation_type){
		if(empty($preperation_type)){		
				return $QuestionCount = Questions::where([['segregation_id',$segregation_id]])->count();	
		}else{
        return $QuestionCount = Questions::where([['segregation_id',$segregation_id],['preparation_type_id',$preperation_type]])->count();
		}
	}
}

if (!function_exists('getpreperationQuestionCount')) {
    function getpreperationQuestionCount($chapter_id,$segregation_id,$preperation_type_id){
        if($preperation_type_id==0){
            return $QuestionCount = Questions::where([['chapter_id',$chapter_id],['segregation_id',$segregation_id],['preparation_type_id',$preperation_type_id]])->count('preparation_type_id');
        }else{
            return $QuestionCount = Questions::
        where([['chapter_id',$chapter_id],['segregation_id',$segregation_id],['preparation_type_id',$preperation_type_id]])
        ->count('preparation_type_id');
        }
    }
}

if (!function_exists('getChapterBasedQuestion')) {
    function getChapterBasedQuestion($TotalQuestion,$takenQuestion,$chapter_id,$segregation_id){
		// echo $takenQuestion;
        $data['count'] = $segregation_id;
        $data['Segregation'] = Segregation::find($segregation_id);
        $data['questionNumbers'] = UniqueRandomNumbersWithinRange(0,$TotalQuestion,$takenQuestion);
        $data['Questions'] = Questions::where([['chapter_id',$chapter_id],['segregation_id',$segregation_id]])->get();
		// print_r($data['Questions']);
		
        return $data;
    }
}
if (!function_exists('UniqueRandomNumbersWithinRange')) {
    function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
        $numbers = range($min, $max-1);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }
}
if (!function_exists('getChapterWiseSegregationCount')) {
    function getChapterWiseSegregationCount($chapter_id,$segregation_id){
        return $QuestionCount = Questions::where([['chapter_id',$chapter_id],['segregation_id',$segregation_id]])->count();
    }
}

if (!function_exists('getAutomtedSegregationQuestionCount')) {
    function getAutomtedSegregationQuestionCount($segregation_id,$chapter_id,$blueprint_id){
        return $AutomaticQuestionDetails=  AutomaticQuestionDetails::whereIn('chapter_id',$chapter_id)
			->where([['segregation_id',$segregation_id],['automatic_question_id',$blueprint_id]])
			->sum('question_count');
    }
}
if (!function_exists('get_segregation_marks')) {
    function get_segregation_marks($segregation_id){
        
		$totalmarksQuestionCount = Segregation::
		where([['segregations.id',$segregation_id]])
		->leftJoin('question_types','question_types.id','=','segregations.question_type_id')
		->get();		
		foreach($totalmarksQuestionCount as $question_marks){
			 $marks=$question_marks->question_type;
			 return $marks;
		}
		
	}
}
if (!function_exists('getSegregationBasedMarks')) {
    function getSegregationBasedMarks($segregation_id,$taken_questions){
        
		$totalmarksQuestionCount = Segregation::
		where([['segregations.id',$segregation_id]])
		->leftJoin('question_types','question_types.id','=','segregations.question_type_id')
		->get();		
		foreach($totalmarksQuestionCount as $question_marks){
			 $total=$question_marks->question_type * $taken_questions;
			 return $total;
		}
		
	}
}

if (!function_exists('getQuestionChaptrs')) {
    function getQuestionChaptrs($automaticQuestionId,$chapter_id){
        return AutomaticQuestionChapters::where([['automatic_question_id',$automaticQuestionId],['chapter_id',$chapter_id]])->first();
    }
}
if (!function_exists('getSegregationCountChapterBased')) {
    function getSegregationCountChapterBased($automaticQuestionId,$chapter_id){
        return AutomaticQuestionChapters::where([['automatic_question_id',$automaticQuestionId],['chapter_id',$chapter_id]])->first();
    }
}
if (!function_exists('getpreperationQuestionStoredCount')) {
    function getpreperationQuestionStoredCount($pattern_id,$segregation_id){
        // return $pattern_id.$segregation_id;
        return $QuestionCount = ChapterBasedQuestionDetails::
        where([['chapter_based_question_id',$pattern_id],['segregation_id',$segregation_id]])
        ->count('question_id');
    }
}
if (!function_exists('getpreperationAutomaticQuestionStoredCount')) {
    function getpreperationAutomaticQuestionStoredCount($chapter_id,$segregation_id,$preperation_type_id){
        // return $chapter_id.$segregation_id.$preperation_type_id;
         $QuestionCount = AutomaticQuestionDetails::where([['chapter_id',$chapter_id],['segregation_id',$segregation_id],['preparation_type_id',$preperation_type_id]])->first();
		// print_r($QuestionCount);
		return $QuestionCount;
   }
}
if (!function_exists('getpreperationQuestionStored')) {
    function getpreperationQuestionStored($id,$segregation_id){
        // echo $id;
       return $questions= ChapterBasedQuestionDetails::
						  where([['chapter_based_question_details.segregation_id',$segregation_id],['chapter_based_question_id',$id]])
						  ->leftJoin('chapter_based_questions','chapter_based_questions.id','=','chapter_based_question_details.chapter_based_question_id')
						  ->leftJoin('questions','questions.id','=','chapter_based_question_details.question_id')
						  ->get();
    }
}
if (!function_exists('getQuestionTotal')) {
    function getQuestionTotal($QuestionCount,$Marks){
        // return 1;
		// echo $Marks;
        return $QuestionCount * $Marks;
    }
}

if (!function_exists('getParentQuestions')) {
    function getParentQuestions($parent_question_id){
		
     return  Questions::where([['id',$parent_question_id]])->get()->toArray();
    }
}
if (!function_exists('returnAlphabets')) {
    function returnAlphabets($key){
		$alphabet = range('A', 'Z');
    return $alphabet[$key];
    }
}
if (!function_exists('getFontFamily')) {
    function getFontFamily(){
		return $data=array("Times New Roman","Arial","Verdana","Impact","Comic Sans MS","Book Antiqua","Trebuchet MS","Bookman Old Style","Source Sans Pro");
    }
}
if (!function_exists('getFontfontsizelineheight')) {
    function getFontfontsizelineheight(){
		return $data=array(18,20,22,24,26,28,30,32,34,36,38,40);
    }
}
if (!function_exists('getFontfontsize')) {
    function getFontfontsize(){
		return $data=array(11,12,13,14,15,16,17,18,19,20,21,22);
    }
}
if (!function_exists('getExamPacks')) {
    function getExamPacks(){
		return $data=array("NEET","BANKING","SCHOOL");
    }
}
if (!function_exists('checkAnswered')) {
    function checkAnswered($question_id,$exam_id){
		 $StudentAnswersubmit['studentanswer']= StudentAnswer::where([['exam_id',$exam_id],['question_id',$question_id],['student_id',auth()->user()->id]])->get()->first();
       print_r($StudentAnswersubmit['studentanswer']);
         return $StudentAnswersubmit['studentanswer'];
    }
}
if (!function_exists('getCompletedCount')) {
    function getCompletedCount($exam_id){
		return $QuestionCount = StudentAnswer::where([['student_id',auth()->user()->id],['exam_id',$exam_id]])->count();	
    }
}
if (!function_exists('getAttendedStudentList')) {
    function getAttendedStudentList($student_id,$exam_id){
		 $attendedlist = StudentAnswer::where([['student_id',$student_id],['exam_id',$exam_id]])
								->groupBy('student_id')
								->get()->toArray();	
								
			if (!empty($attendedlist)){
				$dataresult= "Attended";
			}else{
				$dataresult= "Absent";
			}
			return $dataresult;
    }
}
if (!function_exists('StoreQuestions')) {
    function StoreQuestions($question_id,$create_question_paper_id){
			$question_details=Questions::where('id',$question_id)->get()->first();
						$CreatedQuestions =new CreatedQuestions;
						$CreatedQuestions->create_question_paper_id=$create_question_paper_id;
						$CreatedQuestions->question_id=$question_details->id;
						$CreatedQuestions->segregation_id=$question_details->segregation_id;
						$CreatedQuestions->save();
					$QuestionPaperUi=new QuestionPaperUi;
					$QuestionPaperUi->create_question_paper_id=$create_question_paper_id;
					$QuestionPaperUi->font_family="Times New Roman";
					$QuestionPaperUi->font_size="14";
					$QuestionPaperUi->line_spacing="20";
					$QuestionPaperUi->question_spacing="20";
					$QuestionPaperUi->save();
	}
}

function sendSMS($message,$number){

    $username = "j.aravindhgopi@gmail.com";
    $hash = "e77c1cbdc7b6838cc5a8612ff67c676589d4eba5d37b957d486bfa8a081b0733";

    $test = "0";

    // Data for text message. This is the text message data.
    $sender = "TXTLCL"; // This is who the message appears to be from.
    $numbers = $number; // A single number or a comma-seperated list of numbers

    // 612 chars or less
    // A single number or a comma-seperated list of numbers
    $message = urlencode($message);
    $data = "username=" . $username . "&hash=" . $hash . "&message=" . $message . "&sender=" . $sender . "&numbers=" . $numbers . "&test=" . $test;
    $ch = curl_init('http://api.textlocal.in/send/?');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch); // This is the result from the API
    curl_close($ch);
}

function getReadableTime($time)
{
    return DateTime::createFromFormat('H:i', $time)->format('h:i:A');
}
