
@include('Layouts.BSM')

<div class="container">
	<div class="row">
		<div class="col-lg-9 col-md-">
			<div class="customDiv3">

</br>

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
<td><b>Date of Joining</b></td><td>{{ \Carbon\Carbon::parse($q->date_of_joining)->format('F Y') }}</td>
</tr><tr>
<td><b>Teacher</b></td><td>{{ $q->getTeacherName() }}</td>
</tr><tr>
<td><b>Phone No.</b></td><td>{{ $q->getStudentPersonalDetails()->phone_no }}</td>
</tr>



@if (empty ($q->getFeesTransactionDetails()->date1))



<td style="text-align: center"; colspan = "2"><b>NO DUES </b></td>
</tr>

@else
	
    
    
    <td><b>Fees Paid Till</b></td><td><b>{{ \Carbon\Carbon::parse($q->getFeesTransactionDetails()->date1)->format('F Y') }}</b></td>
</tr>

@endif

<tr>
	<td><b>Money in Account</b></td>
	<td>Rs. {{ $q->diff_amount }}</td>
</tr>


</table>

<h3>Payments</h3>



<a  href="{{ route('miscelleneous', ['discipline' => $q->discipline, 'student' =>  $q->regi_no, 'teacher' => $q->teacher]) }}" class="btn btn-default btn-xs">Miscelleneous</a>
<a  href="/Forms/Trinity_Practical/{{ $q->discipline }}/{{ $q->teacher }}/{{ $q->regi_no }}" class="btn btn-default btn-xs">Trinity Practical</a>
<a  href="/Forms/Trinity_Theory/{{ $q->discipline }}/{{ $q->teacher }}/{{ $q->regi_no }}" class="btn btn-default btn-xs">Trinity Theory</a>
<a  href="/Forms/ABRSM_Practical/{{ $q->discipline }}/{{ $q->teacher }}/{{ $q->regi_no }}" class="btn btn-default btn-xs">ABRSM Practical</a>
<a  href="/Forms/ABRSM_Theory/{{ $q->discipline }}/{{ $q->teacher }}/{{ $q->regi_no }}" class="btn btn-default btn-xs">ABRSM Theory</a>

@if ($if_practical == 1)
<a  href="/Forms/Aural_and_Accompaniment/{{ $q->discipline }}/{{ $q->teacher }}/{{ $q->regi_no }}" class="btn btn-default btn-xs">A&A</a>
@endif



<a  href="{{  route('historical_report', ['discipline' => $q->discipline, 'teacher' =>  $q->teacher, 'student' =>  $q->regi_no]) }}" class="btn btn-default btn-xs">History</a>
<a  href="{{  route('tuition_fees_by_month', ['discipline' => $q->discipline, 'teacher' =>  $q->teacher, 'student' =>  $q->regi_no]) }}" class="btn btn-default btn-xs">Custom Fee</a>
<a  href="{{ route('edit_student', ['discipline' => $q->discipline, 'teacher' => $q->teacher, 'regi_no' => $q->regi_no]) }}" class="btn btn-default">Edit Student</a>
<a  href="/Forms/Notes/{{ $q->discipline }}/{{ $q->teacher }}/{{ $q->regi_no }}" class="btn btn-default">Notes</a>


<form method ="post" action = "/Forms/{{ $q->discipline }}/{{ $q->teacher }}/{{ $q->regi_no }}">
{{ csrf_field() }}
<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
<td colspan="4" style="text-align:center;"><b>FEE DUES</b>
</tr>
@if ($fresh_months_count == 0)
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
@endif
@if ($fee_months_count > 0)
<tr>						
<td><input type ="checkbox" name = "tuition_fees"/></td><td>Monthly Tuition Fees</td><td>Rs. {{ $q->getStudentFees()->fees*$q->frequency }} per month
<input type ="hidden" name = "monthly_fee_rate" value = "{{ $q->getStudentFees()->fees*$q->frequency }}"/></td>
<td><select name="months"><option value="{{ $fee_months_count }}">{{ $fee_months_count }}</option>
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
@endif

