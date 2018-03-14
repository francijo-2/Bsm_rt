@include('Layouts.BSM')

<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-">
			<div class="customDiv3">
</br></br>
<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">

  <td>Name</td>
  <td>Particulars</td>
  <td>Month</td>
  <td>Amount</td>
  <td>Date</td>
  <td>Amount Collected</td>
  <td>Receipt No.</td>


</tr>
@foreach ($TotalCollections as $collecteions)
<tr>
<td>{{ $collecteions->getTheName() }}</td>
@if ($collecteions->particulars == 1)
<td>Monthly Fees</td>
@else
<td>{{ $collecteions->getFeeParticulars() }}</td>		
@endif
@if ($collecteions->particulars == 1)
<td>{{ \Carbon\Carbon::parse($collecteions->date1)->format('F Y') }}</td>
@else
<td></td>
@endif
<td><b>Rs.{{ $collecteions->fee_by_month }}</b></td>
<td>{{ \Carbon\Carbon::parse($collecteions->billing_date)->format('d-m-Y') }}</td>
<td>Rs.{{ $collecteions->money_collected }}</td>
<td>{{ $collecteions->receipt_no }}</td>		
</tr>
</tr>
@endforeach

</table>

			 </div><!----container--------->
    	</div><!----row--------->
    </div><!----customDiv3--------->
</div><!----customDiv2--------->	