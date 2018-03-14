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
@foreach ($TotalCollection_amf_list as $amf)
<tr>
<td>{{ $amf->getTheName() }}</td>		
<td>{{ $amf->fee_by_month }}</td>
<td>{{ $amf->receipt_no }}</td>		
</tr>
</tr>
@endforeach

</table>

			 </div><!----container--------->
    	</div><!----row--------->
    </div><!----customDiv3--------->
</div><!----customDiv2--------->	