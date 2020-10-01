<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\StaffScheduleSubjectDetails;
use App\Student;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        // $schedule->command('inspire')->hourly();
            // DB::enableQueryLog();
            $staffScheduleSubjectDetails = StaffScheduleSubjectDetails::whereDate('subject_day', '2020-07-28')
            ->select('*',DB::raw('count(class) as total_classes'))->groupBy('class','section_id')
                ->get();
                // dd(DB::getQueryLog());
                // dd($studentDetails);
            foreach($staffScheduleSubjectDetails as $schedule){
                try {
                    $class = $schedule->class;
                    $sectionId  = $schedule->section_id;
                    $totalClasses = $schedule->total_classes;
    
                    $studentDetails = Student::where('student_class',$class)->where('section_id',$sectionId)->get();
    
                    foreach($studentDetails as $student){
                        $message = "Good Morning! You have ".$totalClasses." class(es) today. Please do attend without fail!";
                        // sendSMS($message,$student->mobile_number);
                        Log::debug($message);
                    }
    
                } catch (\Exception $ex) {
                    return false; //enable to send SMS
                }
            }
            // dd("h");
            $staffDetails = StaffScheduleSubjectDetails::whereDate(
                'subject_day',
                date('Y-m-d')
                // '2020-07-22'
            )->select(
                '*',
                DB::raw("(GROUP_CONCAT(staff_schedule_subject_details.from_time SEPARATOR ',')) as `from_times`"),
                DB::raw("(GROUP_CONCAT(staff_schedule_subject_details.to_time SEPARATOR ',')) as `to_times`")
            )
                ->join('staff_schedule_classes', 'staff_schedule_subject_details.staff_schedule_class_id', 'staff_schedule_classes.id')
                ->join('staff', 'staff_schedule_classes.staff_id', 'staff.id')
                ->groupBy('staff_schedule_classes.staff_id')
                ->get();
            foreach ($staffDetails as $staff) {
                try {
                    $from_times = explode(",", $staff->from_times);
                    $to_times = explode(",", $staff->to_times);
                    $timeText = "";
                    foreach ($from_times as $key => $time) {
                        if ($key == 0) {
                            $timeText .= getReadableTime($from_times[$key]) . " - " . getReadableTime($to_times[$key]);
                        } else {
                            $timeText .= " , " . getReadableTime($from_times[$key]) . " - " . getReadableTime($to_times[$key]);
                        }
                    }
    
                    $message = "Good Morning! You have class(es) on today at " . $timeText . ". Please do prepare!";
                    // sendSMS($message,$staff->mobile_number);
                    Log::debug($message);
                    
                } catch (\Exception $ex) {
                    return false; //enable to send SMS
                }
            }
        
    
    }
}
