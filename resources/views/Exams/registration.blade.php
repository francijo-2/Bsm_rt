@include('Layouts.BSM')

<div class="container">
	<div class="row">
		<div class="col-lg-8">
			<div class="customDiv3">



<form method ="post" action = "/Exams/Info/add">
{{ csrf_field() }}


<h3>Menu</h3>


<button class="btn btn-default" name="add_trinity"/>Add a Trinity Exam</button>
<button class="btn btn-default" name="add_abrsm"/>Add an ABRSM Exam</button>

@if ($message == 1)

	<table class="table table-bordered table-hover table-condensed">
	<tr style="background-color: white; color: black; text-align: center; font-size: 16px">
    <td>The Exam has been added</td>

@endif

</br></br></br></br>
<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
<td colspan ="4"; style="text-align:center";><b>Upcoming Exams</b></td></tr>
<td><b>Exam</b></td>
<td><b>Category</b></td>
<td><b>Approx. Date of Exam</b></td>
<td><b>Last date of Application</b></td>
</tr><tr>
@foreach ($query as $q)

@if (($q->exam_code == 1) AND ($q->category_code == 1))
<td><a href="{{ route('exam_details', ['exam_details' => $q->exam_no]) }}">Trinity</a></td>
<td>Practical</td>
<td>{{ $q->approx_date }}</td>
<td>{{ $q->last_app_date }}</td>
</tr>
@endif

@if (($q->exam_code == 1) AND ($q->category_code == 2))
<td><a href="{{ route('exam_details', ['exam_details' => $q->exam_no]) }}">Trinity</a></td>
<td>Theory</td>
<td>{{ $q->approx_date }}</td>
<td>{{ $q->last_app_date }}</td>
</tr>
@endif

@if (($q->exam_code == 2) AND ($q->category_code == 1))
<td><a href="{{ route('exam_details', ['exam_details' => $q->exam_no]) }}">ABRSM</a></td>
<td>Practical</td>
<td>{{ $q->approx_date }}</td>
<td>{{ $q->last_app_date }}</td>
</tr>
@endif

@if (($q->exam_code == 2) AND ($q->category_code == 2))
<td><a href="{{ route('exam_details', ['exam_details' => $q->exam_no]) }}">ABRSM</a></td>
<td>Theory</td>
<td>{{ $q->approx_date }}</td>
<td>{{ $q->last_app_date }}</td>
</tr>
@endif

@endforeach


</form>

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