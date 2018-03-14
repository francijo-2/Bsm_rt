@include('Layouts.BSM')
<nav class="navbar navbar-default">
  <div class="container-fluid">
    
    <ul class="nav navbar-nav pull-left">
      <li class="active"><a href="{{ route('new_admission') }}">Graded Coursed</a></li>
       <li><a href="{{ route('short_term_program') }}">Short Term Programs</a></li>
       <li><a href="{{ route('special_program') }}">Special Programs</a></li>
    </ul>
  </div>
</nav> 

</br></br></br></br>
<div class="container">
	<div class="row">
		<div class="col-lg-8">
			<div class="customDiv3">


<form action="/Accounts/Accounts/New_admission/Step2" method="post">
{{ csrf_field() }}		
<table class="table table-bordered table-hover table-condensed">			

<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
<td colspan ="4"><b>New Admission Graded Programs</b></td></tr>

		
<div class"form-group">

<tr><td><strong>Name of the Student</strong></td>
<td>
  <input class="form-control" type="text" name="stu_name"/>
 </td>
</tr>
</div>

<tr>
<td><strong>Date of Birth</strong></td>

<div class"form-group">
	<td><div class="controls input-append date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
	  
	  <input class="form-control" name="dob" size="16" type="text" value="" readonly>
	 
					<span class="add-on"><i class="icon-th"></i></span>
              
				<input type="hidden" id="dtp_input2" value="" />
                </div> </td>  
                </div>
          
    
            
<div class"form-group">
<tr>
	<td><strong>Choice of Discipline</strong></td>
<td><select class="form-control" name="discipline" id="chooseDiscipline">
  <option>Choose a Discipline</option>
  
  @foreach ($query as $q)
	<option value ="{{ $q->discipline_id }}">{{ $q->disciplines }}</option>
				 @endforeach
                </select></td>
               
</tr>
</div>            
<div class"form-group">
<tr>
	<td><strong>Lesson Mode</strong></td>
<td colspan ="3";>
  <label class="radio-inline"><input type="radio" name="lesson_mode" value ="1">Individual</label>
	<label class="radio-inline"><input type="radio" name="lesson_mode" value ="2">Small Group</label>
  <label class="radio-inline"><input type="radio" name="lesson_mode" value ="3">Big Group(Five members and above)</label>
</td>	
</tr>
</div>
  <tr>
    <td><strong>Father's Name</strong></td>
    <td><input name="father_name" type="text" class="form-control" id="textfield"></td>
   
 	<td><strong>Father's Designation</strong></td>  
    <td><input name="father_designation" type="text" class="form-control" id="textfield"></td>
</tr>
     <tr>
    <td><strong>Mother's Name</strong></td>
    <td><input name="mother_name" type="text" class="form-control" id="textfield"></td>
   
 	<td><strong>Mother's Designation</strong></td>
     <td><input name="mother_designation" type="text" class="form-control" id="textfield"></td>
</tr>
<tr>
      <td><label for="address">Address</label></td>
      <td>
        <textarea class="form-control" name="address" size="15" id="address" rows = "5"></textarea>
      </td>
      <td><label for="address">Pincode</label></td>
      <td>
        <input class="form-control" type="text" name="pincode" size="6"/>
      </td>
    </tr>
    <tr>
      <td><label for="the_phone5">Phone Number</label></td>
      <td>
        <input class="form-control" type="text" name="phone_no" size="15" id="the_phone"/>
       </td>
    </tr>
      <tr>
        <td><label for="the_email2">Email Address</label><input type="hidden" name="user" value="{{ Auth::user()->id }}" /></td>
        <td>
          <input class="form-control" type="text" name="email_address1" size="15" id="the_email"/>
         </td>
      </tr>
        <tr>
          <td colspan="4"><button class="btn btn-primary btn-sm" type="submit" name="submit_new_student"/>Submit</button></td>
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