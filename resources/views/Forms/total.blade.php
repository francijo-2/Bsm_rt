@include('Layouts.BSM')

<div class="container">
	<div class="row">
		<div class="col-lg-9 col-md-">
			<div class="customDiv3">

</br>

<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">


</br></br></br> 

<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">

<td colspan ="2"; style="text-align:center";><b>STUDENT DETAILS</b></td></tr>
<td><b>Name</b></td><td>{{ $query->getStudentPersonalDetails()->stu_name }}</td>
</tr><tr>
<td><b>Date of Birth</b></td><td>{{ $query->getStudentPersonalDetails()->dob }}</td>
</tr><tr>
<td><b>Section</b></td><td>{{ $query->getDisciplineName()->disciplines }}</td>
</tr><tr>
<td><b>Date of Joining</b></td><td>{{ \Carbon\Carbon::parse($query->date_of_joining)->format('F Y') }}</td>
</tr><tr>
<td><b>Teacher</b></td><td>{{ $query->getTeacherName() }}</td>
</tr><tr>
<td><b>Phone No.</b></td><td>{{ $query->getStudentPersonalDetails()->phone_no }}</td>
</tr>



@if (empty ($query->getStudentPersonalDetails()->getFeesTransactionDetails()->date1))



<td style="text-align: center"; colspan = "2"><b>NO DUES </b></td>
</tr>

@else
	
    
    
    <td><b>Fees Paid Till</b></td><td><b>{{ \Carbon\Carbon::parse($query->getStudentPersonalDetails()->getFeesTransactionDetails()->date1)->format('F Y') }}</b></td>
</tr>

@endif
</table>

<h3>Total</h3>

<form method ="post" action = "/{{ $query->discipline }}/{{ $query->regi_no }}">
{{ csrf_field() }}
<table class="table table-bordered table-hover table-condensed">

@if (!empty ($for_months))
@foreach ($for_months as $month)
<tr>
<td><input type ="checkbox" name ="months_data" value ="{{ $no_of_months }}"  onclick="return false" checked /></td><td>Monthly Fees for {{ $month }}</td><td colspan = "2">Rs. {{ $monthly_fee_rate }} per month</td>
</tr>
@endforeach
@endif

@if (!empty($enrolment_fee_rate))
<tr>
<td><input type ="checkbox" name ="enrolment" onclick="return false" checked /></td><td>Enrolment</td><td colspan = "2">Rs. {{ $enrolment_fee_rate }}</td>
</tr>
@endif

@if (!empty($deposit_rate))
<tr>
<td><input type ="checkbox" name ="deposit" onclick="return false" checked /></td><td>Re-fundable Deposit</td><td colspan = "2">Rs. {{ $deposit_rate }}</td>
</tr>
@endif

@if (!empty($late_fee_rate))
@foreach ($late_fee_dues as $late_due)
<tr>
<td><input type ="checkbox" name ="{{ $late_due->sno }}" onclick="return false" checked /></td><td>Late Fee Penalty {{ \Carbon\Carbon::parse($late_due->fee_date)->format('F Y') }}</td><td colspan = "2">Rs. {{ $late_fee_rate }}</td>
</tr>
@endforeach
@endif


@if (!empty($scm_fee_rate))
@foreach ($scm_dues as $scm_due)
<tr>
<td><input type ="checkbox" name ="{{ $scm_due->sno }}" onclick="return false" checked /></td><td>Student Concert Membership Card</td><td colspan = "2">Rs. {{ $scm_fee_rate }}</td>
</tr>
@endforeach
@endif

@if (!empty($amf_fee_rate))
@foreach ($amf_dues as $amf_due)
<tr>
<td><input type ="checkbox" name ="{{ $amf_due->sno }}" onclick="return false" checked /></td><td>Annual Maintenance Fund</td><td colspan = "2">Rs. {{ $amf_fee_rate }}</td>
</tr>
@endforeach
@endif


