
@include('Layouts.BSM')

<div class="container">
	<div class="row">
		<div class="col-lg-9 col-md-">
			<div class="customDiv3">

</br></br></br> 

<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">



@foreach ($query as $q)



<td colspan ="2"; style="text-align:center";><b>STUDENT DETAILS</b></td></tr>
<td><b>Name</b></td><td>{{ $q->getStudentPersonalDetails()->stu_name }}</td>
</tr><tr>
<td><b>Date of Birth</b></td><td>{{ $q->getStudentPersonalDetails()->dob }}</td>
</tr><tr>
<td><b>Section</b></td><td>{{ $q->getDisciplineName()->disciplines }}</td>
</tr><tr>
<td><b>Date of Joining</b></td><td>{{ $q->date_of_joining }}</td>
</tr><tr>
<td><b>Teacher</b></td><td>{{ $q->getTeacherName() }}</td>
</tr><tr>
<td><b>Phone No.</b></td><td>{{ $q->getStudentPersonalDetails()->phone_no }}</td>
</tr>
<td style="text-align: center"; colspan = "2"><b>NO DUES </b></td>
</tr>
</table>

<h3>Payments</h3>

<form method ="post" action = "/Forms/{{ $q->discipline }}/{{ $q->teacher }}/{{ $q->regi_no }}">
{{ csrf_field() }}
<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
<td colspan="4" style="text-align:center;"><b>FEE DUES</b>
</tr>
<tr>						
<td><input type ="checkbox" name = "first_monthly_fees"/></td><td>Monthly Tuition Fees</td><td>Rs. {{ $q->getStudentFees()->fees*$q->frequency }} per month
<input type ="hidden" name = "monthly_fee_rate" value = "{{ $q->getStudentFees()->fees*$q->frequency }}"/></td>
<td><select name="months"><option value="1">1</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
</select></td>
</tr>
@endforeach
@foreach ($amf_dues as $amf_due)
@foreach ($amf_rate as $amf)
<tr>	
<td><input type ="checkbox" name = "{{ $amf_due->sno }}"/></td><td>Annual Maintenance Fund</td><td colspan = "2">Rs. {{ $amf->fees }}
<input type ="hidden" name = "amf_fee_rate" value = "{{ $amf->fees }}"/></td>
</tr>
@endforeach
@endforeach
<tr>
@foreach ($scm_dues as $scm_due)
@foreach ($scm_rate as $scm)	
<td><input type ="checkbox" name = "{{ $scm_due->sno }}"/></td><td>Student Concert Membership</td><td colspan = "2">Rs. {{ $scm->fees }}
<input type ="hidden" name = "scm_fee_rate" value = "{{ $scm->fees }}"/></td>
@endforeach
@endforeach
</tr>

@if ($q->enrolment == 0)
@foreach ($enrolments as $enrolment)	
<tr>
<td><input type ="checkbox" name = "enrolment"/></td><td>Enrolment Fees</td><td colspan = "2">Rs. {{ $enrolment->fees }}
<input type ="hidden" name = "enrolment_fee_rate" value = "{{ $enrolment->fees }}"/></td>
@endforeach
@endif
</tr>

@if ($q->refundable_deposit == 0)
@foreach ($deposits as $deposit)
<tr>
<td><input type ="checkbox" name = "deposit"/></td><td>Re-fundable Deposit</td><td colspan = "2">Rs. {{ $deposit->fees }}
<input type ="hidden" name = "re_fund_deposit" value = "{{ $deposit->fees }}"/></td>
@endforeach
@endif
</tr>


<tr>	
<td colspan = "4" ;><input type="submit" name="submit_total" value="Total" /></td>
</tr>
</form>

<script type="text/javascript">

        history.pushState(null, null, document.URL);
window.addEventListener('popstate', function () {
    history.pushState(null, null, document.URL);
	
	
});
	
    </script>

			</div><!--inside column-->
		</div><!--column class-->
	</div><!--row-->
 </div><!--container-> 

