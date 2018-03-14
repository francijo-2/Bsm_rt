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

<form method ="post" action = "{{ route('take_tuition_fees_by_month', ['discipline' => $query->discipline, 'teacher' =>  $query->teacher, 'student' =>  $query->regi_no]) }}">
{{ csrf_field() }}
<table class="table table-bordered table-hover table-condensed">


@if ($total <= 0)
<tr style ="font-size: 16px">
<td colspan = "2"><b>Total</b></td><td colspan = "2"><b>Rs. 0</b><input type="hidden" name="totaled_money" value="{{ $total }}" /></td>
</tr>
@else
@if ($first_fee == 0)
<tr style ="font-size: 16px">
<td colspan = "2">Monthly Fees for {{ $next_month_to_pay }}</td><td colspan = "2">Rs. {{ $total }}<input type="hidden" name="totaled_money" value="{{ $total }}" /><input type="hidden" name="months_data" value="1" /></td>
</tr>
@else
<tr style ="font-size: 16px">
<td colspan = "2"><b>Monthly Fees for {{ $this_month }}</b></td><td colspan = "2">Rs. {{ $total }}<input type="hidden" name="totaled_money" value="{{ $total }}" /><input type="hidden" name="months_data" value="1" /><input type="hidden" name="sum_total_fantom" value="{{ $total_b }}" /></td>
</tr>
@endif
@endif



@if ($total_b <= 0)
<tr style ="font-size: 16px">
<td colspan = "2"><b>Total</b></td><td colspan = "2"><b>Rs. 0</b><input type="hidden" name="totaled_money" value="{{ $total_b }}" /></td>
</tr>
@else

<tr style ="font-size: 16px">
<td colspan = "2"><b>Total</b></td><td colspan = "2"><b>Rs. {{ $total_b }}</b><input type="hidden" name="totaled_money" value="{{ $total_b }}" /></td>
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
	  
	  <input class="form-control" name="billing_date" size="16" type="text" value="{{ $this_date }}" readonly>
	 
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

        history.pushState(null, null, document.URL);
window.addEventListener('popstate', function () {
    history.pushState(null, null, document.URL);
	
	
});
	
    </script>


 			</div><!--container-->
    	</div><!--row-->
    </div><!---customDiv3-->
</div><!--customDiv2-->	