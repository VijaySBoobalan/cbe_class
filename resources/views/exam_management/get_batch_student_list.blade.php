	<style>
	p.batch_name {
    font-size: 20px;
    text-transform: capitalize;
    text-align: center;
    border: 1px;
    background: #e8d7d7;
}
	</style>
	
	
	<div class="row batchinformations">
	
	<div class="batchdetails{{ $getBatch->id }}">
	
	<input type="hidden"name="batchdetails[batch_id][]"value="{{ $getBatch->id }}">
	<p class="batch_name">{{ $getBatch->batch_name }}</p>
	<div class="col-lg-12">
	<div class="form-group">
	<label>Select Students</label>
	<select id="students" name="batchdetails[students][{{ $getBatch->id }}][]" multiple="multiple" class="form-control students">
		@foreach($studentlist as $key=>$students)
			<option value="{{ $students->student_id }}">{{ $students->name }}</option>
		@endforeach
     </select>
	</div>
	</div>
	<div class="col-lg-4">
	<div class="form-group">
	<label>Start Date</label>
	<input type="date"name="batchdetails[start_date][]"class="form-control">
	</div>
	</div>
	<div class="col-lg-4">
	<div class="form-group">
	<label>End Date</label>
	<input type="date"name="batchdetails[end_date][]"class="form-control">
	</div>
	</div>
	<div class="col-lg-4">
	<div class="form-group">
	<label>Password</label>
	<input type="text"name="batchdetails[password][]"class="form-control">
	</div>
	</div>
	</div>
	
	</div>

	<script>
	$(document).ready(function(){
 $('.students').multiselect({
  nonSelectedText: 'Select Students',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'400px'
 });
 });
 </script>