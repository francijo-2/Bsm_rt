@include('Layouts.BSM')

<div class="container">
	<div class="row">
		<div class="col-lg-8">
			<div class="customDiv3">

</br></br></br></br>

<a  href="#" class="btn btn-default btn-xs">Aural and Accompaniments</a>

<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
<td><b>Name of Student</b></td>
<td><b>Exam</b></td>
<td><b>Discipline</b></td>
<td><b>Teacher</b></td>
</tr>
@foreach ($query as $q)
<tr>
<td>{{ $q->getStudentDetails()->stu_name }}</td>
<td>{{ $q->getExamParticulars()->particulars }}</td>
<td>{{ $q->getDiscipline()->disciplines }}</td>
<td>{{ $q->getTeacher() }}</td>
</tr>


@endforeach

</table>

<script type="text/javascript">

        history.pushState(null, null, document.URL);
window.addEventListener('popstate', function () {
    history.pushState(null, null, document.URL);
	
	
});
	
    </script>

			</div><!--------------inside column------>
		</div><!--------------column class------>
	</div><!--------------row------>
   </div><!------------container---------> 