@if (!empty($exam_fee_rate))
@foreach ($exam_dues as $exam_due)
<tr>
<td><input type ="checkbox" name = "{{ $exam_due->e_s_d_no }}" onclick="return false" checked /></td><td>{{ $exam_due->getExamDetails()->exam_name }}</td><td colspan = "2">Rs. {{ $exam_due->getExamFees()->fees }}</td>	
</tr>
@endforeach
@endif

@if (!empty($aural_and_accompaniment_fees_rate))
@foreach ($aural_and_accompaniment_dues_array as $aural_and_accompaniment_due_array)
<tr>
<td><input type ="checkbox" name = "{{ $aural_and_accompaniment_due_array->sno }}" onclick="return false" checked /></td><td>{{ $aural_and_accompaniment_due_array->getFeesParticulars()->particulars }}</td><td colspan = "2">Rs. {{ $aural_and_accompaniment_due_array->getFeesParticulars()->fees }}</td>	
</tr>
@endforeach
@endif

@if (!empty($miscelleneous_fee_rate))
@foreach ($miscelleneous_dues_array as $miscelleneous_due_array)
<tr>
<td><input type ="checkbox" name = "{{ $miscelleneous_due_array->sno }}" onclick="return false" checked /></td><td>{{ $miscelleneous_due_array->getFeesParticulars()->particulars }}</td><td colspan = "2">Rs. {{ $miscelleneous_due_array->getFeesParticulars()->fees }}</td>  
</tr>
@endforeach
@endif

@if ($total <= 0)
<tr style ="font-size: 16px">
<td colspan = "2"><b>Total</b></td><td colspan = "2"><b>Rs. 0</b><input type="hidden" name="totaled_money" value="{{ $total }}" /></td>
</tr>
@else

<tr style ="font-size: 16px">
<td colspan = "2"><b>Total</b></td><td colspan = "2"><b>Rs. {{ $total }}</b><input type="hidden" name="totaled_money" value="{{ $total }}" /></td>
</tr>
@endif
<tr style ="font-size: 16px">
<td colspan = "2";>Money Collected</td>
<td colspan = "2" ;><input type="text" name="money_collected" /><input type="hidden" name="user" value="{{ Auth::user()->id }}" /></td>
</tr>
<tr style ="font-size: 16px">
<td colspan = "2";>Receipt No:</td>
<td colspan = "2" ;><input type="text" name="receipt_no" </td>
</tr>
@if ($query->diff_amount < 0)
<tr style ="font-size: 16px">
<td colspan = "2"; bgcolor="#FF0000";><font color="white"><b>Dues</b></font></td>
<td colspan = "2"; bgcolor="#FF0000";><font color="white"><b>Rs. {{ $query->diff_amount }}</b></font></td>
</tr>
@else
<tr style ="font-size: 16px">
<td colspan = "2";>Money in Account No:</td>
<td colspan = "2" ;>Rs. {{ $query->diff_amount }}</td>
</tr>
@endif
<tr>
<td colspan = "2";><strong>Date of Receipt</strong></td>

<div class"form-group">
	<td colspan = "2";><div class="controls input-append date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
	  
	  <input class="form-control" name="billing_date" size="16" type="text" value="{{ $date_for_display }}" readonly>
	 
					<span class="add-on"><i class="icon-th"></i></span>
              
				<input type="hidden" id="dtp_input2" value="" />
                </div>
                </div>
           </td>	
    
            
<div class"form-group">
<tr>
<tr>
<td colspan = "2" ;><input type="submit" name="go_back" value="Go Back" /></td>
<td colspan = "2" ;><input type="submit" name="pay_fees" value="Pay Fees" /></td>

</tr>

</form>
</table>
<input type="submit" name="over_ride" value="Over-ride Fees" />
 <script type="text/javascript">
    
	$('.form_date').datetimepicker({
        language:  'en',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	
</script>



    
 <script type="text/javascript">
            $(document).ready(function(){
                 $("form").submit(function() {
                        $(this).submit(function() {
                            return false;
                        });
                        return true;
                    }); 
            }); 
            </script>

 			</div><!--container-->
    	</div><!--row-->
    </div><!---customDiv3-->
</div><!--customDiv2-->	