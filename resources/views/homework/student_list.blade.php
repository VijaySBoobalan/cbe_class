
<div class="modal fade showStudentListModal" id="showStudentListModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">

                <div class="col-md-12">

                    <section class="tile">
                        <input type="hidden"name="assigned_homework_id"id="assigned_homework_id">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Student List</h1>
                            <table class="table">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>View</th>
                                </tr>
                                <tbody class="assigned_homeworks"></tbody>
                            </table>
                        </div>

                        <div class="tile-body">


                        </div>

                    </section>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade showStudentHomeworkSubmits" id="showStudentHomeworkSubmits" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">

                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Student Homeworks</h1>

                        </div>
                        <div class="error"></div>
                        <div class="tile-body status_div">
                            <p>Submitted On: <b id="submitted_on"></b></p>
                            <p>Status: <b id="status"></b></p>
                            <div class="row">
							<div class="col-md-4">
                                <div class="form-group">
                                   <input type="text"class="form-control "placeholder="Mark"name="Mark"id="mark">
                                    </div>
                            </div>
                            <div class="col-md-12">

                            <div class="col-md-4">
                            <form method="post" accept-charset="utf-8" name="form1">
							@csrf
                                <input name="hidden_data" id='hidden_data' type="hidden"/>
                            </form> <a href="#"class="delete_element">X</a>
								<canvas id="student_upload_file"width=400 height=400></canvas>
                            </div>
                            </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                   <input type="text"class="form-control"placeholder="Remark"name="remark"id="remark">
                                    </div>
                            </div>
                                <button class="btn btn-warning change_homework_status"data-student_id=""data-homework_id=""data-homework_status="Remarked">Remark</button>
                            </div>
                        </div>
                    <div class="tile-footer text-center bg-tr-black lter dvd dvd-top status_div">
                       <button type="submit"class="btn btn-primary change_homework_status"data-student_id=""data-homework_id=""data-homework_status="Approved">Approve</button>
                       <button class="btn btn-danger change_homework_status"data-student_id=""data-homework_id=""data-homework_status="Disapproved">Disapprove</button>

                    </div>

                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
