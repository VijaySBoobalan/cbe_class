<?php

use Illuminate\Support\Facades\Route;
use App\Events\Onlineclass;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

// // Authentication routes...
// Route::get('login', 'Auth\AuthController@showLoginForm');
// Route::post('login', 'Auth\AuthController@login');
// Route::get('logout', 'Auth\AuthController@getLogout');

// // Password reset link request routes...
// Route::get('password/email', 'Auth\PasswordController@getEmail');
// Route::post('password/email', 'Auth\PasswordController@postEmail');

// // Password reset routes...
// Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
// Route::post('password/reset', 'Auth\PasswordController@postReset');

// Route::get('/upload','HomeController@upload')->name('upload');
// Route::POST('/Store','HomeController@Store')->name('Storeupload');

Route::get('/test','RecordController@test')->name('test');


// Auth::routes(['verify' => true]);

// Route::namespace('Auth')->group(function(){
//     //Login Routes
//     Route::get('/login','LoginController@showLoginForm')->name('login');
//     Route::post('/login','LoginController@login');
//     Route::post('/logout','LoginController@logout')->name('logout');

//     //Forgot Password Routes
//     Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
//     Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');

//     //Reset Password Routes
//     Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
//     Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');

// });

Route::group(['middleware' => 'revalidate'], function () {
    Auth::routes(['verify' => true]);
});

Route::get('/code', 'Auth\OTPValidatioController@showCodeForm')->name('showCodeForm');

