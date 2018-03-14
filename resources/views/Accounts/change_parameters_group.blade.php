
@include('Layouts.BSM')

<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div>
			

</br></br></br>			
<form action="{{ route('complete_editing_parameters', ['discipline' => $stu_data_information->discipline, 'teacher' => $stu_data_information->teacher, 'regi_no' => $stu_data_information->regi_no]) }}" method="post">
{{ csrf_field() }}			
<table class="table table-bordered table-hover table-condensed">			


<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
<td colspan ="4"><b>New Admission</b></td>
</tr>

		
<div class"form-group">
	<tr><td><strong>Name of the Student</strong></td>
	<td><input class="form-control text-uppercase" type="text" name="stu_name" readonly value="{{ $stu_name }}"/></td>
</tr>
</div>



<div class"form-group">
<tr>
	<td><strong>Date of Birth</strong></td>
	<td><input class="form-control "type="text" name="dob" readonly value="{{ $dob }}"></td>	
</tr>
</div>



<div class"form-group">
<tr>
	
	<td><strong>Choice of Discipline</strong></td>
	<td><input class="form-control "type="text" id="chooseDiscipline" name="discipline" readonly value="{{ $chosen_discipline->disciplines }}">
	<input type="hidden" name="fantom_discipline" value="{{ $discipline_id }}"></td>
  <input type="hidden" name="fantom_level" value="{{ $level }}">
  <input type="hidden" name="user" value="{{ Auth::user()->id }}"></td>
   
</tr>
</div>
  <tr>
    <td><strong>Father's Name</strong></td>
    <td><input name="father_name" type="text" class="form-control" readonly value="{{ $father_name }}"></td>
   
 	<td><strong>Father's Designation</strong></td>  
    <td><input name="father_designation" type="text" class="form-control" readonly value="{{ $father_designation }}"></td>
</tr>
     <tr>
    <td><strong>Mother's Name</strong></td>
    <td><input name="mother_name" type="text" class="form-control" readonly value="{{ $mother_name }}"></td>
   
 	<td><strong>Mother's Designation</strong></td>  
    <td><input name="mother_designation" type="text" class="form-control" readonly value="{{ $mother_designation }}"></td>	
</tr>
<tr>
      <td><label for="address">Address</label></td>
      <td>
        <input class="form-control" name="address" size="15" id="address" readonly rows = "5" value="{{ $address }}"></input>
      </td>
      <td><label for="pincode">Pincode</label></td>
       <td><input class="form-control" id="pincode" name="pincode" type="text" readonly value="{{ $pincode }}"></td>	  
    </tr>
<div class"form-group">
<tr>
    <td><label for="the_phone">Phone Number</label></td>
    <td><input class="form-control" type="text" name="phone_no" size="15" id="the_phone" value="{{ $phone_no }}" readonly/></td>
</tr>
</div>


<div class"form-group">
<tr>
      <td><label for="the_email2">Email Address</label></td>
      <td><input class="form-control" type="text" name="email_address1" size="15" id="the_email" readonly value="{{ $email_address1 }}"/></td>
</tr> 







@if ($discipline_id != $stu_data_information->discipline)


<div class"form-group">   
<tr>
   <td><label for="coi">Choice of Instructor</label></td>
   <td><select class="form-control" name="instructor" id="coi">
  <option>Choice of Instructor</option>
  @foreach ($teacher_details as $t)
    <option value ="{{ $t->teachers_id }}">{{ $t->teacher_name }}</option>
    @endforeach
    </select>
    <input class="form-control" type="hidden" name="lesson_mode" size="15" value="{{ $lesson_mode }}"/></td>
</tr>
</div>
@else


<div class"form-group">   
<tr>
   <td><label for="coi">Choice of Instructor</label></td>
   <td><select class="form-control" name="instructor" id="coi">
  <option value="{{ $stu_data_information->teacher }}">{{ $stu_data_information->getTeacherName() }}</option>
  @foreach ($teacher_details as $t)
    <option value ="{{ $t->teachers_id }}">{{ $t->teacher_name }}</option>
    @endforeach
    </select>
    <input class="form-control" type="hidden" name="lesson_mode" size="15" value="{{ $lesson_mode }}"/></td>
</tr>
</div>
@endif



<tr>
<td colspan="2"><button class ="btn btn-primary btn-sm" type="submit" name="enter_new_student"/>Update Parameters</button></td>
</tr>


<script type="text/javascript">

        history.pushState(null, null, document.URL);
window.addEventListener('popstate', function () {
    history.pushState(null, null, document.URL);
  
  
});
  
    </script>
						</div><!--------------inside column------>
					</div><!--------------column class------>
				</div><!--------------row------>
			</div><!--------------container------>
	
	