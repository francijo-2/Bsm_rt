	



@include('Layouts.BSM')

<div class="container">
	<div class="row">
		<div class="col-lg-6 col-md-6">
			<div class="customDiv3">

</br></br></br>
@if (!empty($hh))

<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px"><td><b>Name</b></td><td><b>Discipline</b></tr>

@foreach ($hh as $h)

@foreach ($h->getSearchDataName() as $s)


<tr>
<td><a href="{{ route('pgtwo', ['discipline' => $s->discipline, 'student' =>  $s->regi_no]) }}">{{ $h->stu_name }}</a></td>	
<td>{{ $s->getNameOfDiscipline() }}</td>
</tr>
@endforeach
@endforeach
</table>

<?php exit; ?>
@endif

@if ($late_fee_payment == 1)
<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
	<td>PLEASE UPDATE LATE FEE LIST</td>
</tr>
@endif

<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px"><td><b>Discipline</b></td><td><b>Strength</b></tr>




@foreach ($query as $q)
<tr>
<td><a href="{{ route('pgone', ['discipline' => $q->discipline_id]) }}">{{$q->disciplines}}</a></td>	
<td>{{$q->strength}}</td>
</tr>

@endforeach
</table>


<table class="table table-bordered table-hover table-condensed">
<tr><td><b>Total Number of Students</b></td><td><b>{{ $total_no_of_students }}</b></tr>

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