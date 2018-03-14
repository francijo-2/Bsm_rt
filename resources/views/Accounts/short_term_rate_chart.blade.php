@include('Layouts.BSM')
@include('Layouts.RateLinks')



<div class="container">
	<div class="row">
		<div class="col-lg- col-md-8">
			<div>

<h2>Short Term Programs</h2>

</br>

@if ($switch == 1)


<form action="{{ route('update_short_fee') }}" method="post">
{{ csrf_field() }}			
		
<table class="table table-bordered table-hover table-condensed">			
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
	<td>Particulars</td>
	<td>Rate</td>
</tr>
@foreach ($short_term_rates as $short_term_rate)
<tr>
	<td>{{ $short_term_rate->particulars }}</td>
	<td><input type="text" name="{{ $short_term_rate->grades }}" value="{{ $short_term_rate->fees }}"></td>
</tr>

@endforeach
</table>
<input type="submit" name="update_graded_fees" value="Update Graded Fees" />
</form>
@else

			

</br>
<form action="{{ route('edit_short_fee') }}" method="post">
{{ csrf_field() }}				
<table class="table table-bordered table-hover table-condensed">			
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
	<td>Particulars</td>
	<td>Rate</td>
</tr>
@foreach ($short_term_rates as $short_term_rate)
<tr>
	<td>{{ $short_term_rate->particulars }}</td>
	<td>{{ $short_term_rate->fees }}</td>
</tr>
@endforeach
</table>


<input type="submit" name="rate_short_term" value="Make Changes" />

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