@include('Layouts.BSM')

<div class="container">
	<div class="row">
		<div class="col-lg-9 col-md-">
			<div class="customDiv3">
</br></br>
<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">

  <td>Name</td>
  <td>Amount</td>
  <td>Bill No.</td>


</tr>
@foreach ($TotalCollection_scm_list as $scm)
<tr>
<td>{{ $scm->getTheName() }}</td>		
<td>{{ $scm->fee_by_month }}</td>
<td>{{ $scm->receipt_no }}</td>		
</tr>
</tr>
@endforeach

</table>

			 </div><!----container--------->
    	</div><!----row--------->
    </div><!----customDiv3--------->
</div><!----customDiv2--------->	