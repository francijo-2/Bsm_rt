@include('Layouts.BSM')

<div class="container">
	<div class="row">
		<div class="col-lg-9 col-md-">
			<div class="customDiv3">
</br></br>
<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">

  <td>Name of Student</td>
  <td>Particulars</td> 
  <td>Amount</td>
  
</tr>
@foreach ($TotalCollection_admin_fee_dues_list as $admin_fee_dues_list)
<tr>
<td>{{ $admin_fee_dues_list->getTheName() }}</td>		
<td>{{ $admin_fee_dues_list->getFeesParticulars()->particulars }}</td>    
<td>{{ $admin_fee_dues_list->getFeeParticulars() }}</td>
</tr>
@endforeach

</table>

			 </div><!----container--------->
    	</div><!----row--------->
    </div><!----customDiv3--------->
</div><!----customDiv2--------->	