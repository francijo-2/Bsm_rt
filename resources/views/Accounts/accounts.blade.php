@include('Layouts.BSM')

 <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
    </div>
    <ul class="nav navbar-nav pull-left">
      <li class="active"><a href="http://localhost/bsm_rt/accounts.php">Dash Board</a></li>
      <li><a href="http://localhost/bsm_rt/faculty_salary.php">Faculty Salary</a></li>
      <li><a href="{{ route('graded_fee') }}">Rate Chart</a></li>
      <li><a href="faculty_details.php">Faculty</a></li>
    </ul>
  </div>
</nav>

</br></br></br></br>

@if ($late_fee_payment == 1)
<a href="{{ route('late_fees_update')}}" class ="btn btn-primary">Late Fees Calculation</a>
@endif

<a href="{{ route('new_admission') }}" class="btn btn-primary">New Admission</a>

<div class="container">
  <div class="row">
    <div class="col-lg-6 col-md-6">
      <div class="customDiv3">

        </br></br>


<form method ="post" action = "{{ route('accounts_reports', ['from_date' => $from_date, 'till_date' =>  $till_date]) }}">

{{ csrf_field() }}
<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">

  <td colspan = "4";>REQUEST REPORTS</td>

<tr>
<td colspan = "2";><strong>From</strong></td>

<div class"form-group">
  <td colspan = "2";><div class="controls input-append date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
    
    <input class="form-control" name="from_date" size="16" type="text" value="" readonly>
   
          <span class="add-on"><i class="icon-th"></i></span>
              
        <input type="hidden" id="dtp_input2" value="" />
         </td>  
                </div>

          
</tr>


<tr>
<td colspan = "2";><strong>Till</strong></td>

<div class"form-group">
  <td colspan = "2";><div class="controls input-append date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
    
    <input class="form-control" name="till_date" size="16" type="text" value="" readonly>
   
          <span class="add-on"><i class="icon-th"></i></span>
              
        <input type="hidden" id="dtp_input2" value="" />
         </td>  
                </div>

          
</tr>



</table>


<input type="submit" name="make_report" value="Make Report" />



      </br></br>


<table class="table table-bordered table-hover table-condensed">
<tr>
  <td><a href="{{ route('students_needing_id') }}"><b>Total No. of Students</b></a></td><td>{{ $NumStu }}</td>
</tr><tr>  
  <td><a href="{{ route('accounts_reports_total', ['from_date' => $from_date, 'till_date' =>  $till_date]) }}"><b>Total Money Collected Collections</b></a></td><td>Rs.{{ $TotalCollection }}</td>
</tr><tr>  
  <td><a href="{{ route('accounts_scm_report', ['from_date' => $from_date, 'till_date' =>  $till_date]) }}"><b>Total proceeds from Student Concert Memberships</b></a></td><td>Rs.{{ $TotalCollection_scm }}</td>
</tr><tr>  
  <td><a href="{{ route('accounts_amf_report', ['from_date' => $from_date, 'till_date' =>  $till_date]) }}"><b>Total proceeds from Annual Maintenance</b></a></td><td>Rs.{{ $TotalCollection_amf }}</td>
</tr><tr>  
  <td><a href="{{ route('accounts_monthly_fee_due') }}"><b>Monthly Fee Due</b></a></td><td>Rs.{{ $sum }}</td>
</tr><tr>  
  <td><a href="{{ route('accounts_admin_fee_due') }}"><b>Admin Fee Due</b></a></td><td>Rs.{{ $sum_admin }}</td>
</tr>
<tr>  
  <td><a href="{{ route('accounts_late_fee_due') }}"><b>Late Fee Due</b></a></td><td>Rs.{{ $sum_late }}</td>
</tr>
<tr>  
  <td><a href="{{ route('students_needing_id') }}"><b>Total No. Students without ID Cards</b></a></td><td>{{ $students_without_id }}</td>
</tr>
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

      </div><!--------------inside column------>
    </div><!--------------column class------>
  </div><!--------------row------>
 </div><!------------container---------> 
 <script src="{{ asset('js/app.js') }}"></script>