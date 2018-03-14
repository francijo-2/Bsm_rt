
@include('Layouts.BSM')

<div class="container">
	<div class="row">
		<div class="col-lg-9 col-md-">
			<div class="customDiv3">

</br>

<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">



@foreach ($query as $q)



<td colspan ="2"; style="text-align:center";><b>STUDENT DETAILS</b></td></tr>
<td><b>Name</b></td><td>{{ $q->getStudentPersonalDetails()->stu_name }}</td>
</tr><tr>
<td><b>Date of Birth</b></td><td>{{ $q->getStudentPersonalDetails()->dob }}</td>
</tr><tr>
<td><b>Section</b></td><td>{{ $q->getDisciplineName()->disciplines }}</td>
</tr><tr>
<td><b>Date of Joining</b></td><td>{{ \Carbon\Carbon::parse($q->date_of_joining)->format('F Y') }}</td>
</tr><tr>
<td><b>Teacher</b></td><td>{{ $q->getTeacherName() }}</td>
</tr><tr>
<td><b>Phone No.</b></td><td>{{ $q->getStudentPersonalDetails()->phone_no }}</td>
</tr>



@if (empty ($q->getStudentPersonalDetails()->getFeesTransactionDetails()->date1))



<td style="text-align: center"; colspan = "2"><b>NO DUES </b></td>
</tr>

@else
	
    
    
    <td><b>Fees Paid Till</b></td><td><b>{{ \Carbon\Carbon::parse($q->getStudentPersonalDetails()->getFeesTransactionDetails()->date1)->format('F Y') }}</b></td>
</tr>

@endif




</table>

<form method ="post" action = "{{ route('total_tuition_fees_by_month', ['discipline' => $q->discipline, 'student' =>  $q->regi_no, 'teacher' => $q->teacher, 'discipline' => $q->discipline]) }}">
{{ csrf_field() }}
<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
<td colspan="4" style="text-align:center;"><b>Customised Monthly Fee Entry</b>
</tr>
@if ($fresh_months_count == 0)
<tr>						
<td><input type ="checkbox" name = "first_monthly_fees"/><td>Customised Monthly Fee for {{ $this_month_for_custom_fee }}</td><td><input type ="text" name = "monthly_fee_rate" value ="{{ $q->getStudentFees()->fees }}"/></td>
</tr>
@endif
@if ($next_month_to_pay > 0)
<tr>						
<td><input type ="checkbox" name = "tuition_fees"/><td>Customised Monthly Fee for {{ $the_month }}</td><td><input type ="text" name = "monthly_fee_rate" value ="{{ $q->getStudentFees()->fees*$q->frequency }}"/></td>
</tr>
@endif


<tr>	
<td colspan = "4" ;><input type="submit" name="submit_total" value="Total" /></td>
</tr>

	@endforeach
</form>
	
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