	@include('Layouts.BSM')

<div class="container">
	<div class="row">
		<div class="col-lg-9 col-md-">
			<div class="customDiv3">

</br></br></br></br>
<form method ="post" action = "{{ route('aural_and_accompaniment_to_pay', ['discipline' => $discipline, 'student' =>  $student, 'teacher' => $teacher]) }}">
{{ csrf_field() }}
<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
<td colspan ="3"; style="text-align:center";><b>Aural & Accompaniment</b></td>
</tr>
@foreach ($aural_and_accompaniment as $a_and_a)
<tr>
	<td><input type="checkbox" name="{{ $a_and_a->grades }}"></label></td><td>{{ $a_and_a->particulars }}</td><td>{{ $a_and_a->fees }}</td>	
</tr>
@endforeach
<td colspan = "4" style ="text-align : center"><input type="submit" name="a_and_a_add_to_dues" value="Add to Fees" /></td></tr>


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