@if ($late_fees_due_count > 0)
@foreach ($late_fees_due as $late_fees)
@foreach ($late_fee_rate as $late_fee)
<tr>	
<td><input type ="checkbox" name = "{{ $late_fees->sno }}"/></td><td>Late Fee Penalty {{ \Carbon\Carbon::parse($late_fees->fee_date)->format('F Y') }}</td><td colspan = "2">Rs. {{ $late_fee->fees }}
<input type ="hidden" name = "late_fee_rate" value = "{{ $late_fee->fees }}"/></td>
</tr>
@endforeach
@endforeach
@endif

@if ($miscelleneous_count > 0)
@foreach ($miscelleneous_dues as $miscelleneous_due)
<tr>	
<td><input type ="checkbox" name = "{{ $miscelleneous_due->sno }}"/></td><td>{{ $miscelleneous_due->getFeesParticulars()->particulars }}</td><td colspan = "2">Rs. {{ $miscelleneous_due->getFeesParticulars()->fees }}
</td>
</tr>
@endforeach
@endif

@if ($amf_due_count > 0)
@foreach ($amf_dues as $amf_due)
@foreach ($amf_rate as $amf)
<tr>	
<td><input type ="checkbox" name = "{{ $amf_due->sno }}"/></td><td>Annual Maintenance Fund</td><td colspan = "2">Rs. {{ $amf->fees }}
<input type ="hidden" name = "amf_fee_rate" value = "{{ $amf->fees }}"/></td>
</tr>
@endforeach
@endforeach
@endif

@if ($scm_due_count > 0)
@foreach ($scm_dues as $scm_due)
@foreach ($scm_rate as $scm)
<tr>	
<td><input type ="checkbox" name = "{{ $scm_due->sno }}"/></td><td>Student Concert Membership</td><td colspan = "2">Rs. {{ $scm->fees }}
<input type ="hidden" name = "scm_fee_rate" value = "{{ $scm->fees }}"/></td>
</tr>
@endforeach
@endforeach
@endif

@if ($exam_fee_due_count > 0)
@foreach ($exam_fee_dues as $exam_fee_due)
<tr>
<td><input type ="checkbox" name = "{{ $exam_fee_due->e_s_d_no }}"/></td><td>{{ $exam_fee_due->getExamDetails()->exam_name }}</td><td colspan = "2">Rs. {{ $exam_fee_due->getExamFees()->fees }}
</tr>
</td>	
@endforeach
@endif

@if ($a_and_a_count > 0)
@foreach ($a_and_a_dues as $a_and_a_due)
<tr>
<td><input type ="checkbox" name = "{{ $a_and_a_due->sno }}"/></td><td>{{ $a_and_a_due->getFeesParticulars()->particulars }}</td><td colspan = "2">Rs. {{ $a_and_a_due->getFeesParticulars()->fees }}
</tr>
</td>	
@endforeach
@endif

@if ($q->enrolment == 0)
@foreach ($enrolments as $enrolment)	
<tr>
<td><input type ="checkbox" name = "enrolment"/></td><td>Enrolment Fees</td><td colspan = "2">Rs. {{ $enrolment->fees }}
</td>
</tr>
@endforeach
@endif

@if ($q->refundable_deposit == 0)
@foreach ($deposits as $deposit)	
<tr>
<td><input type ="checkbox" name = "deposit"/></td><td>Re-fundable Deposit</td><td colspan = "2">Rs. {{ $deposit->fees }}
<input type ="hidden" name = "re_fund_deposit" value = "{{ $deposit->fees }}"/></td>
</tr>
@endforeach
@endif


@if (($scm_due_count > 0) OR ($exam_fee_due_count > 0) OR ($amf_due_count > 0) OR ($fee_months_count > 0) OR ($fresh_months_count == 0) OR ($q->refundable_deposit == 0) OR ($miscelleneous_count > 0) OR ($late_fees_due_count > 0) OR ($a_and_a_count > 0))
<tr>	
<td colspan = "4" ;><input type="submit" name="submit_total" value="Total" /></td>
</tr>
@else
<tr>
<td colspan = "4"; style = "font-size: 21px; text-align: center;"><b>No DUES</b></td>
</tr>
</table>
@endif
	@endforeach
</form>


	


		  </div><!----container--------->
    	</div><!----row--------->
    </div><!----customDiv3--------->
</div><!----customDiv2--------->	