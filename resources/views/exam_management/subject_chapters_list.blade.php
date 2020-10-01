<style>
.subjectlists {
    background: #d2baba;
    border-radius: 6px;
    padding-left: 10px;
    padding-top: 1px;
    padding-bottom: 1px;
}
p.subject_name {
    font-size: 20px;
    padding-top: 3px;
    text-align: center;
}
</style>
	
	
			@foreach($subjects as $subject)
				<div class="col-lg-4">
					<div class="subject{{$subject->id}} subjectlists">
					<p class="subject_name">{{ $subject->subject_name }}</p><hr>
					@if(empty($subject->subjectChapters))
					No Chapters in this subject
					@endif
					@foreach($subject->subjectChapters as $chapters)
					<div class="checkbox">
					<label><input type="checkbox"class="subjects"name="chapters[{{ $chapters->id }}]" value="{{ $chapters->id }}">{{ $chapters->unit_name }}</label>
					</div>
					@endforeach
				</div>
				</div>
			@endforeach
	
	
