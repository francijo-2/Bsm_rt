@include('Layouts.BSM')
@include('Layouts.RateLinks')



<div class="container">
	<div class="row">
		<div class="col-lg- col-md-8">
			<div>

<h2>One Time Payments</h2>

</br>

@if ($switch == 1)


<form action="{{ route('update_one_time_fee') }}" method="post">
{{ csrf_field() }}			
		
<table class="table table-bordered table-hover table-condensed">			
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
	<td>Particulars</td>
	<td>Rate</td>
</tr>
@foreach ($one_time_rates as $one_time_rate)
<tr>
	<td>{{ $one_time_rate->particulars }}</td>
	<td><input type="text" name="{{ $one_time_rate->grades }}" value="{{ $one_time_rate->fees }}"></td>
</tr>

@endforeach
</table>
<input type="submit" name="update_fees" value="Update One Time Payments" />
</form>
@else

			

</br>
<form action="{{ route('edit_one_time_fee') }}" method="post">
{{ csrf_field() }}				
<table class="table table-bordered table-hover table-condensed">			
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
	<td>Particulars</td>
	<td>Rate</td>
</tr>
@foreach ($one_time_rates as $one_time_rate)
<tr>
	<td>{{ $one_time_rate->particulars }}</td>
	<td>{{ $one_time_rate->fees }}</td>
</tr>
@endforeach
</table>


<input type="submit" name="rate_one_time_fee" value="Make Changes" />

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