Route::post('/code', 'Auth\OTPValidatioController@storeCodeForm')->name('submitCodeForm');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/getStudentDetails', 'HomeController@getStudentDetails')->name('getStudentDetails');

    Route::resource('/students', 'StudentController');

    Route::post('/getStaffSection', 'StudentController@getStaffSection')->name('getStaffSection');

    Route::DELETE('/studentDelete', 'StudentController@delete')->name('Studentdelete');

    Route::get('/videoplay', 'StudentController@Playvideos')->name('Playvideos');

    // LIVE CLASS FUNCTIONALITIES START
    Route::get('/viewscreenshare/{id}', 'StudentController@viewscreenshare')->name('viewscreenshare');

    Route::post('/raise_question', 'NotificationController@raise_question');

    Route::post('/StudentAttendence', 'StudentAttendenceController@StudentAttendence')->name('StudentAttendence');

    Route::post('/ClassListening', 'StudentAttendenceController@ClassListening')->name('ClassListening');

    Route::post('/EndStudentAttendence', 'StudentAttendenceController@EndStudentAttendence')->name('EndStudentAttendence');

    Route::post('/StaffAttendence', 'StudentAttendenceController@StaffAttendence')->name('StaffAttendence');

    Route::get('/student-attendance', 'StudentAttendenceController@StudentIndex')->name('StudentIndex');

    Route::get('/class-attendace', 'StudentAttendenceController@ClassWiseAttendance')->name('ClassWiseAttendance');

    Route::get('/ClassWiseDetail', 'StudentAttendenceController@ClassWiseDetail')->name('ClassWiseDetail');

    Route::get('/StudentWiseDetail', 'StudentAttendenceController@StudentWiseDetail')->name('StudentWiseDetail');

    Route::get('/StudentList', 'StudentAttendenceController@StudentList')->name('StudentList');
	
    Route::get('/getAllStudents', 'StudentAttendenceController@getAllStudents')->name('getAllStudents');

    Route::get('/StaffClassDetail', 'StudentAttendenceController@StaffClassDetail')->name('StaffClassDetail');

    Route::get('/staff-attendance', 'StudentAttendenceController@StaffIndex')->name('StaffIndex');

    Route::get('/screenshare/{scheduleclass_id}/{class_id}/{section_id}/{subject_id}', 'StaffController@screenshare')->name('screenshare');

    Route::post('/send-live-notification', 'NotificationController@sendnotify');

    Route::post('/stop-live', 'NotificationController@stop_online');

    Route::post('/studentAttendenceEnd', 'NotificationController@studentAttendenceEnd')->name('studentAttendenceEnd');

    Route::post('/receive-live-notification', 'NotificationController@receivenotify');

    Route::post('/upload_record', 'RecordController@store');
    // LIVE CLASS FUNCTIONALITIES END

     // HOMEWORK FUNCTIONALITIES START
    Route::get('homework', 'HomeworkController@index');

    Route::post('post_student_homework', 'HomeworkController@student_homework');

    Route::post('addhomework', 'HomeworkController@save_homework')->name('AddHomework');

    Route::get('classhomework', 'HomeworkController@classhomework')->name('ClassHomework');

    Route::get('getclasslist', 'HomeworkController@getclasslist')->name('GetClassList');

    Route::get('getsectionlist', 'HomeworkController@getsectionlist')->name('GetSectionList');

    Route::get('getsubjectlist', 'HomeworkController@getsubjectlist')->name('GetSubjectList');

    Route::get('classhomework', 'HomeworkController@classhomework')->name('ClassHomework');

    Route::get('edithomework', 'HomeworkController@edithomework')->name('editHomework');

    Route::post('deletehomework', 'HomeworkController@deletehomework')->name('DeleteHomework');

    Route::post('updatehomework', 'HomeworkController@updatehomework')->name('UpdateHomework');

    Route::get('studenthomework', 'HomeworkController@studenthomework')->name('StudentHomework');

    Route::post('changehomeworkstatus', 'HomeworkController@changehomeworkstatus')->name('ChangeHomeworkStatus');

    Route::get('editstudenthomework', 'HomeworkController@editstudenthomework')->name('EditStudentHomework');

    Route::post('getStudent', 'StudentController@getStudent')->name('getStudent');

    Route::post('getindividualstudenthomework', 'HomeworkController@getindividualstudenthomework')->name('GetIndividualStudentHomework');

    Route::post('submithomework', 'StudentController@submithomework')->name('SubmitHomework');
      // HOMEWORK FUNCTIONALITIES END

	  //CHAT CONTROLLER
	 Route::post('getChats', 'ChatController@getChats')->name('getChats');

	 Route::post('SendChatMessage', 'ChatController@SendChatMessage')->name('SendChatMessage');
	  //CHAT CONTROLLER END
    Route::post('/password_reset', 'PasswordResetController@passwordReset')->name('passwordReset');

    Route::post('/ViewerfilesUpload', 'ShareScreenFilesController@ViewerfilesUpload')->name('ViewerfilesUpload');

    Route::post('/ViewerimagesUpload', 'ShareScreenFilesController@ViewerimagesUpload')->name('ViewerimagesUpload');

    Route::post('/VideofilesUpload', 'ShareScreenFilesController@VideofilesUpload')->name('VideofilesUpload');

    Route::get('/getDocumentList', 'ShareScreenFilesController@getDocumentList')->name('getDocumentList');

    Route::get('/getImageList', 'ShareScreenFilesController@getImageList')->name('getImageList');

    Route::delete('/DeleteDocument', 'ShareScreenFilesController@DeleteDocument')->name('DeleteDocument');

    Route::delete('/DeleteImage', 'ShareScreenFilesController@DeleteImage')->name('DeleteImage');

    Route::delete('/DeleteVideo', 'ShareScreenFilesController@DeleteVideo')->name('DeleteVideo');

    Route::get('/getVideoList', 'ShareScreenFilesController@getVideoList')->name('getVideoList');

    Route::get('/receivenew-live-notification', 'NotificationController@new_notify');

    Route::resource('/staff', 'StaffController');

    Route::resource('/staff-subject-assign', 'StaffSubjectAssignController');

    Route::get('/staff-subject-edit', 'StaffSubjectAssignController@EditStaffSubject')->name('EditStaffSubject');

    Route::POST('/staff-subject-update', 'StaffSubjectAssignController@UpdateStaffSubject')->name('UpdateStaffSubject');

    Route::delete('/staff-subject-delete', 'StaffSubjectAssignController@DeleteStaffSubject')->name('DeleteStaffSubject');

    Route::resource('/master/roles', 'master\RoleController');

    Route::POST('/master/roles/update', 'master\RoleController@UpdateRole')->name('UpdateRole');

    Route::DELETE('/master/roles/delete', 'master\RoleController@DeleteRole')->name('DeleteRole');

    Route::resource('/master/permission', 'master\PermissionController', ['except' => ['destroy']]);

    Route::POST('/master/permission/update', 'master\PermissionController@UpdatePermission')->name('UpdatePermission');

    Route::DELETE('/master/permission/delete', 'master\PermissionController@DeletePermission')->name('DeletePermission');

    Route::resource('/master/subjects', 'master\SubjectController');

    Route::POST('/master/subject/update', 'master\SubjectController@UpdateSubject')->name('UpdateSubject');

    Route::DELETE('/master/subject/delete', 'master\SubjectController@DeleteSubject')->name('DeleteSubject');

    Route::get('/master/class-section', 'master\ClassSectionController@index')->name('ClassSectionIndex');

    Route::get('/master/class-section/create', 'master\ClassSectionController@create')->name('ClassSectionCreate');

    Route::POST('/master/class-section/store', 'master\ClassSectionController@storeSection')->name('storeSection');

    Route::get('/master/class-section/edit', 'master\ClassSectionController@editSection')->name('editSection');

    Route::POST('/master/class-section/update', 'master\ClassSectionController@UpdateSection')->name('UpdateSection');

    Route::DELETE('/master/class-section/delete', 'master\ClassSectionController@DeleteSection')->name('DeleteSection');

    Route::get('/master/class-section/getSection', 'master\ClassSectionController@getSection')->name('getSection');

    Route::get('/master/question-type', 'master\QuestionTypeController@index')->name('QuestionTypeIndex');

    Route::get('/master/question-type/create', 'master\QuestionTypeController@create')->name('QuestionTypeCreate');

    Route::POST('/master/question-type/store', 'master\QuestionTypeController@QuestionTypestore')->name('QuestionTypestore');

    Route::get('/master/question-type/edit', 'master\QuestionTypeController@QuestionTypeedit')->name('QuestionTypeedit');

    Route::POST('/master/question-type/update', 'master\QuestionTypeController@QuestionTypeUpdate')->name('QuestionTypeUpdate');

    Route::DELETE('/master/question-type/delete', 'master\QuestionTypeController@QuestionTypeDelete')->name('QuestionTypeDelete');

    Route::get('/master/segregation', 'master\SegregationController@index')->name('SegregationIndex');

    Route::get('/master/segregation/create', 'master\SegregationController@create')->name('SegregationCreate');

    Route::POST('/master/segregation/store', 'master\SegregationController@Segregationstore')->name('Segregationstore');

    Route::get('/master/segregation/edit', 'master\SegregationController@Segregationedit')->name('Segregationedit');

    Route::POST('/master/segregation/update', 'master\SegregationController@SegregationUpdate')->name('SegregationUpdate');

    Route::DELETE('/master/segregation/delete', 'master\SegregationController@SegregationDelete')->name('SegregationDelete');

    Route::get('/master/question-model', 'master\QuestionModelController@index')->name('QuestionModelIndex');

    Route::get('/master/question-model/create', 'master\QuestionModelController@create')->name('QuestionModelCreate');

    Route::POST('/master/question-model/store', 'master\QuestionModelController@QuestionModelstore')->name('QuestionModelstore');

    Route::get('/master/question-model/edit', 'master\QuestionModelController@QuestionModeledit')->name('QuestionModeledit');

    Route::POST('/master/question-model/update', 'master\QuestionModelController@QuestionModelUpdate')->name('QuestionModelUpdate');

    Route::DELETE('/master/question-model/delete', 'master\QuestionModelController@QuestionModelDelete')->name('QuestionModelDelete');

    Route::get('/master/year', 'master\YearsController@index')->name('YearIndex');
	
    Route::get('/master/year/create', 'master\YearsController@create')->name('YearCreate');

    Route::POST('/master/year/store', 'master\YearsController@Yearstore')->name('Yearstore');

    Route::get('/master/year/edit', 'master\YearsController@Yearedit')->name('Yearedit');

    Route::POST('/master/year/update', 'master\YearsController@YearUpdate')->name('YearUpdate');

    Route::DELETE('/master/year/delete', 'master\YearsController@YearDelete')->name('YearDelete');
	
    Route::get('/master/batch', 'master\BatchController@index')->name('BatchIndex');
     
    Route::Post('/master/batch/store', 'master\BatchController@Batchstore')->name('Batchstore'); 

    Route::get('/master/batch/edit', 'master\BatchController@Batchedit')->name('Batchedit');

    Route::POST('/master/batch/update', 'master\BatchController@BatchUpdate')->name('BatchUpdate');

    Route::DELETE('/master/batch/delete', 'master\BatchController@BatchDelete')->name('BatchDelete');

    Route::get('/onlinetest-schedule', 'OnlineTestScheduleController@index')->name('OnlineTestIndex');
	
    Route::get('get-exam-events', 'OnlineTestScheduleController@getExamEvents')->name('getExamEvents');

    Route::POST('/onlinetest-store', 'OnlineTestScheduleController@OnlineTeststore')->name('OnlineTeststore');
    
    Route::get('/onlinetest-edit', 'OnlineTestScheduleController@OnlineTestedit')->name('OnlineTestedit');
    
    Route::POST('/onlinetest-update', 'OnlineTestScheduleController@OnlineTestUpdate')->name('OnlineTestUpdate');

    Route::DELETE('/onlinetest-delete', 'OnlineTestScheduleController@OnlineTestDelete')->name('OnlineTestDelete');
    
    Route::get('/master/preparation-type', 'master\PreparationTypesController@index')->name('PreparationTypeIndex');

    Route::get('/master/preparation-type/create', 'master\PreparationTypesController@create')->name('PreparationTypeCreate');

    Route::POST('/master/preparation-type/store', 'master\PreparationTypesController@PreparationTypestore')->name('PreparationTypestore');

    Route::get('/master/preparation-type/edit', 'master\PreparationTypesController@PreparationTypeedit')->name('PreparationTypeedit');

    Route::POST('/master/preparation-type/update', 'master\PreparationTypesController@PreparationTypeUpdate')->name('PreparationTypeUpdate');

    Route::DELETE('/master/preparation-type/delete', 'master\PreparationTypesController@PreparationTypeDelete')->name('PreparationTypeDelete');

    Route::get('/staff-schedule', 'StaffScheduleController@StaffScheduleIndex')->name('StaffScheduleIndex');

    Route::get('/total-schedule', 'StaffScheduleController@TotalSchedule')->name('TotalSchedule');

    Route::get('/total-schedule-list', 'StaffScheduleController@TotalScheduleList')->name('TotalScheduleList');

    Route::get('/getStudentAttendanceDetails', 'HomeController@getStudentAttendanceDetails')->name('getStudentAttendanceDetails');

    Route::get('/staff-schedule/create', 'StaffScheduleController@StaffScheduleCreate')->name('StaffScheduleCreate');

    Route::post('/staff-schedule/store', 'StaffScheduleController@StaffScheduleStore')->name('StaffScheduleStore');

    Route::get('/staff-schedule/edit', 'StaffScheduleController@StaffScheduleEdit')->name('StaffScheduleEdit');

    Route::get('/staff-schedule/render', 'StaffScheduleController@StaffScheduleRender')->name('StaffScheduleRender');

    Route::post('/staff-schedule/update', 'StaffScheduleController@StaffScheduleUpdate')->name('StaffScheduleUpdate');

    Route::delete('/staff-schedule/delete', 'StaffScheduleController@StaffScheduleDelete')->name('StaffScheduleDelete');

    Route::get('/{class}/{subject}/play','Dashboard\StudentDashboardController@playVideo')->name('PlayClassVideos');

    Route::resource('/institution', 'InstitutionController');

    Route::post('/institution/update', 'InstitutionController@UpdateInstitution');

    Route::DELETE('/institutions/delete', 'InstitutionController@DeleteInstitution')->name('institutionDelete');

    Route::get('geometry_tab',function(){
        return view('geometry_tab');
    });

    Route::view('graphingTool','graphingTool');

    Route::resource('fee-masters','FeesManagement\FeesMasterController');

    Route::resource('fee-type','FeesManagement\FeesTypeController');

    Route::resource('fee-type-group','FeesManagement\FeesGroupController');

    Route::get('FeeGroupDetails','FeesManagement\FeesGroupController@FeeGroupDetails')->name('FeeGroupDetails');

    Route::resource('fee-assigned','FeesManagement\FeesAssignDepartmentController');

    Route::get('getClassSection','FeesManagement\FeesAssignDepartmentController@getClassSection');

    Route::resource('schloarship-acadamic','FeesManagement\ScholarshipAcadamicController');

    Route::resource('student-fee-assign','FeesManagement\StudentAssignFeesController');

    Route::GET('SearchDepartment','FeesManagement\StudentAssignFeesController@SearchDepartment')->name('SearchDepartment');

    Route::GET('showStudentList/{id}','FeesManagement\StudentAssignFeesController@showStudentList');

    Route::resource('fee-collection','FeesManagement\FeesCollectionController')->except([
        'show'
    ]);

    Route::get('fee-collection/{studentid}/{class_id}','FeesManagement\FeesCollectionController@show');

    Route::get('fee-collection/{studentid}/{class_id}/{Feesgroupid}/add','FeesManagement\FeesCollectionController@AddFees');

    Route::get('fee-collections/{studentid}/{Feesgroupid}/multipleprint','FeesManagement\FeesCollectionController@multipleprint')->name('multipleprint');

    // Route::get('fee-collection/{Feesgroupid}/singleprint',function(){
    //     return 1;
    // });
    Route::get('fee-collections/{Feesgroupid}/singleprint','FeesManagement\FeesCollectionController@singleprint')->name('singleprint');

    Route::get('date-wise-fee-data','FeesManagement\FeesCollectionController@dateWiseFeeData')->name('dateWiseFeeData');
    Route::resource('video_records','RecordController');
    Route::post('filterVideos','RecordController@filterVideos');
    Route::post('validateVideo','RecordController@validateVideo');
    Route::post('filterStudentVideos','RecordController@filterStudentVideos');

    Route::get('Payment', [
        // 'as' => 'subscribe-process',
        'uses' => 'PayuMoneyController@SubscribProcess'
    ])->name('SubscribProcess');


    Route::get('fee-amount', [
        'uses' => 'PayuMoneyController@Feeamount'
    ])->name('Feeamount');


    Route::POST('subscribe-cancel', [
        // 'as' => 'subscribe-cancel',
        'uses' => 'PayuMoneyController@SubscribeCancel'
    ]);

    Route::POST('subscribe-response', [
        // 'as' => 'subscribe-response',
        'uses' => 'PayuMoneyController@SubscribeResponse'
    ]);

    Route::get('stripe', 'StripePaymentController@stripe');
    Route::resource('settings','SettingsController');
    // Route::post('settings','SettingsController@store')->name('settings_store');


    Route::get('chapter','master\ChapterController@getAllStaff');

    Route::get('view-chapter','master\ChapterController@viewStafflist');

    Route::get('staff_assigned_subject','master\ChapterController@staff_assigned_subject');

    Route::get('add_chapter','master\ChapterController@AddChapter');

    Route::get('view_staff_subject','master\ChapterController@view_staff_subject');

    Route::get('view_chapter','master\ChapterController@ViewChapter');

    Route::get('edit_chapter','master\ChapterController@EditChapter');

    Route::POST('save_chapter','master\ChapterController@SaveChapter');

    Route::POST('update_chapter','master\ChapterController@UpdateChapter');

    Route::get('questions/subject/{id}','ManageQuestions\QuestionsController@addQuestion')->name('addnewQuestion');

    Route::get('questions/subject','ManageQuestions\QuestionsController@index')->name('QuestionIndex');

    Route::get('question/subjects','ManageQuestions\QuestionsController@QuestionSubjects')->name('QuestionSubjects');
    
	Route::get('getclasssubjects','master\SubjectController@getClasssubjects')->name('getClasssubjects');
	
	
	
    //AUTOMATIC QUESTIONS 
    Route::get('question/automatic-questionsindex','ManageQuestions\AutomaticQuestionController@test')->name('test');

    Route::get('question/automatic-questions','ManageQuestions\AutomaticQuestionController@automatic_questions_view')->name('AutomaticQuestion');
	
    Route::get('question/add-automatic-questions','ManageQuestions\AutomaticQuestionController@AddAutomaticQuestion')->name('AddAutomaticQuestion');
	
	Route::post('question/store-automatic-questions','ManageQuestions\AutomaticQuestionController@AutomaticQuestionStore')->name('AutomaticQuestionStore');
	
	Route::post('automatic-question/update/{id}','ManageQuestions\AutomaticQuestionController@update')->name('AutomaticQuestionUpdate');
	
	Route::post('question/get-segregation-total','ManageQuestions\AutomaticQuestionController@GetSegregationTotal')->name('GetSegregationTotal');
	
    Route::get('automatic-questions/edit/{id}','ManageQuestions\AutomaticQuestionController@editAutomaticQuestions')->name('editAutomaticQuestions');
		 
    Route::get('getQuestionDetails','ManageQuestions\AutomaticQuestionController@getQuestionDetails')->name('getQuestionDetails');
	
	//CHAPTER BASED QUESTIONS
	Route::get('question/chapter-based-questions','ManageQuestions\ChapterBasedQuestionController@ChapterBasedQuestion')->name('ChapterBasedQuestion');
        
	Route::get('questions/chapter-questions/{id}/{class_id}','ManageQuestions\ChapterBasedQuestionController@ChapterQuestionDetails')->name('ChapterQuestionDetails');
	
	Route::get('prepare-question','ManageQuestions\ChapterBasedQuestionController@prepareQuestion')->name('prepareQuestion');
	
	Route::get('change-question','ManageQuestions\ChapterBasedQuestionController@changeQuestion')->name('changeQuestion');
	
	Route::get('replace-question','ManageQuestions\ChapterBasedQuestionController@replaceQuestion')->name('replaceQuestion');
	
	Route::get('add-question','ManageQuestions\ChapterBasedQuestionController@addQuestion')->name('addQuestion');
	
	Route::post('question-instructions','ManageQuestions\ChapterBasedQuestionController@Question_instructions')->name('Question_instructions');
	
	Route::get('chapter-question-list','ManageQuestions\ChapterBasedQuestionController@ChapterBasedQuestionList')->name('ChapterBasedQuestionList');
	
	Route::get('chapter-question-edit/{id}','ManageQuestions\ChapterBasedQuestionController@ChapterBasedQuestionedit')->name('ChapterBasedQuestionedit');
	
	Route::get('chapter-question-segregation_edit/{id}/{segregationId}','ManageQuestions\ChapterBasedQuestionController@ChapterquestioneditSegregation')->name('ChapterquestioneditSegregation');
	
	Route::get('chapter-question-perview','ManageQuestions\ChapterBasedQuestionController@ChapterBasedQuestionpreview')->name('ChapterBasedQuestionpreview');
	
	Route::get('chapter-question-delete/{id}','ManageQuestions\ChapterBasedQuestionController@ChapterBasedQuestiondelete')->name('ChapterBasedQuestiondelete');
	
	Route::post('chapter-question-update','ManageQuestions\ChapterBasedQuestionController@UpdateChapterbaseddetails')->name('UpdateChapterbaseddetails');
	
	Route::get('subject-chapter-list/{id}/{class_id}','ManageQuestions\ChapterBasedQuestionController@getSubjectChapterList')->name('getSubjectChapterList');
	
	
	// Route::resource('chapter-based-question','ManageQuestions\ChapterBasedQuestionController');
	
	//CHAPTER BASED QUESTIONS END
	
	//QUESTION PAPER MANAGEMENT
	Route::get('question-paper-lists','QuestionPaperManage\CreateQuestionPaperController@QuestionPaperLists')->name('QuestionPaperLists');
	
	Route::get('create-question-paper','QuestionPaperManage\CreateQuestionPaperController@CreateQuestionPaper')->name('CreateQuestionPaper');
	
	Route::get('get-exam-questions','QuestionPaperManage\CreateQuestionPaperController@GetManualQuestions')->name('GetManualQuestions');
	
	Route::post('show-exam-questions','QuestionPaperManage\CreateQuestionPaperController@ShowQuestions')->name('ShowQuestions');
	
	Route::get('/question-paper-store/{id}', 'QuestionPaperManage\CreateQuestionPaperController@ChapterBasedQuestionstore')->name('ChapterBasedQuestionstore');
	
	Route::get('store-examquestion-instructions', 'QuestionPaperManage\CreateQuestionPaperController@StoreExamQuestionInstructions')->name('StoreExamQuestionInstructions');
	
	Route::get('update-examquestion-instructions', 'QuestionPaperManage\CreateQuestionPaperController@UpdateExamQuestionInstructions')->name('UpdateExamQuestionInstructions');
	
	Route::get('exam-question-preview/{id}','QuestionPaperManage\CreateQuestionPaperController@exam_questionpreview')->name('exam_questionpreview');
	
	Route::get('exam-question-edit/{id}','QuestionPaperManage\CreateQuestionPaperController@exam_questionedit')->name('exam_questionedit');
	
	Route::get('exam-question-delete/{id}','QuestionPaperManage\CreateQuestionPaperController@exam_questiondelete')->name('exam_questiondelete');
	
	Route::get('preview-edit','QuestionPaperManage\CreateQuestionPaperController@Previewedit')->name('Previewedit');
	
	Route::get('question-paper-print','QuestionPaperManage\CreateQuestionPaperController@QuestionPaperprint')->name('QuestionPaperprint');
	
	Route::get('automatic-question-get','QuestionPaperManage\CreateQuestionPaperController@GetAutomatedQuestions')->name('GetAutomaticQuestions');
	
	Route::get('add-new-question','QuestionPaperManage\CreateQuestionPaperController@Getnewquestions')->name('Getnewquestions');
	
	Route::get('store-new-question','QuestionPaperManage\CreateQuestionPaperController@StoreNewQuestion')->name('StoreNewQuestion');
	
	Route::get('replace-new-question','QuestionPaperManage\CreateQuestionPaperController@ReplaceNewQuestion')->name('ReplaceNewQuestion');
	
	Route::get('GetPrintData','QuestionPaperManage\CreateQuestionPaperController@GetPrintData')->name('GetPrintData');
	
	Route::get('UpdateQuestionPaperUi','QuestionPaperManage\CreateQuestionPaperController@UpdateQuestionPaperUi')->name('UpdateQuestionPaperUi');
	
	Route::get('getPreviewDatas','QuestionPaperManage\CreateQuestionPaperController@getPreviewDatas')->name('getPreviewDatas');
	//QUESTION PAPER MANAGEMENT END
    
    //EXAM MANAGEMENT
    
    Route::get('view_exams','ExamManagement\ExamManagementController@index');
	
	Route::get('/exams/{id}', 'ExamManagement\ExamManagementController@Exams')->name('Exams');
	
	Route::get('/create_exam/{id}', 'ExamManagement\ExamManagementController@CreateExam')->name('CreateExam');
	
	Route::get('get_chapters', 'ExamManagement\ExamManagementController@get_chapters')->name('get_chapters');
	
	Route::get('getExamQuestions', 'ExamManagement\ExamManagementController@getExamQuestions')->name('getExamQuestions');
	
	Route::POST('storeExamQuestions', 'ExamManagement\ExamManagementController@storeExamQuestions')->name('storeExamQuestions');
	
	Route::get('/allocate/{id}', 'ExamManagement\ExamManagementController@AllocateExam')->name('AllocateExam');
	
	Route::get('get_batch_students', 'ExamManagement\ExamManagementController@get_batch_students')->name('get_batch_students');
	
	Route::get('StoreAllocations', 'ExamManagement\ExamManagementController@StoreAllocations')->name('StoreAllocations');
	
	// Route::get('/allocate/{id}', 'ExamManagement\ExamManagementController@AllocateExam')->name('AllocateExam');
   
	Route::get('write_test', 'Student\StudentExamController@write_test')->name('write_test');
	
	Route::post('checkpassword', 'Student\StudentExamController@checkpassword')->name('checkpassword');
	
	Route::get('/start_exam/{id}', 'Student\StudentExamController@start_exam')->name('start_exam');
	
	// Route::get('JumptoQuestion', 'Student\StudentExamController@JumptoQuestion')->name('JumptoQuestion');
	
	Route::get('submitAnswer', 'Student\StudentExamController@submitAnswer')->name('submitAnswer');
	
	Route::get('finish-exam', 'Student\StudentExamController@FinishExam')->name('FinishExam');
	
	Route::get('updateAnswer', 'Student\StudentExamController@updateAnswer')->name('updateAnswer');
	
	Route::get('/viewstudent_answer/{exam_id}/{student_id}', 'Student\StudentExamController@Viewstudent_answer')->name('Viewstudent_answer');
	
	Route::get('submit-report', 'Student\StudentExamController@submiteexamReport')->name('submiteexamReport');
	
	Route::get('/view-exam-report/{exam_id}', 'ExamManagement\ExamManagementController@ViewExamReport')->name('ViewExamReport');
	
	Route::get('/view-myexam-report/{exam_id}', 'Student\StudentExamController@viewMyExamReport')->name('viewMyExamReport');

   //EXAM MANAGEMENT END
    Route::get('questions/view-chapter/{id}','ManageQuestions\QuestionsController@QuestionView')->name('QuestionView');

    Route::get('questions/view/{id}','ManageQuestions\QuestionsController@ViewQuestion')->name('ViewQuestion');

    Route::POST('questions/edit','ManageQuestions\QuestionsController@EditQuestion')->name('EditQuestion');

    Route::POST('questions/store','ManageQuestions\QuestionsController@store')->name('Questionstore');

    Route::POST('questions/update','ManageQuestions\QuestionsController@QuestionUpdate')->name('QuestionUpdate');

    Route::get('getSegregation','ManageQuestions\QuestionsController@getSegregation')->name('getSegregation');
    
	


    Route::POST('questions/view/details', ['as' => 'QuestionDetails', 'uses' => 'ManageQuestions\QuestionsController@QuestionDetails']);
	
	
});

Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');

Route::get('payment/success/{student_id}', 'StripePaymentController@afterPaymentLogin')->name('paymentSuccess');

//Student Login
Route::prefix('/student')->name('student.')->namespace('Student')->group(function(){


    Route::namespace('Auth')->group(function(){

        //Login Routes
        Route::get('/login','LoginController@showLoginForm')->name('login');
        Route::post('/login','LoginController@login')->name('login.submit');
        Route::post('/logout','LoginController@logout')->name('logout');

        //Register Routes
        // Route::get('/register','RegisterController@showRegistrationForm')->name('register');
        // Route::post('/register','RegisterController@register');

        //Forgot Password Routes
        Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');

        //Reset Password Routes
        Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');

        // Email Verification Route(s)
        Route::get('email/verify','VerificationController@show')->name('verification.notice');
        Route::get('email/verify/{id}','VerificationController@verify')->name('verification.verify');
        Route::get('email/resend','VerificationController@resend')->name('verification.resend');

    });

    Route::get('/dashboard','HomeController@index')->name('home')->middleware('guard.verified:student,student.verification.notice');

});
