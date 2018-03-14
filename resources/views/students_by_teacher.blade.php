
@include('Layouts.BSM')

<div class="container">
	<div class="row">
		<div class="col-lg-8 col-md-6">
			<div class="customDiv3">

</br></br></br>

<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px"><td><b>Roll No.</b></td><td><b>Name</b></td><td><b>Date Joined</b></td><td><b>Teacher</b></tr>


@foreach ($list_of_students as $q)

<tr>
	@if ($q->getConvertedDate() < 20090401)
	<td>BSM{{ $q->getStudentPersonalDetails()->serial_annualised }}/0{{ $q->getStudentPersonalDetails()->pre_no }}-0{{ $q->getStudentPersonalDetails()->post_no }}</td>
	@elseif ($q->getConvertedDate() < 20100401)
	<td>BSM{{ $q->getStudentPersonalDetails()->serial_annualised }}/0{{ $q->getStudentPersonalDetails()->pre_no }}-{{ $q->getStudentPersonalDetails()->post_no }}</td>
	@else
	<td>BSM{{ $q->getStudentPersonalDetails()->serial_annualised }}/{{ $q->getStudentPersonalDetails()->pre_no }}-{{ $q->getStudentPersonalDetails()->post_no }}</td>
	@endif
	<td><a href="{{ route('pgtwo', ['discipline' => $q->discipline, 'student' =>  $q->regi_no]) }}">{{ $q->getStudentPersonalDetails()->stu_name }}</a></td>	
	<td>{{ \Carbon\Carbon::parse($q->date_of_joining)->format('F Y') }}</td>
	<td>{{ $q->getTeacherName() }}</td>
</tr>


@endforeach
</table>


<script type="text/javascript">

        history.pushState(null, null, document.URL);
window.addEventListener('popstate', function () {
    history.pushState(null, null, document.URL);
	
	
});
	
    </script>

		  </div><!----container--------->
    	</div><!----row--------->
    </div><!----customDiv3--------->
</div><!----customDiv2--------->	