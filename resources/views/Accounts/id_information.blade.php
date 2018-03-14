
@include('Layouts.BSM')

<div class="container">
	<div class="row">
		<div class="col-lg-6 col-md-6">
			<div class="customDiv3">

</br></br></br> 
    
<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px"><td><b>Name</b></td><td><b>Teacher</b></tr>

@foreach ($list_of_students_without_id as $student_without_id)

@foreach ($student_without_id->getSearchDataName() as $student_data)


<tr>
<td><a href="{{ route('pgtwo', ['discipline' => $student_data->discipline, 'student' =>  $student_data->regi_no]) }}">{{$student_data->getStudentPersonalDetails()->stu_name}}</a></td>	
<td>{{ $student_data->getTeacherName() }}</td>
</tr>

@endforeach

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