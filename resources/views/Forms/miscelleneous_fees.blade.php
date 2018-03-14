	@include('Layouts.BSM')

<div class="container">
	<div class="row">
		<div class="col-lg-9 col-md-">
			<div class="customDiv3">

</br></br></br></br>
<form method ="post" action = "{{ route('aural_and_accompaniment', ['discipline' => $discipline, 'student' =>  $student, 'teacher' => $teacher]) }}">
{{ csrf_field() }}
<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
<td colspan ="3"; style="text-align:center";><b>Aural & Accompaniment</b></td>
</tr>
@foreach ($miscelleneous_fees as $payments)
<tr>
	<td><input type="checkbox" name="{{ $payments->grades }}"></label></td><td>{{ $payments->particulars }}</td><td>{{ $payments->fees }}</td>	
</tr>
@endforeach
<td colspan = "4" style ="text-align : center"><input type="submit" name="miscelleneous_add_to_exams" value="Add to Fees" /></td></tr>


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