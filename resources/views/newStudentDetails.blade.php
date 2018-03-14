
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

</table>

<h3>Payments</h3>



<a  href="/Forms/Miscelleneous/{{ $q->discipline }}/{{ $q->teacher }}/{{ $q->regi_no }}" class="btn btn-default">Miscelleneous</a>
<a  href="/Forms/Trinity_Practical/{{ $q->discipline }}/{{ $q->teacher }}/{{ $q->regi_no }}" class="btn btn-default">Trinity Practical</a>
<a  href="/Forms/Trinity_Theory/{{ $q->discipline }}/{{ $q->teacher }}/{{ $q->regi_no }}" class="btn btn-default">Trinity Theory</a>
<a  href="/Forms/ABRSM_Practical/{{ $q->discipline }}/{{ $q->teacher }}/{{ $q->regi_no }}" class="btn btn-default">ABRSM Practical</a>
<a  href="/Forms/ABRSM_Theory/{{ $q->discipline }}/{{ $q->teacher }}/{{ $q->regi_no }}" class="btn btn-default">ABRSM Theory</a>
<a  href="/Forms/Edit_Student/{{ $q->discipline }}/{{ $q->teacher }}/{{ $q->regi_no }}" class="btn btn-default">Edit Student</a>
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
<td><input type ="checkbox" name = "tuition_fees"/></td><td>Monthly Tuition Fees</td><td>Rs. {{ $q->getStudentFees()->fees }} per month
<input type ="hidden" name = "monthly_fee_rate" value = "{{ $q->getStudentFees()->fees }}"/></td>
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
@if ($amf_due_count > 0)
@foreach ($amf_rate as $amf)
<tr>	
<td><input type ="checkbox" name = "amf_fees"/></td><td>Annual Maintenance Fund</td><td colspan = "2">Rs. {{ $amf->fees }}
<input type ="hidden" name = "amf_fee_rate" value = "{{ $amf->fees }}"/></td>
</tr>
@endforeach
@endif
<tr>
@if ($scm_due_count > 0)
@foreach ($scm_rate as $scm)	
<td><input type ="checkbox" name = "scm_fees"/></td><td>Student Concert Membership</td><td colspan = "2">Rs. {{ $scm->fees }}
<input type ="hidden" name = "scm_fee_rate" value = "{{ $scm->fees }}"/></td>
@endforeach
@endif
</tr><tr>
@if ($exam_fee_due_count > 0)
@foreach ($exam_fee_due as $exam_fee)
<td><input type ="checkbox" name = "exam_fees"/></td><td>{{ $exam_fee->getExamDetails()->exam_name }}</td><td colspan = "2">Rs. {{ $exam_fee->getExamFees()->fees }}</td>
<input type ="hidden" name = "scm_fee_rate" value = "{{ $scm->fees }}"/></td>
</tr>
@endforeach
@endif
@if (($scm_due_count > 0) OR ($exam_fee_due_count > 0) OR ($amf_due_count > 0) OR ($fee_months_count > 0) OR ($fresh_months_count == 0))
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