@include('Layouts.BSM')
@include('Layouts.RateLinks')



<div class="container">
	<div class="row">
		<div class="col-lg- col-md-8">
			<div>

<h2>ABRSM Practical Exam Fees</h2>

@if ($switch == 1)


<form action="{{ route('update_abrsm_fee') }}" method="post">
{{ csrf_field() }}			
		
<table class="table table-bordered table-hover table-condensed">			
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
	<td>Particulars</td>
	<td>Rate</td>
</tr>
@foreach ($abrsm_rates_practicals as $abrsm_rates_practical)
<tr>
	<td>{{ $abrsm_rates_practical->particulars }}</td>
	<td><input type="text" name="{{ $abrsm_rates_practical->grades }}" value="{{ $abrsm_rates_practical->fees }}"></td>
</tr>

@endforeach
</table>

<h2>ABRSM Theory Exam Fees</h2>

<table class="table table-bordered table-hover table-condensed">			
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
	<td>Particulars</td>
	<td>Rate</td>
</tr>
@foreach ($abrsm_rates_theorys as $abrsm_rates_theory)
<tr>
	<td>{{ $abrsm_rates_theory->particulars }}</td>
	<td><input type="text" name="{{ $abrsm_rates_theory->grades }}" value="{{ $abrsm_rates_theory->fees }}"></td>
</tr>

@endforeach
</table>
<input type="submit" name="update_fees" value="Update ABRSM Fees" />
</form>
</br></br></br></br>

@else



<form action="{{ route('edit_abrsm_fee') }}" method="post">
{{ csrf_field() }}				
<table class="table table-bordered table-hover table-condensed">			
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
	<td>Particulars</td>
	<td>Rate</td>
</tr>
@foreach ($abrsm_rates_practicals as $abrsm_rates_practical)
<tr>
	<td>{{ $abrsm_rates_practical->particulars }}</td>
	<td>{{ $abrsm_rates_practical->fees }}</td>
</tr>
@endforeach
</table>

<h2>ABRSM Theory Exam Fees</h2>


<table class="table table-bordered table-hover table-condensed">			
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
	<td>Particulars</td>
	<td>Rate</td>
</tr>
@foreach ($abrsm_rates_theorys as $abrsm_rates_theory)
<tr>
	<td>{{ $abrsm_rates_theory->particulars }}</td>
	<td>{{ $abrsm_rates_theory->fees }}</td>
</tr>
@endforeach
</table>


<input type="submit" name="rate_abrsm_fee" value="Make Changes" />
</form>

</br></br></br></br>
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