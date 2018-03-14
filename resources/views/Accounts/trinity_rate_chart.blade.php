@include('Layouts.BSM')
@include('Layouts.RateLinks')



<div class="container">
	<div class="row">
		<div class="col-lg- col-md-8">
			<div>

<h2>Trinity Practical Exam Fees</h2>

@if ($switch == 1)


<form action="{{ route('update_trinity_fee') }}" method="post">
{{ csrf_field() }}			
		
<table class="table table-bordered table-hover table-condensed">			
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
	<td>Particulars</td>
	<td>Rate</td>
</tr>
@foreach ($trinity_rates_practicals as $trinity_rates_practical)
<tr>
	<td>{{ $trinity_rates_practical->particulars }}</td>
	<td><input type="text" name="{{ $trinity_rates_practical->grades }}" value="{{ $trinity_rates_practical->fees }}"></td>
</tr>

@endforeach
</table>

<h2>Trinity Theory Exam Fees</h2>

<table class="table table-bordered table-hover table-condensed">			
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
	<td>Particulars</td>
	<td>Rate</td>
</tr>
@foreach ($trinity_rates_theorys as $trinity_rates_theory)
<tr>
	<td>{{ $trinity_rates_theory->particulars }}</td>
	<td><input type="text" name="{{ $trinity_rates_theory->grades }}" value="{{ $trinity_rates_theory->fees }}"></td>
</tr>

@endforeach
</table>
<input type="submit" name="update_fees" value="Update Trinity Fees" />
</form>
</br></br></br></br>

@else



<form action="{{ route('edit_trinity_fee') }}" method="post">
{{ csrf_field() }}				
<table class="table table-bordered table-hover table-condensed">			
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
	<td>Particulars</td>
	<td>Rate</td>
</tr>
@foreach ($trinity_rates_practicals as $trinity_rates_practical)
<tr>
	<td>{{ $trinity_rates_practical->particulars }}</td>
	<td>{{ $trinity_rates_practical->fees }}</td>
</tr>
@endforeach
</table>

<h2>Trinity Theory Exam Fees</h2>


<table class="table table-bordered table-hover table-condensed">			
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
	<td>Particulars</td>
	<td>Rate</td>
</tr>
@foreach ($trinity_rates_theorys as $trinity_rates_theory)
<tr>
	<td>{{ $trinity_rates_theory->particulars }}</td>
	<td>{{ $trinity_rates_theory->fees }}</td>
</tr>
@endforeach
</table>


<input type="submit" name="rate_trinity_fee" value="Make Changes" />
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