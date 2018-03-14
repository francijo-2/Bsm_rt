@include('Layouts.BSM')

<div class="container">
	<div class="row">
		<div class="col-lg-9 col-md-">
			<div class="customDiv3">

</br></br></br></br>
<form method ="post" action = "{{ route('enter_trinity_theory', ['discipline' => $discipline, 'student' =>  $student, 'teacher' => $teacher]) }}">
{{ csrf_field() }}
<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
<td colspan ="2"; style="text-align:center";><b>Trinity Theory</b></td></tr>


<td><select name="exam_code"><option value="">Choose Exam</option>
@foreach ($exams as $exam)
<option value="{{ $exam->exam_no }}">{{ $exam->exam_name }}</option>
@endforeach
</td>

<td><select name="grade_selection"><option value="">Select Grade</option>
@foreach ($grades as $grade)
<option value="{{ $grade->grades }}">{{ $grade->particulars }}</option>
@endforeach
</td>
<input type="hidden" name="user" value="{{ Auth::user()->id }}"></tr><tr>
<td colspan = "4" style ="text-align : center"><input type="submit" name="trinity_theory_add_to_exams" value="Add to Exams" /></td></tr>







 			</div><!----container--------->
    	</div><!----row--------->
    </div><!----customDiv3--------->
</div><!----customDiv2--------->	