<aside id="sidebar">
    <div id="sidebar-wrap">
        <div class="panel-group slim-scroll" role="tablist">
            <div class="panel panel-default">
                <div id="sidebarNav" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <ul id="navigation">

                            <li class="@yield('dashboard')"><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>

                            @if(auth()->user()->hasRole('super_admin'))
                                <li class="@yield('view_institution')"><a href="{{ action('InstitutionController@index') }}"><i class="fa fa-building"></i><span>Institution</span></a></li>
                            @endif

                            @if(auth()->user()->can('class_section_view') || auth()->user()->can('subject_view') || auth()->user()->can('subject_create') || auth()->user()->can('roles_view') || auth()->user()->can('roles_create') )
                                <li class="@yield('master_menu')">
                                    <a role="button" tabindex="0"><i class="fa fa-list"></i><span>Master</span></a>
                                    <ul>
                                        @can('class_section_view')
                                            <li class="@yield('view_class_section')"><a href="{{ action('master\ClassSectionController@index') }}"><i class="fa fa-caret-right"></i>Class / Section</a></li>
                                        @endcan

                                        @can('subject_view')
                                            <li class="@yield('view_subject')"><a href="{{ action('master\SubjectController@index') }}"><i class="fa fa-caret-right"></i>Subject</a></li>
                                        @endcan

                                        @can('roles_view')
                                            <li class="@yield('view_roles')"><a href="{{ action('master\RoleController@index') }}"><i class="fa fa-caret-right"></i>Roles</a></li>
                                        @endcan
                                    </ul>
                                </li>
                            @endif

                            @if(auth()->user()->can('preparation_type_view') || auth()->user()->can('questions_type_view') || auth()->user()->can('questions_model_view') || auth()->user()->can('years_view') || auth()->user()->can('chapter_view') || auth()->user()->can('chapter_create') || auth()->user()->can('segregation_view') )
                                <li class="@yield('online_test_master_menu')">
                                    <a role="button" tabindex="0"><i class="fa fa-list"></i><span>Online Test Master</span></a>
                                    <ul>
                                        @can('preparation_type_view')
                                            <li class="@yield('view_preparation_type')"><a href="{{ route('PreparationTypeIndex') }}"><i class="fa fa-caret-right"></i>Preparation Type</a></li>
                                        @endcan

                                        @can('questions_type_view')
                                            <li class="@yield('view_questions_type')"><a href="{{ route('QuestionTypeIndex') }}"><i class="fa fa-caret-right"></i>Questions Type</a></li>
                                        @endcan

                                        @can('segregation_view')
                                            <li class="@yield('view_segregation')"><a href="{{ route('SegregationIndex') }}"><i class="fa fa-caret-right"></i>Segregation</a></li>
                                        @endcan

                                        @can('questions_model_view')
                                            <li class="@yield('view_questions_model')"><a href="{{ route('QuestionModelIndex') }}"><i class="fa fa-caret-right"></i>Question Model</a></li>
                                        @endcan

                                        @can('years_view')
                                            <li class="@yield('view_years')"><a href="{{ route('YearIndex') }}"><i class="fa fa-caret-right"></i>Year</a></li>
                                        @endcan
										@can('batch_view')
                                            <li class="@yield('batch_view')"><a href="{{ route('BatchIndex') }}"><i class="fa fa-caret-right"></i>Batch</a></li>
                                        @endcan
                                        <li class="@yield('onlinetest_view')"><a href="{{ route('OnlineTestIndex') }}"><i class="fa fa-caret-right"></i>Online Test Schedule</a></li>
                                        <li class="dropdown @yield('chapter_menu')">
                                            <a href="#"><i class="fa fa-caret-right"></i>Chapter</a>
                                            <ul class="submenu" style="display: @yield('chapter_open_menu_display');">
                                                @can('chapter_create')
                                                    @if(auth()->user()->user_type == 'Staff')
                                                        <li class="@yield('add_chapter')"><a href="{{ URL('staff_assigned_subject?id='.auth()->user()->user_id) }}"><i class="fa fa-caret-right"></i>Add Chapter</a></li>
                                                    @else
                                                        <li class="@yield('add_chapter')"><a href="{{ URL('chapter') }}"><i class="fa fa-caret-right"></i>Add Chapter</a></li>
                                                    @endif
                                                @endcan

                                                @can('chapter_view')
                                                    @if(auth()->user()->user_type == 'Staff')
                                                        <li class="@yield('view_chapter')"><a href="{{ URL('view_staff_subject?id='.auth()->user()->user_id) }}"><i class="fa fa-caret-right"></i>View Chapter</a></li>
                                                    @else
                                                        <li class="@yield('view_chapter')"><a href="{{ URL('view_chapter') }}"><i class="fa fa-caret-right"></i>View Chapter</a></li>
                                                    @endif
                                                @endcan
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            @if(auth()->user()->can('staff_view') || auth()->user()->can('staff_create') )
                                <li  class="@yield('staff_menu')">
                                    <a role="button" tabindex="0"><i class="fa fa-list"></i> <span>Staff</span></a>
                                    <ul>
                                        @can('staff_create')
                                            <li class="@yield('add_staff')"><a href="{{ action('StaffController@create') }}"><i class="fa fa-caret-right"></i>Add Staff</a></li>
                                        @endcan
                                        @can('staff_view')
                                        <li class="@yield('view_staff')"><a href="{{ action('StaffController@index') }}"><i class="fa fa-caret-right"></i>View Staff</a></li>
                                        @endcan
                                    </ul>
                                </li>
                            @endif

                            @if(auth()->user()->can('student_create') || auth()->user()->can('student_view') )
                                <li  class="@yield('student_menu')">
                                    <a role="button" tabindex="0"><i class="fa fa-list"></i> <span>Student</span></a>
                                    <ul>
                                        @can('student_create')
                                            <li class="@yield('add_student')"><a href="{{ action('StudentController@create') }}"><i class="fa fa-caret-right"></i>Add Student</a></li>
                                        @endcan
                                        @can('student_view')
                                            <li class="@yield('view_student')"><a href="{{ action('StudentController@index') }}"><i class="fa fa-caret-right"></i>View Student</a></li>
                                        @endcan
                                    </ul>
                                </li>
                            @endif

                            @if(auth()->user()->can('staff_schedule_assign_view') || auth()->user()->can('staff_schedule_assign_create') )
                                <li class="@yield('staff_subject_assign')"><a href="{{ action('StaffSubjectAssignController@index') }}"><i class="fa fa-dashboard"></i><span>Staff Subject Assign</span></a></li>
                            @endif

                            @if(auth()->user()->can('staff_schedule_view') || auth()->user()->can('staff_schedule_create') || auth()->user()->can('total_schedule_view') )
                                <li class="dropdown @yield('schedule_open_menu')">
                                    <a href="#"><i class="fa fa-book"></i><span>Schedule</span></a>
                                    <ul>
                                        @if(auth()->user()->can('staff_schedule_view') || auth()->user()->can('staff_schedule_create') )
                                            <li class="@yield('staff_schedule')"><a href="{{ route('StaffScheduleIndex') }}"><i class="fa fa-dashboard"></i><span>Staff Schedule</span></a></li>
                                        @endif
                                        @can('total_schedule_view')
                                        <li class="@yield('total_schedule')"><a href="{{ route('TotalSchedule') }}"><i class="fa fa-dashboard"></i><span>Total Schedule</span></a></li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan

                            @if(auth()->user()->can('homework_create') || auth()->user()->can('homework_view') )
                                <li class="@yield('homework')"><a href="{{ url('homework') }}"><i class="fa fa-dashboard"></i><span>Homework</span></a></li>
                            @endif

                            @if(auth()->user()->can('upload_videos') || auth()->user()->can('view_videos') )
                                <li class="dropdown @yield('upload_videos_menu')">
                                    <a href="#"><i class="fa fa-video-camera"></i><span>Records</span></a>
                                    <ul class="submenu" style="display: @yield('upload_videos_menu');">
                                        @can('upload_videos')
                                            <li class="@yield('upload_videos')"><a href="{{ action('RecordController@create') }}"><i class="fa fa-cloud-upload"></i>Uploads</a></li>
                                        @endcan
                                        @can('view_videos')
                                            <li class="@yield('view_videos')"><a href="{{ action('RecordController@index') }}"><i class="fa fa-play"></i>Watch</a></li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
                            @if(auth()->user()->can('student_attendance_view') || auth()->user()->can('staff_attendance_view') )
                                <li  class="@yield('attendance_menu')">
                                    <a role="button" tabindex="0"><i class="fa fa-list"></i> <span>Attendance</span></a>
                                    <ul>
                                        @can('class_attendance_view')
                                            <li class="@yield('class_attandance')"><a href="{{ route('ClassWiseAttendance') }}"><i class="fa fa-caret-right"></i>Class Wise Attendance</a></li>
                                        @endcan
                                        @can('student_attendance_view')
                                            <li class="@yield('student_attandance')"><a href="{{ route('StudentIndex') }}"><i class="fa fa-caret-right"></i>Student Wise Attendance</a></li>
                                        @endcan
                                        @can('staff_attendance_view')
                                            <li class="@yield('staff_attandance')"><a href="{{ route('StaffIndex') }}"><i class="fa fa-caret-right"></i>Staff Attandance</a></li>
                                        @endcan
                                    </ul>
                                </li>
                            @endif

                            @if(auth()->user()->can('fee_master_view') || auth()->user()->can('fee_master_create') || auth()->user()->can('fee_type_view') || auth()->user()->can('fee_type_create') || auth()->user()->can('fee_type_group_view') || auth()->user()->can('fee_type_group_create') || auth()->user()->can('fee_assign_view') || auth()->user()->can('fee_view')  || auth()->user()->can('fee_collect')  || auth()->user()->can('student_pay_fee') )
                                <li class="dropdown @yield('fees_master_open_menu')">
                                    <a href="javascript:"><i class="fa fa-magic"></i> <span>Fees Management</span></a>
                                    <ul class="submenu" style="display: @yield('fees_master_open_menu_display');">

                                        @if(auth()->user()->can('fee_master_view') || auth()->user()->can('fee_master_create') )
                                            <li class="@yield('add_fees_master_details')"><a href="{{ action('FeesManagement\FeesMasterController@create') }}"><i class="fa fa-caret-right"></i>Add Fees Master</a></li>
                                        @endif

                                        @if(auth()->user()->can('fee_type_view') || auth()->user()->can('fee_type_create') )
                                            <li class="dropdown @yield('fee_type_details_open_menu')">
                                                <a href="#"><i class="fa fa-caret-right"></i>Fee Type</a>
                                                <ul class="submenu" style="display: @yield('fee_type_details_open_menu_disply');">
                                                    @can('fee_type_create')
                                                        <li class="@yield('add_fee_type_details')"><a href="{{ action('FeesManagement\FeesTypeController@create') }}"><i class="fa fa-caret-right"></i>Add Fee Type</a></li>
                                                    @endcan
                                                    @can('fee_type_view')
                                                        <li class="@yield('view_fee_type_details')"><a href="{{ action('FeesManagement\FeesTypeController@index') }}"><i class="fa fa-caret-right"></i>View Fee Type</a></li>
                                                    @endcan
                                                </ul>
                                            </li>
                                        @endif
                                        @if(auth()->user()->can('fee_type_group_view') || auth()->user()->can('fee_type_group_create') )
                                            <li class="dropdown @yield('fee_type_group_open_menu')">
                                                <a href="#"><i class="fa fa-caret-right"></i>Fee Type Group</a>
                                                <ul class="submenu" style="display: @yield('fee_type_group_open_menu_display');">
                                                    @can('fee_type_group_create')
                                                        <li class="@yield('add_fee_type_group')"><a href="{{ action('FeesManagement\FeesGroupController@create') }}"><i class="fa fa-caret-right"></i>Add Fee Type Group</a></li>
                                                    @endcan
                                                    @can('fee_type_group_view')
                                                        <li class="@yield('view_fee_type_group')"><a href="{{ action('FeesManagement\FeesGroupController@index') }}"><i class="fa fa-caret-right"></i>View Fee Type Group</a></li>
                                                    @endcan
                                                    {{-- @can(['fee_assign_view','fee_assign_create','fee_assign_update','fee_assign_delete'])
                                                        <li class="@yield('view_assigned_department')"><a href="{{ action('FeesManagement\FeesAssignDepartmentController@index') }}"><i class="fa fa-caret-right"></i>View Assigned Class</a></li>
                                                    @endcan --}}
                                                </ul>
                                            </li>
                                        @endcan

                                            {{-- <li class="dropdown @yield('scholarship_open_menu')">
                                                <a href="#"><i class="fa fa-caret-right"></i>Scholarship Acadamic Master</a>
                                                <ul class="submenu" style="display: @yield('scholarship_display');">
                                                    <li class="@yield('add_scholarship')"><a href="{{ action('FeesManagement\ScholarshipAcadamicController@create') }}"><i class="fa fa-caret-right"></i>Add Acadamic Master</a></li>
                                                    <li class="@yield('view_scholarship')"><a href="{{ action('FeesManagement\ScholarshipAcadamicController@index') }}"><i class="fa fa-caret-right"></i>View Acadamic Master</a></li>
                                                </ul>
                                            </li> --}}
                                            
                                            {{-- <li class="dropdown @yield('student_scholarship_open_menu')">
                                                <a href="#"><i class="fa fa-caret-right"></i>Scholarship Student List</a>
                                                <ul class="submenu" style="display: @yield('student_scholarship_display');">
                                                    <li class="@yield('add_student_scholarship')"ws><a href="{{ action('FeesManagement\StudentScholarShipController@create') }}"><i class="fa fa-caret-right"></i>Add Student Scholarship</a></li>
                                                </ul>
                                            </li> --}}
                                            @if(auth()->user()->can('fee_assign_view') || auth()->user()->can('fee_assign_create') )
                                                <li class="dropdown @yield('assign_fee_open_menu')">
                                                    <a href="#"><i class="fa fa-caret-right"></i>Fee Assign</a>
                                                    <ul class="submenu" style="display: @yield('assign_fee_open_menu_display');">
                                                        @can('fee_type_group_create')
                                                            <li class="@yield('fee_assign_create')"><a href="{{ action('FeesManagement\StudentAssignFeesController@create') }}"><i class="fa fa-caret-right"></i>Assign Fee</a></li>
                                                        @endcan
                                                        @can('fee_assign_view')
                                                            <li class="@yield('view_assign_fee')"><a href="{{ action('FeesManagement\StudentAssignFeesController@index') }}"><i class="fa fa-caret-right"></i>View Fee Assigned</a></li>
                                                        @endcan
                                                    </ul>
                                                </li>
                                            @endcan

                                            {{-- <li class="dropdown @yield('fee_collection_open_menu')"> --}}
                                                {{-- <a href="#"><i class="fa fa-caret-right"></i>Fee Collection</a> --}}
                                                {{-- <ul class="submenu" style="display: @yield('fee_collection_display');"> --}}
                                                @if(auth()->user()->can('fee_view') || auth()->user()->can('fee_collect') || auth()->user()->can('student_pay_fee') )
                                                    <li class="@yield('add_fee_collection')"><a href="{{ action('FeesManagement\FeesCollectionController@create') }}"><i class="fa fa-caret-right"></i>Fee Collection</a></li>
                                                @endif
                                                {{-- </ul> --}}
                                            {{-- </li> --}}
                                    </ul>
                                </li>
                                @if(auth()->user()->hasRole('super_admin'))
                                    <li class="@yield('settings')"><a href="{{action('SettingsController@create')}}"><i class="fa fa-cog"></i><span>Settings</span></a></li>
                                @endif


                                {{-- @if(auth()->user()->can('question_view') || auth()->user()->can('question_create') ) --}}
                               
									
                                {{-- @endif --}}

                            @endif
							 @if(auth()->user()->can('manage_question_view')) 
                                    <li class="@yield('question_menu')">
                                        <a role="button" tabindex="0"><i class="fa fa-list"></i> <span>Manage Questions</span></a>
                                        <ul>
											@can('manage_question_create') 
                                                <li class="@yield('question_create')"><a href="{{ route('QuestionIndex') }}"><i class="fa fa-caret-right"></i>Add Questions</a></li>
                                                <li class="@yield('question_view')"><a href="{{ route('QuestionSubjects') }}"><i class="fa fa-caret-right"></i>View Questions</a></li>
                                                
                                            @endcan
              
                                        </ul>
                                    </li>
								@endif
								@if(auth()->user()->can('automatic_question_view')) 
									<li  class="@yield('automatic_question_menu')">
                                        <a role="button" tabindex="0"><i class="fa fa-list"></i> <span>Automatic Questions</span></a>
                                        <ul>
                                            @can('automatic_question_view')
                                                
                                                <li class="@yield('automatic_question_view')"><a href="{{ route('AutomaticQuestion') }}"><i class="fa fa-caret-right"></i>Automatic Questions</a></li>
                                                
                                            @endcan 
                                           
                                        </ul>
                                    </li>
								@endif
								@if(auth()->user()->can('chapter_based_question_view')) 
									<li  class="@yield('chapterbsed_question_menu')">
                                        <a role="button" tabindex="0"><i class="fa fa-list"></i> <span>Chapter Based Questions</span></a>
                                        <ul>
                                            @can('chapter_based_question_view')
                                               
                                                <li class="@yield('overview_chapter_based_questions')"><a href="{{ route('ChapterBasedQuestionList') }}"><i class="fa fa-caret-right"></i>Chapter Questions List </a></li>
                                                
											@endcan 
                                           
                                        </ul>
                                    </li>
								@endif
								@if(auth()->user()->can('question_paper_management_view')) 
									<li  class="@yield('question_paper_management')">
                                        <a role="button" tabindex="0"><i class="fa fa-list"></i> <span>Question Paper Management</span></a>
                                        <ul>
                                            @can('question_paper_management_view') 
                                               
                                                <li class="@yield('question_paper_views')"><a href="{{ route('QuestionPaperLists') }}"><i class="fa fa-caret-right"></i>Question Papers</a></li>
                                               
                                            @endcan
                                           
                                        </ul>
                                    </li>
                                @endif
							@if(auth()->user()->can('exam_management_view')) 
							 <li  class="@yield('exam_management')">
                                        <a role="button" tabindex="0"><i class="fa fa-list"></i> <span>Exam Management</span></a>
                                        <ul>
                                            
                                            @can('exam_management_view')   
                                            <li class="@yield('question_paper_views')"><a href="{{ url('view_exams') }}"><i class="fa fa-caret-right"></i>Exams</a></li>
                                             @endcan    
                                          
                                            
                                        </ul>
                                    </li>
							 @endif
							 
							 @if(auth()->user()->can('write_test_view')) 
							<li class="@yield('write_test')">
									<a href="{{ Route('write_test') }}"><i class="fa fa-list"></i>Write Test</a>
							</li>
							 @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>
