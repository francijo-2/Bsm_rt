@include('Layouts.BSM')
<nav class="navbar navbar-default">
  <div class="container-fluid">
    
    <ul class="nav navbar-nav pull-left">
      <li><a href="{{ route('short_term_select_teacher') }}">Graded Coursed</a></li>
        <li class="active"><a href="{{ route('short_term_program') }}">Short Term Programs</a></li>s
        <li><a href="{{ route('special_program') }}">Special Programs</a></li>
    </ul>
  </div>
</nav> 

</br></br></br></br>
<div class="container">
	<div class="row">
		<div class="col-lg-8">
			<div class="customDiv3">


<form action="{{ route('short_term_select_teacher') }}" method="post">
{{ csrf_field() }}  		
<table class="table table-bordered table-hover table-condensed">			

<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
<td colspan ="4"><b>New Admission Short Term Programs</b></td></tr>

		
<div class"form-group">

<tr><td><strong>Name of the Student</strong></td>
<td><span id="sprytextfield1">
  <input class="form-control" type="text" name="stu_name"/>
</tr>
</div>

<tr>
<td><strong>Date of Birth</strong></td>

<div class"form-group">
	<td><div class="controls input-append date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
	  
	  <input class="form-control" name="dob" size="16" type="text" value="" readonly>
	 
					<span class="add-on"><i class="icon-th"></i></span>
              
				<input type="hidden" id="dtp_input2" value="" />
           </td>	
            </div>
            
<div class"form-group">
<<tr>
  <td><strong>Choice of Discipline</strong></td>
<td><select class="form-control" name="discipline" id="chooseDiscipline">
  <option>Choose a Discipline</option>
  @foreach ($query as $q)
  <option value ="{{ $q->discipline_id }}">{{ $q->disciplines }}</option>
         @endforeach
                </select></td>
               
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
<tr>
      <td><label for="address">Address</label></td>
      <td>
        <input class="form-control" name="address" size="15" id="address"></input>
      </td>
      <td><label for="pincode">Pincode</label></td>
       <td><input class="form-control" id="pincode" name="pincode" type="text"></td>	  
    </tr>
    <tr>
      <td><label for="the_phone5">Phone Number</label></td>
      <td><input class="form-control" type="text" name="phone_no" size="15" id="the_phone"/></td>
    </tr>
      <tr>
        <td><label for="the_email2">Email Address</label></td>
        <td><input class="form-control" type="text" name="email_address1" size="15" id="the_email"/></td>
      </tr>
        <tr>
          <td colspan="2"><button class="form-control btn btn-primary" type="submit" name="submit_new_student"/>Submit</button></td>
          </tr>
</div>

</table>


</form>

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

			</div><!--inside column-->
		</div><!--column class-->
	</div><!--row-->
 </div><!--container-> 