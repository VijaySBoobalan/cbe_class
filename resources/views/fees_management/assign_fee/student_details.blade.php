<hr>
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Student Details</h5>
    </div>

    <div class="card-body">
        <div class="card card-table table-responsive shadow-0 mb-0">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input feeGroup" onchange="checkAll(this)" id="custom_checkbox_stacked_unchecked">
                                    <label class="custom-control-label" for="custom_checkbox_stacked_unchecked">checkAll</label>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($Students))
                        @foreach ($Students as $key=>$Student)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $Student->student_name }}</td>
                                <td>{{ $Student->student_class }}</td>
                                <td>{{ $Student->ClassSection->section }}</td>
                                <td colspan="2">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input feeGroup" id="custom_checkbox_stacked_unchecked{{ $key }}" value="{{ $Student->id }}"  name="student[student_id][]" required>
                                            <label class="custom-control-label" for="custom_checkbox_stacked_unchecked{{ $key }}"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <br>
        <hr>
        <div class="d-flex justify-content-end align-items-center">
            <button type="submit" class="btn btn-primary">Save<i class="icon-paperplane ml-2"></i></button>
        </div>
    </div>
</div>




