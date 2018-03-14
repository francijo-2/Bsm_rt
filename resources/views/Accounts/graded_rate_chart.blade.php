@include('Layouts.BSM')
@include('Layouts.RateLinks')



<div class="container">
	<div class="row">
		<div class="col-lg- col-md-8">
			<div>



</br>

<h2>Graded Fees</h2>


@if ($switch == 1)



<form action="{{ route('update_graded_fee') }}" method="post">
{{ csrf_field() }}			
</br>		
<table class="table table-bordered table-hover table-condensed">			
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
	<td>Particulars</td>
	<td>Rate</td>
</tr>
@foreach ($graded_rates as $graded_rate)
<tr>
	<td>{{ $graded_rate->particulars }}</td>
	<td><input type="text" name="{{ $graded_rate->grades }}" value="{{ $graded_rate->fees }}"></td>
</tr>

@endforeach
</table>
<input type="submit" name="update_graded_fees" value="Update Graded Fees" />
</form>
@else


			

</br>
<form action="{{ route('edit_graded_fee') }}" method="post">
{{ csrf_field() }}				
<table class="table table-bordered table-hover table-condensed">			
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
	<td>Particulars</td>
	<td>Rate</td>
</tr>
@foreach ($graded_rates as $graded_rate)
<tr>
	<td>{{ $graded_rate->particulars }}</td>
	<td>{{ $graded_rate->fees }}</td>
</tr>
@endforeach
</table>


<input type="submit" name="rate_graded" value="Make Changes" />

</form>
@endif

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