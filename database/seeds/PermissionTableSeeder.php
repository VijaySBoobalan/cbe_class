<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Data = [
            // ['name' => 'institution_view','slug_name' => 'View','guard_name'=>'web','description'=>'1','description_name'=>'Institution','created_at'=>now()],
            // ['name' => 'institution_create','slug_name' => 'Create','guard_name'=>'web','description'=>'1','description_name'=>'Institution','created_at'=>now()],
            // ['name' => 'institution_update','slug_name' => 'Update','guard_name'=>'web','description'=>'1','description_name'=>'Institution','created_at'=>now()],
            // ['name' => 'institution_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'1','description_name'=>'Institution','created_at'=>now()],

            ['name' => 'student_view','slug_name' => 'View','guard_name'=>'web','description'=>'2','description_name'=>'Student','created_at'=>now()],
            ['name' => 'student_create','slug_name' => 'Create','guard_name'=>'web','description'=>'2','description_name'=>'Student','created_at'=>now()],
            ['name' => 'student_update','slug_name' => 'Update','guard_name'=>'web','description'=>'2','description_name'=>'Student','created_at'=>now()],
            ['name' => 'student_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'2','description_name'=>'Student','created_at'=>now()],
            ['name' => 'all_section_student_view','slug_name' => 'All Section Student Details','guard_name'=>'web','description'=>'2','description_name'=>'Student','created_at'=>now()],
            ['name' => 'assigned_section_student_view','slug_name' => 'Assigned Section Student Details','guard_name'=>'web','description'=>'2','description_name'=>'Student','created_at'=>now()],

            ['name' => 'staff_view','slug_name' => 'View','guard_name'=>'web','description'=>'3','description_name'=>'Staff','created_at'=>now()],
            ['name' => 'staff_create','slug_name' => 'Create','guard_name'=>'web','description'=>'3','description_name'=>'Staff','created_at'=>now()],
            ['name' => 'staff_update','slug_name' => 'Update','guard_name'=>'web','description'=>'3','description_name'=>'Staff','created_at'=>now()],
            ['name' => 'staff_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'3','description_name'=>'Staff','created_at'=>now()],

            ['name' => 'roles_view','slug_name' => 'View','guard_name'=>'web','description'=>'4','description_name'=>'Roles','created_at'=>now()],
            ['name' => 'roles_create','slug_name' => 'Create','guard_name'=>'web','description'=>'4','description_name'=>'Roles','created_at'=>now()],
            ['name' => 'roles_update','slug_name' => 'Update','guard_name'=>'web','description'=>'4','description_name'=>'Roles','created_at'=>now()],
            ['name' => 'roles_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'4','description_name'=>'Roles','created_at'=>now()],

            ['name' => 'subject_view','slug_name' => 'View','guard_name'=>'web','description'=>'5','description_name'=>'Subject','created_at'=>now()],
            ['name' => 'subject_create','slug_name' => 'Create','guard_name'=>'web','description'=>'5','description_name'=>'Subject','created_at'=>now()],
            ['name' => 'subject_update','slug_name' => 'Update','guard_name'=>'web','description'=>'5','description_name'=>'Subject','created_at'=>now()],
            ['name' => 'subject_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'5','description_name'=>'Subject','created_at'=>now()],

            ['name' => 'staff_schedule_assign_view','slug_name' => 'View','guard_name'=>'web','description'=>'6','description_name'=>'Staff Schedule Assign','created_at'=>now()],
            ['name' => 'staff_schedule_assign_create','slug_name' => 'Create','guard_name'=>'web','description'=>'6','description_name'=>'Staff Schedule Assign','created_at'=>now()],
            ['name' => 'staff_schedule_assign_update','slug_name' => 'Update','guard_name'=>'web','description'=>'6','description_name'=>'Staff Schedule Assign','created_at'=>now()],
            ['name' => 'staff_schedule_assign_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'6','description_name'=>'Staff Schedule Assign','created_at'=>now()],

            ['name' => 'staff_schedule_view','slug_name' => 'View','guard_name'=>'web','description'=>'7','description_name'=>'Staff Schedule','created_at'=>now()],
            ['name' => 'staff_schedule_create','slug_name' => 'Create','guard_name'=>'web','description'=>'7','description_name'=>'Staff Schedule','created_at'=>now()],
            ['name' => 'staff_schedule_update','slug_name' => 'Update','guard_name'=>'web','description'=>'7','description_name'=>'Staff Schedule','created_at'=>now()],
            ['name' => 'staff_schedule_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'7','description_name'=>'Staff Schedule','created_at'=>now()],
            ['name' => 'total_schedule_view','slug_name' => 'Total Schedule View','guard_name'=>'web','description'=>'7','description_name'=>'Staff Schedule','created_at'=>now()],

            ['name' => 'class_section_view','slug_name' => 'View','guard_name'=>'web','description'=>'8','description_name'=>'Class / Section','created_at'=>now()],
            ['name' => 'class_section_create','slug_name' => 'Create','guard_name'=>'web','description'=>'8','description_name'=>'Class / Section','created_at'=>now()],
            ['name' => 'class_section_update','slug_name' => 'Update','guard_name'=>'web','description'=>'8','description_name'=>'Class / Section','created_at'=>now()],
            ['name' => 'class_section_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'8','description_name'=>'Class / Section','created_at'=>now()],

            ['name' => 'homework_view','slug_name' => 'View','guard_name'=>'web','description'=>'9','description_name'=>'Home Work','created_at'=>now()],
            ['name' => 'homework_create','slug_name' => 'Create','guard_name'=>'web','description'=>'9','description_name'=>'Home Work','created_at'=>now()],
            ['name' => 'homework_update','slug_name' => 'Update','guard_name'=>'web','description'=>'9','description_name'=>'Home Work','created_at'=>now()],
            ['name' => 'homework_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'9','description_name'=>'Home Work','created_at'=>now()],

            ['name' => 'fee_master_view','slug_name' => 'View','guard_name'=>'web','description'=>'10','description_name'=>'Fee Master','created_at'=>now()],
            ['name' => 'fee_master_create','slug_name' => 'Create','guard_name'=>'web','description'=>'10','description_name'=>'Fee Master','created_at'=>now()],
            ['name' => 'fee_master_update','slug_name' => 'Update','guard_name'=>'web','description'=>'10','description_name'=>'Fee Master','created_at'=>now()],
            ['name' => 'fee_master_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'10','description_name'=>'Fee Master','created_at'=>now()],

            ['name' => 'fee_type_view','slug_name' => 'View','guard_name'=>'web','description'=>'11','description_name'=>'Fee Type','created_at'=>now()],
            ['name' => 'fee_type_create','slug_name' => 'Create','guard_name'=>'web','description'=>'11','description_name'=>'Fee Type','created_at'=>now()],
            ['name' => 'fee_type_update','slug_name' => 'Update','guard_name'=>'web','description'=>'11','description_name'=>'Fee Type','created_at'=>now()],
            ['name' => 'fee_type_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'11','description_name'=>'Fee Type','created_at'=>now()],

            ['name' => 'fee_type_group_view','slug_name' => 'View','guard_name'=>'web','description'=>'12','description_name'=>'Fee Type Group','created_at'=>now()],
            ['name' => 'fee_type_group_create','slug_name' => 'Create','guard_name'=>'web','description'=>'12','description_name'=>'Fee Type Group','created_at'=>now()],
            ['name' => 'fee_type_group_update','slug_name' => 'Update','guard_name'=>'web','description'=>'12','description_name'=>'Fee Type Group','created_at'=>now()],
            ['name' => 'fee_type_group_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'12','description_name'=>'Fee Type Group','created_at'=>now()],
            ['name' => 'fee_type_assign_class','slug_name' => 'Class Fee Assign','guard_name'=>'web','description'=>'12','description_name'=>'Class Fee Assign','created_at'=>now()],

            ['name' => 'fee_assign_view','slug_name' => 'View','guard_name'=>'web','description'=>'13','description_name'=>'Fee Assign','created_at'=>now()],
            ['name' => 'fee_assign_create','slug_name' => 'Create','guard_name'=>'web','description'=>'13','description_name'=>'Fee Assign','created_at'=>now()],
            ['name' => 'fee_assign_update','slug_name' => 'Update','guard_name'=>'web','description'=>'13','description_name'=>'Fee Assign','created_at'=>now()],
            ['name' => 'fee_assign_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'13','description_name'=>'Fee Assign','created_at'=>now()],
            ['name' => 'fee_assign_student_list','slug_name' => 'Student List','guard_name'=>'web','description'=>'13','description_name'=>'Fee Assign','created_at'=>now()],

            ['name' => 'student_attendance_view','slug_name' => 'Student Attendance','guard_name'=>'web','description'=>'14','description_name'=>'Attendance','created_at'=>now()],
            ['name' => 'staff_attendance_view','slug_name' => 'Staff Attendance','guard_name'=>'web','description'=>'14','description_name'=>'Attendance','created_at'=>now()],
            ['name' => 'class_attendance_view','slug_name' => 'Class Attendance','guard_name'=>'web','description'=>'14','description_name'=>'Attendance','created_at'=>now()],

            ['name' => 'fee_view','slug_name' => 'Fee Collection View','guard_name'=>'web','description'=>'15','description_name'=>'Fee Collection','created_at'=>now()],
            ['name' => 'fee_collect','slug_name' => 'Fee Collect','guard_name'=>'web','description'=>'15','description_name'=>'Fee Collection','created_at'=>now()],
            ['name' => 'student_pay_fee','slug_name' => 'Student Pay Fee','guard_name'=>'web','description'=>'15','description_name'=>'Fee Collection','created_at'=>now()],

            ['name' => 'upload_videos','slug_name' => 'Upload Videos','guard_name'=>'web','description'=>'16','description_name'=>'Video Upload','created_at'=>now()],
            ['name' => 'view_videos','slug_name' => 'View Videos','guard_name'=>'web','description'=>'16','description_name'=>'Video Upload','created_at'=>now()],

            // ['name' => 'setting','slug_name' => 'Setting','guard_name'=>'web','description'=>'17','description_name'=>'Setting','created_at'=>now()],

            ['name' => 'preparation_type_view','slug_name' => 'View','guard_name'=>'web','description'=>'17','description_name'=>'Preparation Type','created_at'=>now()],
            ['name' => 'preparation_type_create','slug_name' => 'Create','guard_name'=>'web','description'=>'17','description_name'=>'Preparation Type','created_at'=>now()],
            ['name' => 'preparation_type_update','slug_name' => 'Update','guard_name'=>'web','description'=>'17','description_name'=>'Preparation Type','created_at'=>now()],
            ['name' => 'preparation_type_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'17','description_name'=>'Preparation Type','created_at'=>now()],

            ['name' => 'questions_type_view','slug_name' => 'View','guard_name'=>'web','description'=>'18','description_name'=>'Question Type','created_at'=>now()],
            ['name' => 'questions_type_create','slug_name' => 'Create','guard_name'=>'web','description'=>'18','description_name'=>'Question Type','created_at'=>now()],
            ['name' => 'questions_type_update','slug_name' => 'Update','guard_name'=>'web','description'=>'18','description_name'=>'Question Type','created_at'=>now()],
            ['name' => 'questions_type_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'18','description_name'=>'Question Type','created_at'=>now()],

            ['name' => 'questions_model_view','slug_name' => 'View','guard_name'=>'web','description'=>'19','description_name'=>'Question Modal','created_at'=>now()],
            ['name' => 'questions_model_create','slug_name' => 'Create','guard_name'=>'web','description'=>'19','description_name'=>'Question Modal','created_at'=>now()],
            ['name' => 'questions_model_update','slug_name' => 'Update','guard_name'=>'web','description'=>'19','description_name'=>'Question Modal','created_at'=>now()],
            ['name' => 'questions_model_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'19','description_name'=>'Question Modal','created_at'=>now()],

            ['name' => 'years_view','slug_name' => 'View','guard_name'=>'web','description'=>'20','description_name'=>'Year','created_at'=>now()],
            ['name' => 'years_create','slug_name' => 'Create','guard_name'=>'web','description'=>'20','description_name'=>'Year','created_at'=>now()],
            ['name' => 'years_update','slug_name' => 'Update','guard_name'=>'web','description'=>'20','description_name'=>'Year','created_at'=>now()],
            ['name' => 'years_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'20','description_name'=>'Year','created_at'=>now()],

            ['name' => 'chapter_view','slug_name' => 'View','guard_name'=>'web','description'=>'21','description_name'=>'Chapter','created_at'=>now()],
            ['name' => 'chapter_create','slug_name' => 'Create','guard_name'=>'web','description'=>'21','description_name'=>'Chapter','created_at'=>now()],
            ['name' => 'chapter_update','slug_name' => 'Update','guard_name'=>'web','description'=>'21','description_name'=>'Chapter','created_at'=>now()],
            ['name' => 'chapter_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'21','description_name'=>'Chapter','created_at'=>now()],
			
			['name' => 'batch_view','slug_name' => 'View','guard_name'=>'web','description'=>'22','description_name'=>'Batch','created_at'=>now()],
            ['name' => 'batch_create','slug_name' => 'Create','guard_name'=>'web','description'=>'22','description_name'=>'Batch','created_at'=>now()],
            ['name' => 'batch_update','slug_name' => 'Update','guard_name'=>'web','description'=>'22','description_name'=>'Batch','created_at'=>now()],
            ['name' => 'batch_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'22','description_name'=>'Batch','created_at'=>now()],

            ['name' => 'segregation_view','slug_name' => 'View','guard_name'=>'web','description'=>'23','description_name'=>'Segregation','created_at'=>now()],
            ['name' => 'segregation_create','slug_name' => 'Create','guard_name'=>'web','description'=>'23','description_name'=>'Segregation','created_at'=>now()],
            ['name' => 'segregation_update','slug_name' => 'Update','guard_name'=>'web','description'=>'23','description_name'=>'Segregation','created_at'=>now()],
            ['name' => 'segregation_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'23','description_name'=>'Segregation','created_at'=>now()],
			
			['name' => 'exam_management_view','slug_name' => 'View','guard_name'=>'web','description'=>'24','description_name'=>'Exam Management','created_at'=>now()],
            ['name' => 'exam_management_create','slug_name' => 'Create','guard_name'=>'web','description'=>'24','description_name'=>'Exam Management','created_at'=>now()],
            ['name' => 'exam_management_update','slug_name' => 'Update','guard_name'=>'web','description'=>'24','description_name'=>'Exam Management','created_at'=>now()],
            ['name' => 'exam_management_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'24','description_name'=>'Exam Management','created_at'=>now()],
           
			['name' => 'write_test_view','slug_name' => 'View','guard_name'=>'web','description'=>'25','description_name'=>'Write Test','created_at'=>now()],
			
			['name' => 'manage_question_view','slug_name' => 'View','guard_name'=>'web','description'=>'26','description_name'=>'Manage Questions','created_at'=>now()],
            ['name' => 'manage_question_create','slug_name' => 'Create','guard_name'=>'web','description'=>'26','description_name'=>'Manage Questions','created_at'=>now()],
            ['name' => 'manage_question_update','slug_name' => 'Update','guard_name'=>'web','description'=>'26','description_name'=>'Manage Questions','created_at'=>now()],
          
			['name' => 'automatic_question_view','slug_name' => 'View','guard_name'=>'web','description'=>'27','description_name'=>'Automatic Questions','created_at'=>now()],
			['name' => 'automatic_question_create','slug_name' => 'Create','guard_name'=>'web','description'=>'27','description_name'=>'Automatic Questions','created_at'=>now()],
			['name' => 'automatic_question_update','slug_name' => 'Update','guard_name'=>'web','description'=>'27','description_name'=>'Automatic Questions','created_at'=>now()],
			['name' => 'automatic_question_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'27','description_name'=>'Automatic Questions','created_at'=>now()],
			
			['name' => 'chapter_based_question_view','slug_name' => 'View','guard_name'=>'web','description'=>'28','description_name'=>'Chapter Based Questions','created_at'=>now()],
			['name' => 'chapter_based_question_create','slug_name' => 'Create','guard_name'=>'web','description'=>'28','description_name'=>'Chapter Based Questions','created_at'=>now()],
			['name' => 'chapter_based_question_update','slug_name' => 'Update','guard_name'=>'web','description'=>'28','description_name'=>'Chapter Based Questions','created_at'=>now()],
			['name' => 'chapter_based_question_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'28','description_name'=>'Chapter Based Questions','created_at'=>now()],
			
			['name' => 'question_paper_management_view','slug_name' => 'View','guard_name'=>'web','description'=>'29','description_name'=>'Question Paper MAnagement','created_at'=>now()],
			['name' => 'question_paper_management_create','slug_name' => 'Create','guard_name'=>'web','description'=>'29','description_name'=>'Question Paper MAnagement','created_at'=>now()],
			['name' => 'question_paper_management_update','slug_name' => 'Update','guard_name'=>'web','description'=>'29','description_name'=>'Question Paper MAnagement','created_at'=>now()],
			['name' => 'question_paper_management_delete','slug_name' => 'Delete','guard_name'=>'web','description'=>'29','description_name'=>'Question Paper MAnagement','created_at'=>now()],
		];

        $Admindata = [
            ['name' => 'student_view'],
            ['name' => 'student_create'],
            ['name' => 'student_update'],
            ['name' => 'student_delete'],
            ['name' => 'all_section_student_view'],
            // ['name' => 'assigned_section_student_view'],

            ['name' => 'staff_view'],
            ['name' => 'staff_create'],
            ['name' => 'staff_update'],
            ['name' => 'staff_delete'],

            ['name' => 'subject_view'],
            ['name' => 'subject_create'],
            ['name' => 'subject_update'],
            ['name' => 'subject_delete'],

            ['name' => 'roles_view'],
            ['name' => 'roles_create'],
            ['name' => 'roles_update'],
            ['name' => 'roles_delete'],

            ['name' => 'staff_schedule_assign_view'],
            ['name' => 'staff_schedule_assign_create'],
            ['name' => 'staff_schedule_assign_update'],
            ['name' => 'staff_schedule_assign_delete'],

            ['name' => 'staff_schedule_view'],
            ['name' => 'staff_schedule_create'],
            ['name' => 'staff_schedule_update'],
            ['name' => 'staff_schedule_delete'],
            ['name' => 'total_schedule_view'],

            ['name' => 'class_section_view'],
            ['name' => 'class_section_create'],
            ['name' => 'class_section_update'],
            ['name' => 'class_section_delete'],

            ['name' => 'homework_view'],
            ['name' => 'homework_create'],
            ['name' => 'homework_update'],
            ['name' => 'homework_delete'],

            ['name' => 'fee_master_view'],
            ['name' => 'fee_master_create'],
            ['name' => 'fee_master_update'],
            ['name' => 'fee_master_delete'],

            ['name' => 'fee_type_view'],
            ['name' => 'fee_type_create'],
            ['name' => 'fee_type_update'],
            ['name' => 'fee_type_delete'],

            ['name' => 'fee_type_group_view'],
            ['name' => 'fee_type_group_create'],
            ['name' => 'fee_type_group_update'],
            ['name' => 'fee_type_group_delete'],
            ['name' => 'fee_type_assign_class'],

            ['name' => 'fee_assign_view'],
            ['name' => 'fee_assign_create'],
            ['name' => 'fee_assign_update'],
            ['name' => 'fee_assign_delete'],
            ['name' => 'fee_assign_student_list'],

            ['name' => 'fee_view'],
            ['name' => 'fee_collect'],

            ['name' => 'student_attendance_view'],
            ['name' => 'staff_attendance_view'],
            ['name' => 'class_attendance_view'],

            ['name' => 'upload_videos'],
            ['name' => 'view_videos'],

            ['name' => 'preparation_type_view'],
            ['name' => 'preparation_type_create'],
            ['name' => 'preparation_type_update'],
            ['name' => 'preparation_type_delete'],

            ['name' => 'questions_type_view'],
            ['name' => 'questions_type_create'],
            ['name' => 'questions_type_update'],
            ['name' => 'questions_type_delete'],

            ['name' => 'questions_model_view'],
            ['name' => 'questions_model_create'],
            ['name' => 'questions_model_update'],
            ['name' => 'questions_model_delete'],

            ['name' => 'years_view'],
            ['name' => 'years_create'],
            ['name' => 'years_update'],
            ['name' => 'years_delete'],

            ['name' => 'chapter_view'],
            ['name' => 'chapter_create'],
            ['name' => 'chapter_update'],
            ['name' => 'chapter_delete'],

            ['name' => 'batch_view'],
            ['name' => 'batch_create'],
            ['name' => 'batch_update'],
            ['name' => 'batch_delete'],
             
            ['name' => 'segregation_view'],
            ['name' => 'segregation_create'],
            ['name' => 'segregation_update'],
            ['name' => 'segregation_delete'],
			
			['name' => 'exam_management_view'],
            ['name' => 'exam_management_create'],
            ['name' => 'exam_management_update'],
            ['name' => 'exam_management_delete'],
            
			
			['name' => 'write_test_view'],
			
			['name' => 'manage_question_view'],
			['name' => 'manage_question_create'],
			['name' => 'manage_question_update'],
			
			['name' => 'automatic_question_view'],
			['name' => 'automatic_question_create'],
			['name' => 'automatic_question_update'],
			['name' => 'automatic_question_delete'],
			
			['name' => 'chapter_based_question_view'],
			['name' => 'chapter_based_question_create'],
			['name' => 'chapter_based_question_update'],
			['name' => 'chapter_based_question_delete'],
			
			
			['name' => 'question_paper_management_view'],
			['name' => 'question_paper_management_create'],
			['name' => 'question_paper_management_update'],
			['name' => 'question_paper_management_delete'],

            // ['name' => 'setting'],

        ];

        $Staffdata = [
            ['name' => 'student_view'],
            ['name' => 'student_create'],
            ['name' => 'student_update'],
            ['name' => 'student_delete'],
            ['name' => 'assigned_section_student_view'],

            // ['name' => 'staff_view'],

            ['name' => 'staff_schedule_view'],

        ];

        $Studentdata = [
            ['name' => 'student_view'],
            ['name' => 'assigned_section_student_view'],
            ['name' => 'fee_view'],
        ];

        Permission::insert($Data);

        Role::find(1)->givePermissionTo($Admindata);

        Role::find(2)->givePermissionTo($Admindata);

        Role::find(3)->givePermissionTo($Staffdata);

        Role::find(4)->givePermissionTo($Studentdata);
    }
}
