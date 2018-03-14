
@include('Layouts.BSM')

<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div>
			

</br></br></br>	

<form action="{{ route('change_parameters2', ['discipline' => $stu_data_information->discipline, 'teacher' => $stu_data_information->teacher, 'regi_no' => $stu_data_information->regi_no]) }}" method="post">
{{ csrf_field() }}

</br></br>

<table class="table table-bordered table-hover table-condensed">			

<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
<td colspan ="4"><b>Change Parameters: {{ $stu_information->stu_name }}</b></td>
</tr>

		
<div class"form-group">
	<tr><td><strong>Name of the Student</strong></td>
	<td><input class="form-control text-uppercase" type="text" name="stu_name" readonly value="{{ $stu_information->stu_name }}"/></td>
</tr>
</div>


<div class"form-group">
<tr>
	<td><strong>Date of Birth</strong></td>
	<div class"form-group">
	<td><div class="controls input-append date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
	  
	  <input class="form-control" name="dob" size="16" type="text" value="{{ $stu_information->dob }}" readonly>
	 
					<span class="add-on"><i class="icon-th"></i></span>
              
				<input type="hidden" id="dtp_input2" value="" />
                </div> </td>  
                </div> 	
</tr>



</div>
@if ($stu_data_information->level == 12)
<div class"form-group">
<tr>
	<td><strong>Lesson Mode</strong></td>
<td><label class="radio-inline"><input type="radio" name="lesson_mode" value ="1">Individual</label>
	<label class="radio-inline"><input type="radio" name="lesson_mode" checked="checked" value ="2">Group</label>
</td>	
</tr>
</div>

@else

<div class"form-group">
<tr>
	<td><strong>Lesson Mode</strong></td>
<td><label class="radio-inline"><input type="radio" name="lesson_mode" checked="checked" value ="1">Individual</label>
	<label class="radio-inline"><input type="radio" name="lesson_mode" value ="2">Group</label>
</td>	
</tr>
</div>

@endif

<div class"form-group">
<tr>
	<td><strong>Choice of Discipline</strong></td>
<td><select class="form-control" name="discipline" id="chooseDiscipline">
  <option value ="{{ $stu_data_information->discipline }}">{{ $stu_data_information->getNameOfDiscipline() }}</option>
  
  @foreach ($query as $q)
	<option value ="{{ $q->discipline_id }}">{{ $q->disciplines }}</option>
@endforeach
                </select></td>
               
</tr>
</div>   
  <tr>
    <td><strong>Father's Name</strong></td>
    <td><input name="father_name" type="text" class="form-control" readonly value="{{ $stu_information->father_name }}"></td>
   
 	<td><strong>Father's Designation</strong></td>  
    <td><input name="father_designation" type="text" class="form-control" readonly value="{{ $stu_information->father_designation }}"></td>
</tr>
     <tr>
    <td><strong>Mother's Name</strong></td>
    <td><input name="mother_name" type="text" class="form-control" readonly value="{{ $stu_information->mother_name }}"></td>
   
 	<td><strong>Mother's Designation</strong></td>  
    <td><input name="mother_designation" type="text" class="form-control" readonly value="{{ $stu_information->mother_designation }}"></td>	
</tr>
<tr>
      <td><label for="address">Address</label></td>
      <td>
        <input class="form-control" name="address" size="15" id="address" rows = "5" readonly value="{{ $stu_information->address }}"></input>
      </td>
      <td><label for="pincode">Pincode</label></td>
       <td><input class="form-control" id="pincode" name="pincode" type="text" readonly value="{{ $stu_information->pincode }}"></td>	  
    </tr>
<div class"form-group">
<tr>
    <td><label for="the_phone">Phone Number</label></td>
    <td><input class="form-control" type="text" name="phone_no" size="15" id="the_phone" readonly value="{{ $stu_information->phone_no }}"></td>
</tr>
</div>


<div class"form-group">
<tr>
      <td><label for="the_email2">Email Address</label></td>
      <td><input class="form-control" type="text" name="email_address1" size="15" id="the_email" readonly value="{{ $stu_information->email_address1 }}"/></td>
</tr> 

<td colspan="2"><button class ="btn btn-primary btn-sm" type="submit" name="make_changes"/>Proceed</button></td>
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
	
	