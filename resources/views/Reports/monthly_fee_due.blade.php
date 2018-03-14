@include('Layouts.BSM')

<div class="container">
	<div class="row">
		<div class="col-lg-9 col-md-">
			<div class="customDiv3">
</br></br>
<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">

  <td>Name</td>
  <td>Name of Teacher</td>
  <td>Discipline</td> 
  <td>Month</td> 
  <td>Amount</td>
  

</tr>
@foreach ($TotalCollection_monthly_fee_dues_list as $monthly_fee_due)
<tr>
<td>{{ $monthly_fee_due->getTheName() }}</td>		
<td>{{ $monthly_fee_due->getTeacherName() }}</td>		
<td>{{ $monthly_fee_due->getDisciplineName() }}</td>
<td>{{ \Carbon\Carbon::parse($monthly_fee_due->fee_date)->format('F Y') }}</td>
<td><b>Rs. {{ $monthly_fee_due->getStuDetails()->getStudentFees()->fees }}</b></td>
</tr>
</tr>
@endforeach

</table>

			 </div><!----container--------->
    	</div><!----row--------->
    </div><!----customDiv3--------->
</div><!----customDiv2--------->	