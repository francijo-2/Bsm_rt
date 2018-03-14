@include('Layouts.BSM')
@include('Layouts.RateLinks')



<div class="container">
	<div class="row">
		<div class="col-lg- col-md-8">
			<div>

<h2>Short Term Programs</h2>

</br>

@if ($switch == 1)


<form action="{{ route('update_special_fee') }}" method="post">
{{ csrf_field() }}			
		
<table class="table table-bordered table-hover table-condensed">			
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
	<td>Particulars</td>
	<td>Rate</td>
</tr>
@foreach ($special_rates as $special_rate)
<tr>
	<td>{{ $special_rate->particulars }}</td>
	<td><input type="text" name="{{ $special_rate->grades }}" value="{{ $special_rate->fees }}"></td>
</tr>

@endforeach
</table>
<input type="submit" name="update_graded_fees" value="Update Graded Fees" />
</form>
@else

			

</br>
<form action="{{ route('edit_special_fee') }}" method="post">
{{ csrf_field() }}				
<table class="table table-bordered table-hover table-condensed">			
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
	<td>Particulars</td>
	<td>Rate</td>
</tr>
@foreach ($special_rates as $special_rate)
<tr>
	<td>{{ $special_rate->particulars }}</td>
	<td>{{ $special_rate->fees }}</td>
</tr>
@endforeach
</table>


<input type="submit" name="rate_special_fee" value="Make Changes" />

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