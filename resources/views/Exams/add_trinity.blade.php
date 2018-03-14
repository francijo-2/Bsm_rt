@include('Layouts.BSM')


</br></br></br></br>


<div class="container">
	<div class="row">
		<div class="col-lg-6 col-md-8">
			<div class="customDiv3">

<form method ="post" action ="/Exams/Info/add">
{{ csrf_field() }}

<table class="table table-bordered table-hover table-condensed">
<tr style="background-color: black; color: white; text-align: center; font-size: 16px">
<td colspan ="4"; style="text-align:center";><b>Add a Trinity Exam
</b></td></tr>
<td><b>Examination:</b></td>
<td height = "30"><select  class="form-control"  name="trinity"><option value="1">Trinity</option>
</tr><tr>

<td><b>Category:</b></td>
<td height = "30"><select class="form-control" name="category"><option value="">Choose the Category</option>
<option value="1"><h3>Practical</h3></option>
<option value="2"><h3>Theory</h3></option>
</tr><tr>

<td><b>Approximate Month:</b></td>



<td><div class="form-group">
                <div class="control-group">
                
                <div class="controls input-append date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" name="approx_date" size="16" type="text" value="" readonly>
                    <span class="add-on"><i class="icon-remove"></i></span>
					<span class="add-on"><i class="icon-th"></i></span>
                </div>
				<input type="hidden" id="dtp_input2" value="" /><br/>
            </div>
    </div></td>



<tr>
<td><b>Last Date for Application:</b></td>



<td><div class="form-group">
                <div class="control-group">
                
                <div class="controls input-append date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" name="last_date" size="12" type="text" value="" readonly>
                    <span class="add-on"><i class="icon-remove"></i></span>
					<span class="add-on"><i class="icon-th"></i></span>
                </div>
				<input type="hidden" id="dtp_input2" value="" />
                <input type="hidden" name="user" value="{{ Auth::user()->id }}" /><br/>
            </div>
    </div></td>


</tr>
<tr>
<td colspan="3"; style="text-align:center;"><button class="form-control btn btn-primary" type="submit" name="submit_trinity_exam"/>Add Exam</button></td>
</tr>

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