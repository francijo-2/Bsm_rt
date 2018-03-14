<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discipline;
use App\StudentTeacherMapping;
use App\StudentInformation;
use App\OneTimeTransaction;
use App\FeesTransaction;
use App\FeesDue;
use App\GradesFee;
use App\ExamsTable;
use App\ExamStudentDatabase;
use App\LateFeeCounter;
use App\JunctionTeachersDiscipline;
use App\Teacher;
use App\AuralAndAccompaniment;















































class MainController extends Controller
{
    
    public function index(Request $request)
    {
    	
    		$search = $request->search;
    		$search_stu = $request->search_stu;



    		if (!empty($search))
    		{

    			$hh = StudentInformation::where('stu_name', 'LIKE', "%$search_stu%")->get();
    			



    			return view('index', compact('hh'));
    		}





		/*--------------ALGORITHM TO SET DATE BEGINS HERE -----------------*/
        
		$count = OneTimeTransaction::count();
		$last = OneTimeTransaction::where('number', '=', "$count")->get();


		foreach ($last as $l)
		
		$l->counter_date = date('Ymd', strtotime("$l->counter_date"));
		$this_date = date('Ymd');
		if ($this_date < $l->counter_date){
		echo 'DATE ERROR';
		exit; 
		} 
	 		

	 		if ($this_date != $l->counter_date)
			{
					while ($this_date != $l->counter_date)
					{

						//dd($l->counter_date);
					$l->counter_date = date('Ymd', strtotime("$l->counter_date + 1 day"));
					$current_month = date('m', strtotime("$l->counter_date"));
					$current_year = date('Y', strtotime("$l->counter_date"));
					$m = $l->counter_date;

					

				
					/*--------------CALCULATING MONTHLY FEES DUES-----------------*/
					

					$new_month = date($current_year.$current_month.'01');

					if ($m == $new_month)
			{		
					
					$monthly_fee_due_check = StudentTeacherMapping::wherestatus(1)->get();
						
						foreach ($monthly_fee_due_check as $monthly_fee_due)
				{
						 $fee_check_one = FeesTransaction::whereregist_no($monthly_fee_due->regi_no)
						 					->wheresection($monthly_fee_due->discipline)
						 					->whereparticulars(1)
						 					->count();
						 					
						 if ($fee_check_one > 0)
						 {
						 $fee_check = FeesTransaction::whereregist_no($monthly_fee_due->regi_no)
						 					->wheresection($monthly_fee_due->discipline)	
						 					->whereparticulars(1)
						 					->wheredate1($m)
						 					->count();

													if ($fee_check == 0)
								{
										
									  $insert_to_due = new FeesDue;
									 
									  $insert_to_due->registration_no = $monthly_fee_due->regi_no;
									  $insert_to_due->fee_date = $m;
									  $insert_to_due->discipline_no = $monthly_fee_due->discipline;
									  $insert_to_due->teacher_no = $monthly_fee_due->teacher;
									  $insert_to_due->particulars = 1;
									  $insert_to_due->save();
								 }
						 	}

						 }

						 /*--------------END OF CALCULATING MONTHLY FEES DUES-----------------*/
						 
						 /*--------------CALCULATING SCM & AMF-----------------*/
						 $admin_fee_due_check = StudentInformation::wherestatus(1)->get();
				
						
						
						foreach ($admin_fee_due_check as $admin_fee_due)

						{

						 		$scm_check = StudentInformation::wherereg_no($admin_fee_due->reg_no)->first();
									$s = date('Y');
								
								
									$scm_year = date(''.$s.'m01', strtotime("$scm_check->scm"));
									if ($scm_year == $m)
										{
										 
										  $insert_to_due = new FeesDue;
										  $insert_to_due->registration_no = $admin_fee_due->reg_no;
										  $insert_to_due->fee_date = $m;
										  $insert_to_due->particulars = 10;
										  $insert_to_due->save();
							     		}

						  		$amf_check = StudentInformation::wherereg_no($admin_fee_due->reg_no)->first();
									$amf_year = date(''.$s.'m01', strtotime("$amf_check->joining_date"));
									if ($amf_year == $m)
										{
										  $insert_to_due = new FeesDue;
										  $insert_to_due->registration_no = $admin_fee_due->reg_no;
										  $insert_to_due->fee_date = $m;
										  $insert_to_due->particulars = 9;
										  $insert_to_due->save();

							     		}


						} 
						
						  /*--------------END OF CALCULATING SCM & AMF-----------------*/
						  
					/*--------------SETTING LATE FEES DUES-----------------*/
				
				
					$insert_data = new LateFeeCounter;
					$insert_data->date5 = $m;					
					$insert_data->late_status = 0;
					$insert_data->save();

				

					

			
				/*--------------END OF SETTING LATE FEES DUES-----------------*/		
					
							
			}

		/*--------------INSERTING DATES-----------------*/		
							
							
							
							$counterDate = new OneTimeTransaction;
							$counterDate->counter_date = $m;
							$counterDate->save();

							
						}
			}
		/*--------------SETTING DATE ENDS-----------------*/
		
		
			
			
			
			/*--------------SETTING UP HOME PAGE DISPLAY-----------------*/


			$all_disciplines = Discipline::all();

			foreach ($all_disciplines as $each_discipline)

			{

				$add_up_students = StudentTeacherMapping::wherediscipline($each_discipline->discipline_id)
															->wherestatus(1)
															->count();

				$update_student_strength = Discipline::find($each_discipline->discipline_id);
				$update_student_strength->strength = $add_up_students;
				$update_student_strength->save();
			}



			/*--------------END SETTING UP HOME PAGE DISPLAY-----------------*/
			
				$late_fee_payment = 0;

				$tenth_day = date('d', strtotime("$this_date"));

				if ($tenth_day > 10)
			{
					$first_day = date('Ym01');
					$late_fees_due_check = LateFeeCounter::wheredate5($first_day)
															->wherelate_status(0)
															->count();
				
						if ($late_fees_due_check == 1)
						{
							$late_fee_payment = 1;
						}	

													
			}


			
			/*--------------HOME PAGE DISPLAY-----------------*/
		
		$total_no_of_students = StudentTeacherMapping::wherestatus(1)->count();	

		$query = Discipline::where('strength', '!=', '0')->get();
		return view('index', compact('query', 'late_fee_payment', 'total_no_of_students'));
		
			/*--------------HOME PAGE DISPLAY ENDS-----------------*/		
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/*-----------CODE FOR THE DISPLAY BY DISCIPLINE-----------------*/
	
	public function discipline($discipline_name)
    {	
		
    	$find = StudentInformation::wherestatus(1)
									->orderby('stu_name', 'ASC')
									->get();

		$i = 0;

		foreach ($find as $iterate) 
		{
		
		$find_student_data = StudentTeacherMapping::whereregi_no($iterate->reg_no)
											->wherediscipline($discipline_name)
											->wherestatus(1)
											->count();	

		if ($find_student_data > 0)
			{								

		$find_student_data_array[$i] = StudentTeacherMapping::whereregi_no($iterate->reg_no)
											->wherediscipline($discipline_name)
											->wherestatus(1)
											->first();															
				
			$i = $i + 1;

			}

		}							
			
		$all_teachers = Teacher::wherestatus(1)->get();

		$f = 0;
		

		foreach ($all_teachers as $each_teacher)
		{

			$count_teacher = JunctionTeachersDiscipline::wherediscipline($discipline_name)
														->whereteachers($each_teacher->teachers_id)
														->count();

				if ($count_teacher > 0)

				{
			
			$find_the_teachers[$f] = JunctionTeachersDiscipline::wherediscipline($discipline_name)
														->whereteachers($each_teacher->teachers_id)
														->first();	

			$f = $f + 1;

				}
		}

		
			
			
		return view('discipline', compact('find_student_data_array', 'find_the_teachers'));
    }
	/*-----------CODE FOR THE DISPLAY BY DISCIPLINE ENDS-----------------*/
	

	
	
	
	
	/*-----------CODE FOR THE INDIVIDUAL PAGE-----------------*/
	
	
	/*-----------CODE FOR ACCEPTING FEES-----------------*/
	
	public function individual(Request $request, $discipline, $student)
    {	
			
		if (isset($_POST['over_ride']))	

		{


			/*-----------CODE FOR TAKING MONTHLY FEES-----------------*/
				
				$paid_till_month = FeesTransaction::select('date1')
													->whereregist_no($student)
													->wheresection($discipline)
													->whereparticulars(1)
													->orderby('date1', 'DESC')
													->count();
				
				$student_details = StudentTeacherMapping::whereregi_no($student)
																->wherediscipline($discipline)
																->wherestatus(1)
																->first();
																
											
																
						$student_level = $student_details->level;
						
						$student_monthly_fee = Gradesfee::wheregrades($student_level)
												->first();
						
						$billing_date = date('Ymd', strtotime("$request->billing_date"));
						
						
				
				if ($paid_till_month == 0)
				{
						$paid_till_month = date('Ym01');
						$months = $request->months_data;
						$for_months = array();
						for ($j=0; $j <=$months-1; $j++)
						{
							
							$for_months[$j] = date('Ymd', strtotime("$paid_till_month"));
							$paid_till_month = date('Ymd', strtotime("$paid_till_month + 1months"));
						
						}		

								foreach ($for_months as $for_month)
					{
						
						$pay_monthly_fee = new FeesTransaction;
						$pay_monthly_fee->regist_no = $student;
						$pay_monthly_fee->date1 = $for_month;
						$pay_monthly_fee->billing_date = $billing_date;
						$pay_monthly_fee->money_collected = 0;
						$pay_monthly_fee->fee_by_month = 0;
						$pay_monthly_fee->section = $discipline;
						$pay_monthly_fee->particulars = 1;
						$pay_monthly_fee->teacher1 = $student_details->teacher;
						$pay_monthly_fee->receipt_no = 0;
						$pay_monthly_fee->user = $request->user;
						$pay_monthly_fee->save();
					}
						
						
						
				
				} else {
						
				$paid_till_month = FeesTransaction::select('date1')
													->whereregist_no($student)
													->wheresection($discipline)
													->whereparticulars(1)
													->orderby('date1', 'DESC')
													->first();
						
				$paid_till_month = date('Ymd', strtotime("$paid_till_month[date1]"));
						
				$months = $request->months_data;
				$for_months = array();
				for ($j=0; $j <=$months-1; $j++)
				{
					
					$for_months[$j] = date('Ymd', strtotime("$paid_till_month + 1months"));
					$paid_till_month = date('Ymd', strtotime("$paid_till_month + 1months"));
					
						
				}
					
					
				foreach ($for_months as $for_month)
					{
						
						$pay_monthly_fee = new FeesTransaction;
						$pay_monthly_fee->regist_no = $student;
						$pay_monthly_fee->date1 = $for_month;
						$pay_monthly_fee->billing_date = $billing_date;
						$pay_monthly_fee->money_collected = 0;
						$pay_monthly_fee->fee_by_month = 0;
						$pay_monthly_fee->section = $discipline;
						$pay_monthly_fee->particulars = 1;
						$pay_monthly_fee->teacher1 = $student_details->teacher;
						$pay_monthly_fee->receipt_no = 0;
						$pay_monthly_fee->user = $request->user;
						$pay_monthly_fee->save();
						
						$if_fee_pending = FeesDue::whereregistration_no($student)
											->whereparticulars(1)
											->wherediscipline_no($discipline)
											->wherefee_date($for_month)
											->wherestatus(0)
											->count();
						
								if ($if_fee_pending == 1)
								{
									$find_in_fees_due_table = FeesDue::whereregistration_no($student)
																->whereparticulars(1)
																->wherediscipline_no($discipline)
																->wherefee_date($for_month)
																->wherestatus(0)
																->first();
									
									$sno = $find_in_fees_due_table->sno;
									
									$update_fees_due_table = FeesDue::find($sno);
											$update_fees_due_table->status = 1;
											$update_fees_due_table->save();	
								}	
					
					
					}
								
					}
		/*-----------CODE FOR TAKING MONTHLY FEES ENDS-----------------*/
		
		
		/*-----------CODE FOR TAKING SCM FEES-----------------*/			
					
					$student_scm_fee = Gradesfee::wheregrades(10)
												->first();				
					
					$scm_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->get();
		
		foreach ($scm_dues as $scm_due)
		{
		
			if (isset($_POST["$scm_due->sno"]))	
				{	
					
						$pay_scm_fee = new FeesTransaction;
						$pay_scm_fee->regist_no = $student;
						$pay_scm_fee->date1 = $scm_due->fee_date;
						$pay_scm_fee->billing_date = $billing_date;
						$pay_scm_fee->money_collected = 0;
						$pay_scm_fee->fee_by_month = 0;
						$pay_scm_fee->section = $discipline;
						$pay_scm_fee->particulars = 10;
						$pay_scm_fee->teacher1 = 0;
						$pay_scm_fee->receipt_no = 0;
						$pay_scm_fee->user = $request->user;
						$pay_scm_fee->save();
				
				$update_fees_due_table = FeesDue::find($scm_due->sno);
											$update_fees_due_table->status = 1;
											$update_fees_due_table->save();	
				
				}		
		}
		
	
		/*-----------CODE FOR TAKING SCM FEES ENDS-----------------*/	
		
		/*-----------CODE FOR TAKING AMF FEES-----------------*/			
					
					$student_amf_fee = Gradesfee::wheregrades(9)
												->first();				
					
					$amf_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->get();

		
		foreach ($amf_dues as $amf_due)
		{
		
			if (isset($_POST["$amf_due->sno"]))	
				{	
			
						$pay_amf_fee = new FeesTransaction;
						$pay_amf_fee->regist_no = $student;
						$pay_amf_fee->date1 = $amf_due->fee_date;
						$pay_amf_fee->billing_date = $billing_date;
						$pay_amf_fee->money_collected = 0;
						$pay_amf_fee->fee_by_month = 0;
						$pay_amf_fee->section = $discipline;
						$pay_amf_fee->particulars = 9;
						$pay_amf_fee->teacher1 = 0;
						$pay_amf_fee->receipt_no = 0;
						$pay_amf_fee->user = $request->user;
						$pay_amf_fee->save();
				
				$update_fees_due_table = FeesDue::find($amf_due->sno);
											$update_fees_due_table->status = 1;
											$update_fees_due_table->save();	
				
				}		
		}
		
	
		/*-----------CODE FOR TAKING AMF FEES ENDS-----------------*/		

		/*-----------CODE FOR TAKING ENROLMENT FEES-----------------*/	

		if (isset($_POST['enrolment']))	
				{	
					$enrolment_fee_rate = GradesFee::wheregrades(52)
									->first();	


						$pay_enrolment_fees = new FeesTransaction;
						$pay_enrolment_fees->regist_no = $student;
						$pay_enrolment_fees->billing_date = $billing_date;
						$pay_enrolment_fees->money_collected = 0;
						$pay_enrolment_fees->fee_by_month = 0;
						$pay_enrolment_fees->section = $discipline;
						$pay_enrolment_fees->particulars = 52;
						$pay_enrolment_fees->teacher1 = 0;
						$pay_enrolment_fees->receipt_no = 0;
						$pay_enrolment_fees->user = $request->user;
						$pay_enrolment_fees->save();
				
				
				$finding_id = StudentTeacherMapping::whereregi_no($student)
											->wherediscipline($discipline)
											->first();		


				$update_enrolment_paid = StudentTeacherMapping::find($finding_id->sl_no);
											$update_enrolment_paid->enrolment = 1;
											$update_enrolment_paid->save();	

			}									


		/*-----------END OF CODE FOR TAKING ENROLMENT FEES-----------------*/	

		/*-----------CODE FOR TAKING REFUNDABLE DEPOSIT-----------------*/	

		
		if (isset($_POST['deposit']))	
				{	
					$refundable_deposit_rate = GradesFee::wheregrades(53)
									->first();	


						$pay_deposit = new FeesTransaction;
						$pay_deposit->regist_no = $student;
						$pay_deposit->billing_date = $billing_date;
						$pay_deposit->money_collected = 0;
						$pay_deposit->fee_by_month = 0;
						$pay_deposit->section = $discipline;
						$pay_deposit->particulars = 53;
						$pay_deposit->teacher1 = 0;
						$pay_deposit->receipt_no = 0;
						$pay_deposit->user = $request->user;
						$pay_deposit->save();
				
				
				$finding_id = StudentTeacherMapping::whereregi_no($student)
											->wherediscipline($discipline)
											->first();	

				$update_refundable_deposit = StudentTeacherMapping::find($finding_id->sl_no);
											$update_refundable_deposit->refundable_deposit = 1;
											$update_refundable_deposit->save();	


			}








		/*-----------END OF CODE FOR TAKING REFUNDABLE DEPOSIT-----------------*/	




		/*-----------CODE FOR TAKING LATE FEES-----------------*/			
					
					$student_late_fee = Gradesfee::wheregrades(11)
												->first();				
					
					$late_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(11)
								->wherestatus(0)
								->get();
				
		foreach ($late_dues as $late_due)
		{
		
			if (isset($_POST["$late_due->sno"]))	
				{	
					
						$pay_late_fee = new FeesTransaction;
						$pay_late_fee->regist_no = $student;
						$pay_late_fee->date1 = $late_due->fee_date;
						$pay_late_fee->billing_date = $billing_date;
						$pay_late_fee->money_collected = 0;
						$pay_late_fee->fee_by_month = 0;
						$pay_late_fee->section = $discipline;
						$pay_late_fee->particulars = 11;
						$pay_late_fee->teacher1 = $student_details->teacher;
						$pay_late_fee->receipt_no = 0;
						$pay_late_fee->user = $request->user;
						$pay_late_fee->save();
				
				$update_late_fee_paid = FeesDue::find($late_due->sno);
											$update_late_fee_paid->status = 1;
											$update_late_fee_paid->save();		
				
				}		
		}
		
	
		/*-----------CODE FOR TAKING LATE FEES ENDS-----------------*/	



		/*-----------CODE FOR TAKING MISCELLENEOUS FEES-----------------*/			
					
								
					
					$student_miscelleneous_dues = FeesDue::whereregistration_no($student)
								->wheresub_cat(8)
								->wherestatus(0)
								->get();

								
				
		foreach ($student_miscelleneous_dues as $student_miscelleneous_due)
		{
		
			$student_miscelleneous_rate = Gradesfee::wheregrades($student_miscelleneous_due->particulars)
												->first();	

												
			if (isset($_POST["$student_miscelleneous_due->sno"]))	
				{	
					
						$pay_miscelleneous_fee = new FeesTransaction;
						$pay_miscelleneous_fee->regist_no = $student;
						$pay_miscelleneous_fee->billing_date = $billing_date;
						$pay_miscelleneous_fee->money_collected = 0;
						$pay_miscelleneous_fee->fee_by_month = 0;
						$pay_miscelleneous_fee->section = $discipline;
						$pay_miscelleneous_fee->particulars = $student_miscelleneous_due->particulars;
						$pay_miscelleneous_fee->teacher1 = $student_details->teacher;
						$pay_miscelleneous_fee->receipt_no = 0;
						$pay_miscelleneous_fee->user = $request->user;
						$pay_miscelleneous_fee->save();
				
				$update_fees_due_table = FeesDue::find($student_miscelleneous_due->sno);
											$update_fees_due_table->status = 1;
											$update_fees_due_table->save();	
				
				}		
		}
		
	
		/*-----------CODE FOR TAKING MISCELLENEOUS FEES ENDS-----------------*/

/*-----------CODE FOR TAKING AURAL AND ACCOMPANIMENT FEES-----------------*/			
					
								
					
					$student_a_and_a_dues = FeesDue::whereregistration_no($student)
													->wherediscipline_no($discipline)
													->whereteacher_no($student_details->teacher)
													->wheresub_cat(10)
													->wherestatus(0)
													->get();

								
				
		
		
		foreach ($student_a_and_a_dues as $student_a_and_a_due) 
		{
			
		$student_a_and_a_rate = Gradesfee::wheregrades($student_a_and_a_due->particulars)
												->first();	

												
			if (isset($_POST["$student_a_and_a_due->sno"]))	
				{	
					
						$pay_a_and_a_fee = new FeesTransaction;
						$pay_a_and_a_fee->regist_no = $student;
						$pay_a_and_a_fee->billing_date = $billing_date;
						$pay_a_and_a_fee->money_collected = 0;
						$pay_a_and_a_fee->fee_by_month = 0;
						$pay_a_and_a_fee->section = $discipline;
						$pay_a_and_a_fee->particulars = $student_a_and_a_due->particulars;
						$pay_a_and_a_fee->teacher1 = $student_details->teacher;
						$pay_a_and_a_fee->receipt_no = 0;
						$pay_a_and_a_fee->user = $request->user;
						$pay_a_and_a_fee->save();
				
					$finding_teacher = StudentTeacherMapping::whereregi_no($student)
											->wherediscipline($discipline)
											->wherestatus(1)
											->first();			
					
					$which_exam = ExamStudentDatabase::wheree_s_d_roll_num($student)
									->wheree_s_d_discipline($discipline)
									->wheree_s_d_teacher($finding_teacher->teacher)
									->wheree_s_d_status(1)
									->first();


					$subject_code = FeesDue::wheresno($student_a_and_a_due->sno)
											->first();
										

					$add_to_a_and_a_list = new AuralAndAccompaniment;
					$add_to_a_and_a_list->a_code = $which_exam->e_s_d_code;
					$add_to_a_and_a_list->a_roll_no = $which_exam->e_s_d_roll_num;
					$add_to_a_and_a_list->a_discipline = $which_exam->e_s_d_discipline;
					$add_to_a_and_a_list->a_teacher = $which_exam->e_s_d_teacher;
					$add_to_a_and_a_list->subject_code = $subject_code->particulars;
					$add_to_a_and_a_list->save();	


					$update_fees_due_table = FeesDue::find($student_a_and_a_due->sno);
											$update_fees_due_table->status = 1;
											$update_fees_due_table->save();							

				}

			}
	
		/*-----------CODE FOR TAKING AURAL AND ACCOMPANIMENT FEES ENDS-----------------*/




				/*---------------------EXAM FEES--------------------*/
		
		$finding_teacher = StudentTeacherMapping::whereregi_no($student)
											->wherediscipline($discipline)
											->wherestatus(1)
											->first();	

		$exam_dues = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_teacher($finding_teacher->teacher)
								->wheree_s_d_status(1)
								->get();
		
		
		
		foreach ($exam_dues as $exam_due)
		{
		


			if (isset($_POST["$exam_due->e_s_d_no"]))	
			{	
				$month_paid = date('Ym01');
				

				$exam_fee_rate = GradesFee::wheregrades($exam_due->e_s_d_grades)
								->first();
				$exam_fee_rate = $exam_fee_rate->fees;				


				$pay_exam_fees = new FeesTransaction;
						$pay_exam_fees->regist_no = $student;
						$pay_exam_fees->date1 = $month_paid;
						$pay_exam_fees->billing_date = $billing_date;
						$pay_exam_fees->money_collected = 0;
						$pay_exam_fees->fee_by_month = 0;
						$pay_exam_fees->section = $discipline;
						$pay_exam_fees->particulars = $exam_due->e_s_d_grades;
						$pay_exam_fees->teacher1 = $student_details->teacher;
						$pay_exam_fees->receipt_no = 0;
						$pay_exam_fees->user = $request->user;
						$pay_exam_fees->save();
				
				$update_fees_due_table = ExamStudentDatabase::find($exam_due->e_s_d_no);
											$update_fees_due_table->e_s_d_paid = 1;
											$update_fees_due_table->save();	
				
				
			}		
		}
				


				/*-------------------------EXAM FEES ENDS HERE----------------------*/	



		}




		if (isset($_POST['pay_fees']))
	{
			
			/*-----------CODE FOR TAKING MONTHLY FEES-----------------*/
				
				$paid_till_month = FeesTransaction::select('date1')
													->whereregist_no($student)
													->wheresection($discipline)
													->whereparticulars(1)
													->orderby('date1', 'DESC')
													->count();
				
				$student_details = StudentTeacherMapping::whereregi_no($student)
																->wherediscipline($discipline)
																->wherestatus(1)
																->first();
																
											
																
						$student_level = $student_details->level;
						
						$student_monthly_fee = Gradesfee::wheregrades($student_level)
												->first();
						
						$billing_date = date('Ymd', strtotime("$request->billing_date"));
						
						
				
				if ($paid_till_month == 0)
				{
						$paid_till_month = date('Ym01');
						$months = $request->months_data;
						$for_months = array();
						for ($j=0; $j <=$months-1; $j++)
						{
							
							$for_months[$j] = date('Ymd', strtotime("$paid_till_month"));
							$paid_till_month = date('Ymd', strtotime("$paid_till_month + 1months"));
						
						}		

								foreach ($for_months as $for_month)
					{
						
						$pay_monthly_fee = new FeesTransaction;
						$pay_monthly_fee->regist_no = $student;
						$pay_monthly_fee->date1 = $for_month;
						$pay_monthly_fee->billing_date = $billing_date;
						$pay_monthly_fee->money_collected = $request->money_collected;
						$pay_monthly_fee->fee_by_month = $student_monthly_fee->fees*$student_details->frequency;
						$pay_monthly_fee->section = $discipline;
						$pay_monthly_fee->particulars = 1;
						$pay_monthly_fee->teacher1 = $student_details->teacher;
						$pay_monthly_fee->receipt_no = $request->receipt_no;
						$pay_monthly_fee->user = $request->user;
						$pay_monthly_fee->save();
					}
						
						
						
				
				} else {
						
				$paid_till_month = FeesTransaction::select('date1')
													->whereregist_no($student)
													->wheresection($discipline)
													->whereparticulars(1)
													->orderby('date1', 'DESC')
													->first();
						
				$paid_till_month = date('Ymd', strtotime("$paid_till_month[date1]"));
						
				$months = $request->months_data;
				$for_months = array();
				for ($j=0; $j <=$months-1; $j++)
				{
					
					$for_months[$j] = date('Ymd', strtotime("$paid_till_month + 1months"));
					$paid_till_month = date('Ymd', strtotime("$paid_till_month + 1months"));
					
						
				}
					
					
				foreach ($for_months as $for_month)
					{
						
						$pay_monthly_fee = new FeesTransaction;
						$pay_monthly_fee->regist_no = $student;
						$pay_monthly_fee->date1 = $for_month;
						$pay_monthly_fee->billing_date = $billing_date;
						$pay_monthly_fee->money_collected = $request->money_collected;
						$pay_monthly_fee->fee_by_month = $student_monthly_fee->fees*$student_details->frequency;
						$pay_monthly_fee->section = $discipline;
						$pay_monthly_fee->particulars = 1;
						$pay_monthly_fee->teacher1 = $student_details->teacher;
						$pay_monthly_fee->receipt_no = $request->receipt_no;
						$pay_monthly_fee->user = $request->user;
						$pay_monthly_fee->save();
						
						$if_fee_pending = FeesDue::whereregistration_no($student)
											->whereparticulars(1)
											->wherediscipline_no($discipline)
											->wherefee_date($for_month)
											->wherestatus(0)
											->count();
						
								if ($if_fee_pending == 1)
								{
									$find_in_fees_due_table = FeesDue::whereregistration_no($student)
																->whereparticulars(1)
																->wherediscipline_no($discipline)
																->wherefee_date($for_month)
																->wherestatus(0)
																->first();
									
									$sno = $find_in_fees_due_table->sno;
									
									$update_fees_due_table = FeesDue::find($sno);
											$update_fees_due_table->status = 1;
											$update_fees_due_table->save();	
								}	
					
					
					}
								
					}
		/*-----------CODE FOR TAKING MONTHLY FEES ENDS-----------------*/
		
		
		/*-----------CODE FOR TAKING SCM FEES-----------------*/			
					
					$student_scm_fee = Gradesfee::wheregrades(10)
												->first();				
					
					$scm_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->get();
		
		foreach ($scm_dues as $scm_due)
		{
		
			if (isset($_POST["$scm_due->sno"]))	
				{	
					
						$pay_scm_fee = new FeesTransaction;
						$pay_scm_fee->regist_no = $student;
						$pay_scm_fee->date1 = $scm_due->fee_date;
						$pay_scm_fee->billing_date = $billing_date;
						$pay_scm_fee->money_collected = $request->money_collected;
						$pay_scm_fee->fee_by_month = $student_scm_fee->fees;
						$pay_scm_fee->section = $discipline;
						$pay_scm_fee->particulars = 10;
						$pay_scm_fee->teacher1 = 0;
						$pay_scm_fee->receipt_no = $request->receipt_no;
						$pay_scm_fee->user = $request->user;
						$pay_scm_fee->save();
				
				$update_fees_due_table = FeesDue::find($scm_due->sno);
											$update_fees_due_table->status = 1;
											$update_fees_due_table->save();	
				
				}		
		}
		
	
		/*-----------CODE FOR TAKING SCM FEES ENDS-----------------*/	
		
		/*-----------CODE FOR TAKING AMF FEES-----------------*/			
					
					$student_amf_fee = Gradesfee::wheregrades(9)
												->first();				
					
					$amf_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->get();

		
		foreach ($amf_dues as $amf_due)
		{
		
			if (isset($_POST["$amf_due->sno"]))	
				{	
			
						$pay_amf_fee = new FeesTransaction;
						$pay_amf_fee->regist_no = $student;
						$pay_amf_fee->date1 = $amf_due->fee_date;
						$pay_amf_fee->billing_date = $billing_date;
						$pay_amf_fee->money_collected = $request->money_collected;
						$pay_amf_fee->fee_by_month = $student_amf_fee->fees;
						$pay_amf_fee->section = $discipline;
						$pay_amf_fee->particulars = 9;
						$pay_amf_fee->teacher1 = 0;
						$pay_amf_fee->receipt_no = $request->receipt_no;
						$pay_amf_fee->user = $request->user;
						$pay_amf_fee->save();
				
				$update_fees_due_table = FeesDue::find($amf_due->sno);
											$update_fees_due_table->status = 1;
											$update_fees_due_table->save();	
				
				}		
		}
		
	
		/*-----------CODE FOR TAKING AMF FEES ENDS-----------------*/		

		/*-----------CODE FOR TAKING ENROLMENT FEES-----------------*/	

		if (isset($_POST['enrolment']))	
				{	
					$enrolment_fee_rate = GradesFee::wheregrades(52)
									->first();	


						$pay_enrolment_fees = new FeesTransaction;
						$pay_enrolment_fees->regist_no = $student;
						$pay_enrolment_fees->billing_date = $billing_date;
						$pay_enrolment_fees->money_collected = $request->money_collected;
						$pay_enrolment_fees->fee_by_month = $enrolment_fee_rate->fees;
						$pay_enrolment_fees->section = $discipline;
						$pay_enrolment_fees->particulars = 52;
						$pay_enrolment_fees->teacher1 = 0;
						$pay_enrolment_fees->receipt_no = $request->receipt_no;
						$pay_enrolment_fees->user = $request->user;
						$pay_enrolment_fees->save();
				
				
				$finding_id = StudentTeacherMapping::whereregi_no($student)
											->wherediscipline($discipline)
											->first();		


				$update_enrolment_paid = StudentTeacherMapping::find($finding_id->sl_no);
											$update_enrolment_paid->enrolment = 1;
											$update_enrolment_paid->save();	

			}									


		/*-----------END OF CODE FOR TAKING ENROLMENT FEES-----------------*/	

		/*-----------CODE FOR TAKING REFUNDABLE DEPOSIT-----------------*/	

		
		if (isset($_POST['deposit']))	
				{	
					$refundable_deposit_rate = GradesFee::wheregrades(53)
									->first();	


						$pay_deposit = new FeesTransaction;
						$pay_deposit->regist_no = $student;
						$pay_deposit->billing_date = $billing_date;
						$pay_deposit->money_collected = $request->money_collected;
						$pay_deposit->fee_by_month = $refundable_deposit_rate->fees;
						$pay_deposit->section = $discipline;
						$pay_deposit->particulars = 53;
						$pay_deposit->teacher1 = 0;
						$pay_deposit->receipt_no = $request->receipt_no;
						$pay_deposit->user = $request->user;
						$pay_deposit->save();
				
				
				$finding_id = StudentTeacherMapping::whereregi_no($student)
											->wherediscipline($discipline)
											->first();	

				$update_refundable_deposit = StudentTeacherMapping::find($finding_id->sl_no);
											$update_refundable_deposit->refundable_deposit = 1;
											$update_refundable_deposit->save();	


			}








		/*-----------END OF CODE FOR TAKING REFUNDABLE DEPOSIT-----------------*/	




		/*-----------CODE FOR TAKING LATE FEES-----------------*/			
					
					$student_late_fee = Gradesfee::wheregrades(11)
												->first();				
					
					$late_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(11)
								->wherestatus(0)
								->get();
				
		foreach ($late_dues as $late_due)
		{
		
			if (isset($_POST["$late_due->sno"]))	
				{	
					
						$pay_late_fee = new FeesTransaction;
						$pay_late_fee->regist_no = $student;
						$pay_late_fee->date1 = $late_due->fee_date;
						$pay_late_fee->billing_date = $billing_date;
						$pay_late_fee->money_collected = $request->money_collected;
						$pay_late_fee->fee_by_month = $student_late_fee->fees;
						$pay_late_fee->section = $discipline;
						$pay_late_fee->particulars = 11;
						$pay_late_fee->teacher1 = $student_details->teacher;
						$pay_late_fee->receipt_no = $request->receipt_no;
						$pay_late_fee->user = $request->user;
						$pay_late_fee->save();
				
				$update_late_fee_paid = FeesDue::find($late_due->sno);
											$update_late_fee_paid->status = 1;
											$update_late_fee_paid->save();		
				
				}		
		}
		
	
		/*-----------CODE FOR TAKING LATE FEES ENDS-----------------*/	



		/*-----------CODE FOR TAKING MISCELLENEOUS FEES-----------------*/			
					
								
					
					$student_miscelleneous_dues = FeesDue::whereregistration_no($student)
								->wheresub_cat(8)
								->wherestatus(0)
								->get();

								
				
		foreach ($student_miscelleneous_dues as $student_miscelleneous_due)
		{
		
			$student_miscelleneous_rate = Gradesfee::wheregrades($student_miscelleneous_due->particulars)
												->first();	

												
			if (isset($_POST["$student_miscelleneous_due->sno"]))	
				{	
					
						$pay_miscelleneous_fee = new FeesTransaction;
						$pay_miscelleneous_fee->regist_no = $student;
						$pay_miscelleneous_fee->billing_date = $billing_date;
						$pay_miscelleneous_fee->money_collected = $request->money_collected;
						$pay_miscelleneous_fee->fee_by_month = $student_miscelleneous_rate->fees;
						$pay_miscelleneous_fee->section = $discipline;
						$pay_miscelleneous_fee->particulars = $student_miscelleneous_due->particulars;
						$pay_miscelleneous_fee->teacher1 = $student_details->teacher;
						$pay_miscelleneous_fee->receipt_no = $request->receipt_no;
						$pay_miscelleneous_fee->user = $request->user;
						$pay_miscelleneous_fee->save();
				
				$update_fees_due_table = FeesDue::find($student_miscelleneous_due->sno);
											$update_fees_due_table->status = 1;
											$update_fees_due_table->save();	
				
				}		
		}
		
	
		/*-----------CODE FOR TAKING MISCELLENEOUS FEES ENDS-----------------*/

/*-----------CODE FOR TAKING AURAL AND ACCOMPANIMENT FEES-----------------*/			
					
								
					
					$student_a_and_a_dues = FeesDue::whereregistration_no($student)
													->wherediscipline_no($discipline)
													->whereteacher_no($student_details->teacher)
													->wheresub_cat(10)
													->wherestatus(0)
													->get();

								
				
		
		
		foreach ($student_a_and_a_dues as $student_a_and_a_due) 
		{
			
		$student_a_and_a_rate = Gradesfee::wheregrades($student_a_and_a_due->particulars)
												->first();	

												
			if (isset($_POST["$student_a_and_a_due->sno"]))	
				{	
					
						$pay_a_and_a_fee = new FeesTransaction;
						$pay_a_and_a_fee->regist_no = $student;
						$pay_a_and_a_fee->billing_date = $billing_date;
						$pay_a_and_a_fee->money_collected = $request->money_collected;
						$pay_a_and_a_fee->fee_by_month = $student_a_and_a_rate->fees;
						$pay_a_and_a_fee->section = $discipline;
						$pay_a_and_a_fee->particulars = $student_a_and_a_due->particulars;
						$pay_a_and_a_fee->teacher1 = $student_details->teacher;
						$pay_a_and_a_fee->receipt_no = $request->receipt_no;
						$pay_a_and_a_fee->user = $request->user;
						$pay_a_and_a_fee->save();
				
					$finding_teacher = StudentTeacherMapping::whereregi_no($student)
											->wherediscipline($discipline)
											->wherestatus(1)
											->first();			
					
					$which_exam = ExamStudentDatabase::wheree_s_d_roll_num($student)
									->wheree_s_d_discipline($discipline)
									->wheree_s_d_teacher($finding_teacher->teacher)
									->wheree_s_d_status(1)
									->first();


					$subject_code = FeesDue::wheresno($student_a_and_a_due->sno)
											->first();
										

					$add_to_a_and_a_list = new AuralAndAccompaniment;
					$add_to_a_and_a_list->a_code = $which_exam->e_s_d_code;
					$add_to_a_and_a_list->a_roll_no = $which_exam->e_s_d_roll_num;
					$add_to_a_and_a_list->a_discipline = $which_exam->e_s_d_discipline;
					$add_to_a_and_a_list->a_teacher = $which_exam->e_s_d_teacher;
					$add_to_a_and_a_list->subject_code = $subject_code->particulars;
					$add_to_a_and_a_list->save();	


					$update_fees_due_table = FeesDue::find($student_a_and_a_due->sno);
											$update_fees_due_table->status = 1;
											$update_fees_due_table->save();							

				}

			}
	
		/*-----------CODE FOR TAKING AURAL AND ACCOMPANIMENT FEES ENDS-----------------*/




				/*---------------------EXAM FEES--------------------*/
		
		$finding_teacher = StudentTeacherMapping::whereregi_no($student)
											->wherediscipline($discipline)
											->wherestatus(1)
											->first();	

		$exam_dues = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_teacher($finding_teacher->teacher)
								->wheree_s_d_status(1)
								->get();
		
		
		
		foreach ($exam_dues as $exam_due)
		{
		


			if (isset($_POST["$exam_due->e_s_d_no"]))	
			{	
				$month_paid = date('Ym01');
				

				$exam_fee_rate = GradesFee::wheregrades($exam_due->e_s_d_grades)
								->first();
				$exam_fee_rate = $exam_fee_rate->fees;				


				$pay_exam_fees = new FeesTransaction;
						$pay_exam_fees->regist_no = $student;
						$pay_exam_fees->date1 = $month_paid;
						$pay_exam_fees->billing_date = $billing_date;
						$pay_exam_fees->money_collected = $request->money_collected;
						$pay_exam_fees->fee_by_month = $exam_fee_rate;
						$pay_exam_fees->section = $discipline;
						$pay_exam_fees->particulars = $exam_due->e_s_d_grades;
						$pay_exam_fees->teacher1 = $student_details->teacher;
						$pay_exam_fees->receipt_no = $request->receipt_no;
						$pay_exam_fees->user = $request->user;
						$pay_exam_fees->save();
				
				$update_fees_due_table = ExamStudentDatabase::find($exam_due->e_s_d_no);
											$update_fees_due_table->e_s_d_paid = 1;
											$update_fees_due_table->save();	
				
				
			}		
		}
				


				/*-------------------------EXAM FEES ENDS HERE----------------------*/	


				$money_collected = $request->money_collected;

				$query = StudentTeacherMapping::wherediscipline($discipline)
										->whereteacher($finding_teacher->teacher)
										->whereregi_no($student)
										->wherestatus(1)
										->first();
				
				$totaled_money = $request->totaled_money;
				$money_collected = $request->money_collected;

				$money_in_account = $query->diff_amount;
				$calculation_diff_amount = $money_collected - $totaled_money;
								
				
					$updating_diff_amount = StudentTeacherMapping::find($query->sl_no);	
					$updating_diff_amount->diff_amount = $calculation_diff_amount;	
					$updating_diff_amount->save();
				
				



	}	
			
		
		$finding_teacher = StudentTeacherMapping::whereregi_no($student)
											->wherediscipline($discipline)
											->wherestatus(1)
											->first();
	
			

		$fresh_months_count = FeesTransaction::whereregist_no($student)
								->whereparticulars(1)
								->wheresection($discipline)
								->whereteacher1($finding_teacher->teacher)
								->count();
								

		$fee_months_count = FeesDue::whereregistration_no($student)
								->whereparticulars(1)
								->wherediscipline_no($discipline)
								->whereteacher_no($finding_teacher->teacher)
								->wherestatus(0)
								->count();
		$amf_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->get();
		$scm_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->get();
		$exam_fee_dues = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($finding_teacher->teacher)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->get();	

								
		$scm_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->count();
		$amf_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->count();
		$exam_fee_due_count = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($finding_teacher->teacher)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->count();
					
		$miscelleneous_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(8)
										->wherestatus(0)
										->count();				

		$miscelleneous_dues = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(8)
										->wherestatus(0)
										->get();			

		$a_and_a_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(10)
										->wherestatus(0)
										->count();				

		$a_and_a_dues = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(10)
										->wherestatus(0)
										->get();																						
		

		$late_fees_due_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->whereparticulars(11)
										->wherestatus(0)
										->count();
		$late_fees_due = FeesDue::whereregistration_no($student)
									->whereteacher_no($finding_teacher->teacher)
									->whereparticulars(11)
									->wherestatus(0)
									->get();	
																																						
		$amf_rate = GradesFee::wheregrades(9)->get();						
		$scm_rate = GradesFee::wheregrades(10)->get();													
		$enrolments = GradesFee::wheregrades(52)->get();
		$deposits = GradesFee::wheregrades(53)->get();
		$late_fee_rate = GradesFee::wheregrades(11)->get();	

		$theory_or_practicals = ExamStudentDatabase::wheree_s_d_roll_num($student)
											->wheree_s_d_teacher($finding_teacher->teacher)		
											->wheree_s_d_discipline($discipline)
											->wheree_s_d_status(1)
											->count();

					if ($theory_or_practicals > 0)

					{						

		$theory_or_practicals = ExamStudentDatabase::wheree_s_d_roll_num($student)
											->wheree_s_d_teacher($finding_teacher->teacher)		
											->wheree_s_d_discipline($discipline)
											->wheree_s_d_status(1)
											->first();

		$if_practical = ExamsTable::whereexam_no($theory_or_practicals->e_s_d_code)
										->first();

										if ($if_practical->category_code == 1)
										{
											$if_practical = 1;
										}
										else {
										$if_practical = 0;
										}
					}else{															
					
						$if_practical = 0;

					}


		$query = StudentTeacherMapping::wherediscipline($discipline)
										->whereteacher($finding_teacher->teacher)
										->whereregi_no($student)
										->wherestatus(1)
										->get();
					
				
				return view('individual', compact('if_practical', 'a_and_a_count', 'a_and_a_dues', 'miscelleneous_count', 'miscelleneous_dues', 'query', 'enrolments', 'deposits', 'fresh_months_count', 'fee_months_count', 'amf_dues', 'scm_dues', 'amf_rate', 'scm_rate', 'scm_due_count', 'amf_due_count', 'exam_fee_due_count', 'exam_fee_dues', 'late_fees_due_count', 'late_fees_due', 'late_fee_rate'));
				
    }
	
		/*-----------CODE FOR THE INDIVIDUAL PAGE ENDS-----------------*/	
		
			/*-----------CODE SMALL TRANSACTIONS-----------------*/	
	
		public function miscelleneous(Request $request, $discipline, $teacher, $student)

		{
			if (isset($_POST['miscelleneous_add_to_exams']))

			{

				$miscelleneous_fees = Gradesfee::wheresub_category(8)->get();

				foreach ($miscelleneous_fees as $pay)
				{

					if (isset($_POST["$pay->grades"]))

					{	
					
					$insert_to_due = new FeesDue;
									 
					$insert_to_due->registration_no = $student;
					$insert_to_due->discipline_no = $discipline;
					$insert_to_due->teacher_no = $teacher;
					$insert_to_due->particulars = $pay->grades;
					$insert_to_due->sub_cat = 8;
					$insert_to_due->save();

					}
				}	
			
		$finding_teacher = StudentTeacherMapping::whereregi_no($student)
											->wherediscipline($discipline)
											->wherestatus(1)
											->first();
	
		$fresh_months_count = FeesTransaction::whereregist_no($student)
								->whereparticulars(1)
								->wheresection($discipline)
								->whereteacher1($finding_teacher->teacher)
								->count();

		$fee_months_count = FeesDue::whereregistration_no($student)
								->whereparticulars(1)
								->wherediscipline_no($discipline)
								->whereteacher_no($finding_teacher->teacher)
								->wherestatus(0)
								->count();
		$amf_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->get();
		$scm_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->get();
		$exam_fee_dues = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($finding_teacher->teacher)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->get();	

								
		$scm_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->count();
		$amf_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->count();
		$exam_fee_due_count = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($finding_teacher->teacher)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->count();
					
		$miscelleneous_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(8)
										->wherestatus(0)
										->count();				

		$miscelleneous_dues = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(8)
										->wherestatus(0)
										->get();			

		$a_and_a_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(10)
										->wherestatus(0)
										->count();				

		$a_and_a_dues = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(10)
										->wherestatus(0)
										->get();																						
		

		$late_fees_due_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->whereparticulars(11)
										->wherestatus(0)
										->count();
		$late_fees_due = FeesDue::whereregistration_no($student)
									->whereteacher_no($finding_teacher->teacher)
									->whereparticulars(11)
									->wherestatus(0)
									->get();	
																																						
		$amf_rate = GradesFee::wheregrades(9)->get();						
		$scm_rate = GradesFee::wheregrades(10)->get();													
		$enrolments = GradesFee::wheregrades(52)->get();
		$deposits = GradesFee::wheregrades(53)->get();
		$late_fee_rate = GradesFee::wheregrades(11)->get();	

		$theory_or_practicals = ExamStudentDatabase::wheree_s_d_roll_num($student)
											->wheree_s_d_teacher($finding_teacher->teacher)		
											->wheree_s_d_discipline($discipline)
											->wheree_s_d_status(1)
											->count();

					if ($theory_or_practicals > 0)

					{						

		$theory_or_practicals = ExamStudentDatabase::wheree_s_d_roll_num($student)
											->wheree_s_d_teacher($finding_teacher->teacher)		
											->wheree_s_d_discipline($discipline)
											->wheree_s_d_status(1)
											->first();

		$if_practical = ExamsTable::whereexam_no($theory_or_practicals->e_s_d_code)
										->first();

										if ($if_practical->category_code == 1)
										{
											$if_practical = 1;
										}
										else {
										$if_practical = 0;
										}
					}else{															
					
						$if_practical = 0;

					}

		$query = StudentTeacherMapping::wherediscipline($discipline)
										->whereteacher($finding_teacher->teacher)
										->whereregi_no($student)
										->wherestatus(1)
										->get();
					
				
				return view('individual', compact('if_practical', 'a_and_a_count', 'a_and_a_dues', 'miscelleneous_count', 'miscelleneous_dues', 'query', 'enrolments', 'deposits', 'fresh_months_count', 'fee_months_count', 'amf_dues', 'scm_dues', 'amf_rate', 'scm_rate', 'scm_due_count', 'amf_due_count', 'exam_fee_due_count', 'exam_fee_dues', 'late_fees_due_count', 'late_fees_due', 'late_fee_rate'));
				
				
			}

			$miscelleneous_fees = Gradesfee::wheresub_category(8)->get();



			return view('Forms.miscelleneous_fees', compact('miscelleneous_fees', 'discipline', 'teacher', 'student'));
		}	




		public function trinity_practical(Request $request, $discipline, $teacher, $student)
		{
			if (isset($_POST['trinity_practical_add_to_exams']))
			{
				                                                                                       
				
				$exam_fee_due_count = ExamStudentDatabase::wheree_s_d_roll_num($student)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_code($request->exam_code)
								->wheree_s_d_status(1)
								->count();				
				
				if ($exam_fee_due_count > 0)
					{
						
						return view('exit');
					}
					else
					{
				
				$trinity_practical_add_to_exams = new ExamStudentDatabase;
				
				$trinity_practical_add_to_exams->e_s_d_roll_num = $student;
				$trinity_practical_add_to_exams->e_s_d_code = $request->exam_code;
				$trinity_practical_add_to_exams->e_s_d_discipline = $discipline;
				$trinity_practical_add_to_exams->e_s_d_teacher = $teacher;
				$trinity_practical_add_to_exams->e_s_d_grades = $request->grade_selection;
				$trinity_practical_add_to_exams->e_s_d_user = $request->user;
				$trinity_practical_add_to_exams->save();
				
					}
				
				
				/*-----------CODE FOR THE INDIVIDUAL PAGE-----------------*/
				
		$finding_teacher = StudentTeacherMapping::whereregi_no($student)
											->wherediscipline($discipline)
											->wherestatus(1)
											->first();
	
		$fresh_months_count = FeesTransaction::whereregist_no($student)
								->whereparticulars(1)
								->wheresection($discipline)
								->whereteacher1($finding_teacher->teacher)
								->count();

		$fee_months_count = FeesDue::whereregistration_no($student)
								->whereparticulars(1)
								->wherediscipline_no($discipline)
								->whereteacher_no($finding_teacher->teacher)
								->wherestatus(0)
								->count();
		$amf_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->get();
		$scm_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->get();
		$exam_fee_dues = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($finding_teacher->teacher)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->get();	

								
		$scm_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->count();
		$amf_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->count();
		$exam_fee_due_count = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($finding_teacher->teacher)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->count();
					
		$miscelleneous_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(8)
										->wherestatus(0)
										->count();				

		$miscelleneous_dues = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(8)
										->wherestatus(0)
										->get();			

		$a_and_a_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(10)
										->wherestatus(0)
										->count();				

		$a_and_a_dues = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(10)
										->wherestatus(0)
										->get();																						
		

		$late_fees_due_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->whereparticulars(11)
										->wherestatus(0)
										->count();
		$late_fees_due = FeesDue::whereregistration_no($student)
									->whereteacher_no($finding_teacher->teacher)
									->whereparticulars(11)
									->wherestatus(0)
									->get();	
																																						
		$amf_rate = GradesFee::wheregrades(9)->get();						
		$scm_rate = GradesFee::wheregrades(10)->get();													
		$enrolments = GradesFee::wheregrades(52)->get();
		$deposits = GradesFee::wheregrades(53)->get();
		$late_fee_rate = GradesFee::wheregrades(11)->get();	

		$theory_or_practicals = ExamStudentDatabase::wheree_s_d_roll_num($student)
											->wheree_s_d_teacher($finding_teacher->teacher)		
											->wheree_s_d_discipline($discipline)
											->wheree_s_d_status(1)
											->count();

					if ($theory_or_practicals > 0)

					{						

		$theory_or_practicals = ExamStudentDatabase::wheree_s_d_roll_num($student)
											->wheree_s_d_teacher($finding_teacher->teacher)		
											->wheree_s_d_discipline($discipline)
											->wheree_s_d_status(1)
											->first();

		$if_practical = ExamsTable::whereexam_no($theory_or_practicals->e_s_d_code)
										->first();

										if ($if_practical->category_code == 1)
										{
											$if_practical = 1;
										}
										else {
										$if_practical = 0;
										}
					}else{															
					
						$if_practical = 0;

					}

		$query = StudentTeacherMapping::wherediscipline($discipline)
										->whereteacher($finding_teacher->teacher)
										->whereregi_no($student)
										->wherestatus(1)
										->get();
					
				
				return view('individual', compact('if_practical', 'a_and_a_count', 'a_and_a_dues', 'miscelleneous_count', 'miscelleneous_dues', 'query', 'enrolments', 'deposits', 'fresh_months_count', 'fee_months_count', 'amf_dues', 'scm_dues', 'amf_rate', 'scm_rate', 'scm_due_count', 'amf_due_count', 'exam_fee_due_count', 'exam_fee_dues', 'late_fees_due_count', 'late_fees_due', 'late_fee_rate'));
				
				
				
				
				/*-----------CODE FOR THE INDIVIDUAL PAGE ENDS HERE-----------------*/
				
				
				
			} else
				{
			
					$exams = ExamsTable::whereexam_code(1)
								->wherecategory_code(1)
								->wherestatus(1)
								->get();
					$grades = GradesFee::where('grades', '>=', '40')
											->where('grades', '<=', '48')
											->get();
											
								return view('Forms.trinity_practical', compact('exams', 'grades', 'discipline', 'teacher', 'student'));
				}
		}
		
		public function trinity_theory(Request $request, $discipline, $teacher, $student)
		{
			if (isset($_POST['trinity_theory_add_to_exams']))
			{
				$exam_fee_due_count = ExamStudentDatabase::wheree_s_d_roll_num($student)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->count();				
				
				if ($exam_fee_due_count > 0)
					{
						return view('exit');
					}
					else
					{
				
				$trinity_theory_add_to_exams = new ExamStudentDatabase;
				
				$trinity_theory_add_to_exams->e_s_d_roll_num = $student;
				$trinity_theory_add_to_exams->e_s_d_code = $request->exam_code;
				$trinity_theory_add_to_exams->e_s_d_discipline = $discipline;
				$trinity_theory_add_to_exams->e_s_d_teacher = $teacher;
				$trinity_theory_add_to_exams->e_s_d_grades = $request->grade_selection;
				$trinity_theory_add_to_exams->e_s_d_user = $request->user;
				$trinity_theory_add_to_exams->save();
				
				
			}
				
				
				
				
				/*-----------CODE FOR THE INDIVIDUAL PAGE-----------------*/
				
		$finding_teacher = StudentTeacherMapping::whereregi_no($student)
											->wherediscipline($discipline)
											->wherestatus(1)
											->first();
	
		$fresh_months_count = FeesTransaction::whereregist_no($student)
								->whereparticulars(1)
								->wheresection($discipline)
								->whereteacher1($finding_teacher->teacher)
								->count();

		$fee_months_count = FeesDue::whereregistration_no($student)
								->whereparticulars(1)
								->wherediscipline_no($discipline)
								->whereteacher_no($finding_teacher->teacher)
								->wherestatus(0)
								->count();
		$amf_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->get();
		$scm_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->get();
		$exam_fee_dues = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($finding_teacher->teacher)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->get();	

								
		$scm_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->count();
		$amf_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->count();
		$exam_fee_due_count = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($finding_teacher->teacher)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->count();
					
		$miscelleneous_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(8)
										->wherestatus(0)
										->count();				

		$miscelleneous_dues = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(8)
										->wherestatus(0)
										->get();			

		$a_and_a_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(10)
										->wherestatus(0)
										->count();				

		$a_and_a_dues = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(10)
										->wherestatus(0)
										->get();																						
		

		$late_fees_due_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->whereparticulars(11)
										->wherestatus(0)
										->count();
		$late_fees_due = FeesDue::whereregistration_no($student)
									->whereteacher_no($finding_teacher->teacher)
									->whereparticulars(11)
									->wherestatus(0)
									->get();	
																																						
		$amf_rate = GradesFee::wheregrades(9)->get();						
		$scm_rate = GradesFee::wheregrades(10)->get();													
		$enrolments = GradesFee::wheregrades(52)->get();
		$deposits = GradesFee::wheregrades(53)->get();
		$late_fee_rate = GradesFee::wheregrades(11)->get();	

		$theory_or_practicals = ExamStudentDatabase::wheree_s_d_roll_num($student)
											->wheree_s_d_teacher($finding_teacher->teacher)		
											->wheree_s_d_discipline($discipline)
											->wheree_s_d_status(1)
											->count();

					if ($theory_or_practicals > 0)

					{						

		$theory_or_practicals = ExamStudentDatabase::wheree_s_d_roll_num($student)
											->wheree_s_d_teacher($finding_teacher->teacher)		
											->wheree_s_d_discipline($discipline)
											->wheree_s_d_status(1)
											->first();

		$if_practical = ExamsTable::whereexam_no($theory_or_practicals->e_s_d_code)
										->first();

										if ($if_practical->category_code == 1)
										{
											$if_practical = 1;
										}
										else {
										$if_practical = 0;
										}
					}else{															
					
						$if_practical = 0;

					}



		$query = StudentTeacherMapping::wherediscipline($discipline)
										->whereteacher($finding_teacher->teacher)
										->whereregi_no($student)
										->wherestatus(1)
										->get();
					
				
				return view('individual', compact('if_practical', 'a_and_a_count', 'a_and_a_dues', 'miscelleneous_count', 'miscelleneous_dues', 'query', 'enrolments', 'deposits', 'fresh_months_count', 'fee_months_count', 'amf_dues', 'scm_dues', 'amf_rate', 'scm_rate', 'scm_due_count', 'amf_due_count', 'exam_fee_due_count', 'exam_fee_dues', 'late_fees_due_count', 'late_fees_due', 'late_fee_rate'));
				
				
				
				
				/*-----------CODE FOR THE INDIVIDUAL PAGE ENDS HERE-----------------*/
				
				
				
				
				
				
			} else
				{
			
					$exams = ExamsTable::whereexam_code(1)
						->wherecategory_code(2)
						->wherestatus(1)
						->get();
			
			$grades = GradesFee::where('grades', '>=', '32')
									->where('grades', '<=', '39')
									->get();
									
						return view('Forms.trinity_theory', compact('exams', 'grades', 'discipline', 'teacher', 'student'));
				}
		}
		
		public function abrsm_practical(Request $request, $discipline, $teacher, $student)
		{
			if (isset($_POST['abrsm_practical_add_to_exams']))
			{
				
				$exam_fee_due_count = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_code($request->exam_code)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->count();				
				

				if ($exam_fee_due_count > 0)
					{
						return view('exit');
					}
					else
					{
				
				$abrsm_practical_add_to_exams = new ExamStudentDatabase;
				
				$abrsm_practical_add_to_exams->e_s_d_roll_num = $student;
				$abrsm_practical_add_to_exams->e_s_d_code = $request->exam_code;
				$abrsm_practical_add_to_exams->e_s_d_discipline = $discipline;
				$abrsm_practical_add_to_exams->e_s_d_teacher = $teacher;
				$abrsm_practical_add_to_exams->e_s_d_grades = $request->grade_selection;
				$abrsm_practical_add_to_exams->e_s_d_user = $request->user;
				$abrsm_practical_add_to_exams->save();
				
					}
				
				
				
				
				
				/*-----------CODE FOR THE INDIVIDUAL PAGE-----------------*/
				
		$finding_teacher = StudentTeacherMapping::whereregi_no($student)
											->wherediscipline($discipline)
											->wherestatus(1)
											->first();
	
		$fresh_months_count = FeesTransaction::whereregist_no($student)
								->whereparticulars(1)
								->wheresection($discipline)
								->whereteacher1($finding_teacher->teacher)
								->count();

		$fee_months_count = FeesDue::whereregistration_no($student)
								->whereparticulars(1)
								->wherediscipline_no($discipline)
								->whereteacher_no($finding_teacher->teacher)
								->wherestatus(0)
								->count();
		$amf_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->get();
		$scm_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->get();
		$exam_fee_dues = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($finding_teacher->teacher)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->get();	

								
		$scm_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->count();
		$amf_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->count();
		$exam_fee_due_count = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($finding_teacher->teacher)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->count();
					
		$miscelleneous_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(8)
										->wherestatus(0)
										->count();				

		$miscelleneous_dues = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(8)
										->wherestatus(0)
										->get();			

		$a_and_a_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(10)
										->wherestatus(0)
										->count();				

		$a_and_a_dues = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(10)
										->wherestatus(0)
										->get();																						
		

		$late_fees_due_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->whereparticulars(11)
										->wherestatus(0)
										->count();
		$late_fees_due = FeesDue::whereregistration_no($student)
									->whereteacher_no($finding_teacher->teacher)
									->whereparticulars(11)
									->wherestatus(0)
									->get();	
																																						
		$amf_rate = GradesFee::wheregrades(9)->get();						
		$scm_rate = GradesFee::wheregrades(10)->get();													
		$enrolments = GradesFee::wheregrades(52)->get();
		$deposits = GradesFee::wheregrades(53)->get();
		$late_fee_rate = GradesFee::wheregrades(11)->get();	

		$theory_or_practicals = ExamStudentDatabase::wheree_s_d_roll_num($student)
											->wheree_s_d_teacher($finding_teacher->teacher)		
											->wheree_s_d_discipline($discipline)
											->wheree_s_d_status(1)
											->count();

					if ($theory_or_practicals > 0)

					{						

		$theory_or_practicals = ExamStudentDatabase::wheree_s_d_roll_num($student)
											->wheree_s_d_teacher($finding_teacher->teacher)		
											->wheree_s_d_discipline($discipline)
											->wheree_s_d_status(1)
											->first();

		$if_practical = ExamsTable::whereexam_no($theory_or_practicals->e_s_d_code)
										->first();

										if ($if_practical->category_code == 1)
										{
											$if_practical = 1;
										}
										else {
										$if_practical = 0;
										}
					}else{															
					
						$if_practical = 0;

					}

		$query = StudentTeacherMapping::wherediscipline($discipline)
										->whereteacher($finding_teacher->teacher)
										->whereregi_no($student)
										->wherestatus(1)
										->get();
					
				
				return view('individual', compact('if_practical', 'a_and_a_count', 'a_and_a_dues', 'miscelleneous_count', 'miscelleneous_dues', 'query', 'enrolments', 'deposits', 'fresh_months_count', 'fee_months_count', 'amf_dues', 'scm_dues', 'amf_rate', 'scm_rate', 'scm_due_count', 'amf_due_count', 'exam_fee_due_count', 'exam_fee_dues', 'late_fees_due_count', 'late_fees_due', 'late_fee_rate'));
				
				
				
				
				/*-----------CODE FOR THE INDIVIDUAL PAGE ENDS HERE-----------------*/
				
				
				
				
				
				
			} else
				{
			
			$exams = ExamsTable::whereexam_code(2)
						->wherecategory_code(1)
						->wherestatus(1)
						->get();


			$grades = GradesFee::where('grades', '>=', '24')
									->where('grades', '<=', '31')
									->get();
									
						return view('Forms.abrsm_practical', compact('exams', 'grades', 'discipline', 'teacher', 'student'));
				}
		}
		
		public function abrsm_theory(Request $request, $discipline, $teacher, $student)
		{
			if (isset($_POST['abrsm_theory_add_to_exams']))
			{
				
				$exam_fee_due_count = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_code($request->exam_code)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->count();				
				
				if ($exam_fee_due_count > 0)
					{
						return view('exit');
					}
					else
					{
				
				$abrsm_theory_add_to_exams = new ExamStudentDatabase;
				
				$abrsm_theory_add_to_exams->e_s_d_roll_num = $student;
				$abrsm_theory_add_to_exams->e_s_d_code = $request->exam_code;
				$abrsm_theory_add_to_exams->e_s_d_discipline = $discipline;
				$abrsm_theory_add_to_exams->e_s_d_teacher = $teacher;
				$abrsm_theory_add_to_exams->e_s_d_grades = $request->grade_selection;
				$abrsm_theory_add_to_exams->e_s_d_user = $request->user;
				$abrsm_theory_add_to_exams->save();
				
					}
				
				
				
				
				
				/*-----------CODE FOR THE INDIVIDUAL PAGE-----------------*/
				
		$finding_teacher = StudentTeacherMapping::whereregi_no($student)
											->wherediscipline($discipline)
											->wherestatus(1)
											->first();
	
		$fresh_months_count = FeesTransaction::whereregist_no($student)
								->whereparticulars(1)
								->wheresection($discipline)
								->whereteacher1($finding_teacher->teacher)
								->count();

		$fee_months_count = FeesDue::whereregistration_no($student)
								->whereparticulars(1)
								->wherediscipline_no($discipline)
								->whereteacher_no($finding_teacher->teacher)
								->wherestatus(0)
								->count();
		$amf_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->get();
		$scm_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->get();
		$exam_fee_dues = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($finding_teacher->teacher)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->get();	

								
		$scm_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->count();
		$amf_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->count();
		$exam_fee_due_count = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($finding_teacher->teacher)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->count();
					
		$miscelleneous_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(8)
										->wherestatus(0)
										->count();				

		$miscelleneous_dues = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(8)
										->wherestatus(0)
										->get();			

		$a_and_a_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(10)
										->wherestatus(0)
										->count();				

		$a_and_a_dues = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(10)
										->wherestatus(0)
										->get();																						
		

		$late_fees_due_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->whereparticulars(11)
										->wherestatus(0)
										->count();
		$late_fees_due = FeesDue::whereregistration_no($student)
									->whereteacher_no($finding_teacher->teacher)
									->whereparticulars(11)
									->wherestatus(0)
									->get();	
																																						
		$amf_rate = GradesFee::wheregrades(9)->get();						
		$scm_rate = GradesFee::wheregrades(10)->get();													
		$enrolments = GradesFee::wheregrades(52)->get();
		$deposits = GradesFee::wheregrades(53)->get();
		$late_fee_rate = GradesFee::wheregrades(11)->get();	

		$theory_or_practicals = ExamStudentDatabase::wheree_s_d_roll_num($student)
											->wheree_s_d_teacher($finding_teacher->teacher)		
											->wheree_s_d_discipline($discipline)
											->wheree_s_d_status(1)
											->count();

					if ($theory_or_practicals > 0)

					{						

		$theory_or_practicals = ExamStudentDatabase::wheree_s_d_roll_num($student)
											->wheree_s_d_teacher($finding_teacher->teacher)		
											->wheree_s_d_discipline($discipline)
											->wheree_s_d_status(1)
											->first();

		$if_practical = ExamsTable::whereexam_no($theory_or_practicals->e_s_d_code)
										->first();

										if ($if_practical->category_code == 1)
										{
											$if_practical = 1;
										}
										else {
										$if_practical = 0;
										}
					}else{															
					
						$if_practical = 0;

					}

		$query = StudentTeacherMapping::wherediscipline($discipline)
										->whereteacher($finding_teacher->teacher)
										->whereregi_no($student)
										->wherestatus(1)
										->get();
					
				
				return view('individual', compact('if_practical', 'a_and_a_count', 'a_and_a_dues', 'miscelleneous_count', 'miscelleneous_dues', 'query', 'enrolments', 'deposits', 'fresh_months_count', 'fee_months_count', 'amf_dues', 'scm_dues', 'amf_rate', 'scm_rate', 'scm_due_count', 'amf_due_count', 'exam_fee_due_count', 'exam_fee_dues', 'late_fees_due_count', 'late_fees_due', 'late_fee_rate'));
				
				
				
				
				/*-----------CODE FOR THE INDIVIDUAL PAGE ENDS HERE-----------------*/
				
				
				
				
				
				
			} else
				{
			
			$exams = ExamsTable::whereexam_code(2)
						->wherecategory_code(2)
						->wherestatus(1)
						->get();
			$grades = GradesFee::where('grades', '>=', '16')
									->where('grades', '<=', '23')
									->get();
									
						return view('Forms.abrsm_theory', compact('exams', 'grades', 'discipline', 'teacher', 'student'));
				}
		}
		/*-----------CODE SMALL TRANSACTIONS ENDS-----------------*/	


		










public function aural_and_accompaniment(Request $request, $discipline, $teacher, $student)
		{
			if (isset($_POST['a_and_a_add_to_dues']))
			{
				$a_and_a_dues = Gradesfee::wheresub_category(10)->get();

				foreach ($a_and_a_dues as $a_and_a_due)
				{

					if (isset($_POST["$a_and_a_due->grades"]))

					{	
					
					$insert_to_due = new FeesDue;
									 
					$insert_to_due->registration_no = $student;
					$insert_to_due->discipline_no = $discipline;
					$insert_to_due->teacher_no = $teacher;
					$insert_to_due->particulars = $a_and_a_due->grades;
					$insert_to_due->sub_cat = 10;
					$insert_to_due->save();

					}
				}	
				
				/*-----------CODE FOR THE INDIVIDUAL PAGE-----------------*/
				
		$finding_teacher = StudentTeacherMapping::whereregi_no($student)
											->wherediscipline($discipline)
											->wherestatus(1)
											->first();
	
		$fresh_months_count = FeesTransaction::whereregist_no($student)
								->whereparticulars(1)
								->wheresection($discipline)
								->whereteacher1($finding_teacher->teacher)
								->count();

		$fee_months_count = FeesDue::whereregistration_no($student)
								->whereparticulars(1)
								->wherediscipline_no($discipline)
								->whereteacher_no($finding_teacher->teacher)
								->wherestatus(0)
								->count();
		$amf_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->get();
		$scm_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->get();
		$exam_fee_dues = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($finding_teacher->teacher)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->get();	

								
		$scm_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->count();
		$amf_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->count();
		$exam_fee_due_count = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($finding_teacher->teacher)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->count();
					
		$miscelleneous_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(8)
										->wherestatus(0)
										->count();				

		$miscelleneous_dues = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(8)
										->wherestatus(0)
										->get();			

		$a_and_a_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(10)
										->wherestatus(0)
										->count();				

		$a_and_a_dues = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(10)
										->wherestatus(0)
										->get();																						
		

		$late_fees_due_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->whereparticulars(11)
										->wherestatus(0)
										->count();
		$late_fees_due = FeesDue::whereregistration_no($student)
									->whereteacher_no($finding_teacher->teacher)
									->whereparticulars(11)
									->wherestatus(0)
									->get();	
																																						
		$amf_rate = GradesFee::wheregrades(9)->get();						
		$scm_rate = GradesFee::wheregrades(10)->get();													
		$enrolments = GradesFee::wheregrades(52)->get();
		$deposits = GradesFee::wheregrades(53)->get();
		$late_fee_rate = GradesFee::wheregrades(11)->get();	

		$theory_or_practicals = ExamStudentDatabase::wheree_s_d_roll_num($student)
											->wheree_s_d_teacher($finding_teacher->teacher)		
											->wheree_s_d_discipline($discipline)
											->wheree_s_d_status(1)
											->count();

					if ($theory_or_practicals > 0)

					{						

		$theory_or_practicals = ExamStudentDatabase::wheree_s_d_roll_num($student)
											->wheree_s_d_teacher($finding_teacher->teacher)		
											->wheree_s_d_discipline($discipline)
											->wheree_s_d_status(1)
											->first();

		$if_practical = ExamsTable::whereexam_no($theory_or_practicals->e_s_d_code)
										->first();

										if ($if_practical->category_code == 1)
										{
											$if_practical = 1;
										}
										else {
										$if_practical = 0;
										}
					}else{															
					
						$if_practical = 0;

					}

		$query = StudentTeacherMapping::wherediscipline($discipline)
										->whereteacher($finding_teacher->teacher)
										->whereregi_no($student)
										->wherestatus(1)
										->get();
					
				
				return view('individual', compact('if_practical', 'a_and_a_count', 'a_and_a_dues', 'miscelleneous_count', 'miscelleneous_dues', 'query', 'enrolments', 'deposits', 'fresh_months_count', 'fee_months_count', 'amf_dues', 'scm_dues', 'amf_rate', 'scm_rate', 'scm_due_count', 'amf_due_count', 'exam_fee_due_count', 'exam_fee_dues', 'late_fees_due_count', 'late_fees_due', 'late_fee_rate'));
				
			}

			$aural_and_accompaniment = Gradesfee::wheresub_category(10)->get();



			return view('Forms.aural_and_accompaniment', compact('aural_and_accompaniment', 'discipline', 'teacher', 'student'));
				
				
				/*-----------CODE FOR THE INDIVIDUAL PAGE ENDS HERE-----------------*/
				
	}





























		public function edit_student($discipline, $teacher, $student)
		{
				


				$stu_information = StudentInformation::wherereg_no($student)->first();

				$stu_data_information = StudentTeacherMapping::whereregi_no($student)
																->whereteacher($teacher)
																->wherediscipline($discipline)
																->wherestatus(1)
																->first();
				
				$fee_parameters = GradesFee:: where('sub_category', '=', '1')
										->where('grades', '!=', '12')
										->get();

				$chosen_discipline = Discipline::where('discipline_id', '=', "$stu_data_information->discipline")->first();
				
				$if_fee_needs_paying = FeesDue::whereregistration_no($student)
												->whereteacher_no($teacher)
												->wherediscipline_no($discipline)
												->wherestatus(0)
												->count();

			return view('Forms.edit_student', compact('if_fee_needs_paying', 'stu_information', 'stu_data_information', 'fee_parameters', 'teacher_details'));
		}


		public function change_parameters($discipline, $teacher, $student)
		{

				$stu_information = StudentInformation::wherereg_no($student)->first();

				
				$stu_data_information = StudentTeacherMapping::whereregi_no($student)
																->whereteacher($teacher)
																->wherediscipline($discipline)
																->wherestatus(1)
																->first();

				$query = Discipline::whereSubCategory(1)->get();
		
					
			return view('Forms.edit_student_change_parameters', compact('query', 'stu_information', 'stu_data_information', 'fee_parameters', 'teacher_details', 'choose_a_level'));


				}


	public function change_parameters2(Request $request, $discipline, $teacher, $student)
		{
				
		$stu_name = $request->stu_name;
		$dob = $request->dob;
		$discipline_id = $request->discipline;
		$lesson_mode = $request->lesson_mode;
		$father_name = $request->father_name;
		$father_designation = $request->father_designation;
		$mother_name = $request->mother_name;
		$mother_designation = $request->mother_designation;
		$address = $request->address;
		$pincode = $request->pincode;
		$phone_no = $request->phone_no;
		$email_address1 = $request->email_address1;
		
		$fee_parameters = GradesFee:: where('sub_category', '=', '1')
										->where('grades', '!=', '12')
										->get();

					
		$stu_data_information = StudentTeacherMapping::whereregi_no($student)
																->whereteacher($teacher)
																->wherediscipline($discipline)
																->wherestatus(1)
																->first();								
		$level = '12'; /*FOR GROUP LESSONS*/
		$chosen_discipline = Discipline::where('discipline_id', '=', "$discipline_id")->first();
		$query_count = JunctionTeachersDiscipline::where('discipline', '=', "$discipline_id")->count();
		$query = JunctionTeachersDiscipline::where('discipline', '=', "$discipline_id")->get();
		$l = 0;
		
		
		for ($j=0; $j <=$query_count-1; $j++)
		{
			$teacher_details[$j] = Teacher::where('teachers_id', '=', $query[$l]->teachers)->first();
			$l = $l+1;
		}

		
			
			if ($lesson_mode == 1)
			{
				return view('Accounts.change_parameters_graded', compact('stu_name', 'fee_parameters', 'dob', 'discipline_id', 'lesson_mode', 'father_name', 'father_designation', 'mother_name', 'mother_designation', 'address', 'pincode', 'phone_no', 'email_address1', 'chosen_discipline', 'teacher_details', 'query_count', 'stu_data_information'));
			}
			
			else 
			{
			
	return view('Accounts.change_parameters_group', compact('level', 'stu_name', 'fee_parameters', 'dob', 'discipline_id', 'lesson_mode', 'father_name', 'father_designation', 'mother_name', 'mother_designation', 'address', 'pincode', 'phone_no', 'email_address1', 'chosen_discipline', 'teacher_details', 'query_count', 'stu_data_information'));
			}
	
		}	


		public function change_parameters3(Request $request, $discipline, $teacher, $student)

		{
					
					$user = $request->user;
		



					if (empty($request->grades))
					{

					$fantom_level = $request->fantom_level;
	
					}
					else
					{
						$fantom_level = $request->grades;
					}

					
					$fantom_discipline = $request->fantom_discipline;

					$stu_information = StudentInformation::wherereg_no($student)->first();

					$stu_data_information = StudentTeacherMapping::whereregi_no($student)
																->whereteacher($teacher)
																->wherediscipline($discipline)
																->wherestatus(1)
																->first();	
				
				
					
					$date_change = date('Ymd');
						
					$update = StudentTeacherMapping::find($stu_data_information->sl_no);
					$update->date_change = $date_change;
					$update->status = 0;
					$update->save();

					
					$new_student = new StudentTeacherMapping;
					$new_student->regi_no = $stu_data_information->regi_no;
					$new_student->level = $fantom_level;
					$new_student->discipline = $fantom_discipline;
					$new_student->date_of_joining = $date_change;
					$new_student->date_change = '19870101';
					$new_student->teacher = $request->instructor;
					$new_student->special_fee = '0';
					$new_student->status = '1';
					$new_student->diff_amount = $stu_data_information->diff_amount;
					$new_student->enrolment = '1';
					$new_student->refundable_deposit = '1';
					$new_student->frequency = '1';
					$new_student->user = $user;

					$new_student->save();
	
					$paid_till_month = FeesTransaction::select('date1')
													->whereregist_no($student)
													->wheresection($discipline)
													->whereparticulars(1)
													->orderby('date1', 'DESC')
													->first();


		$billing_date = date('Ymd');

		$pay_monthly_fee = new FeesTransaction;
		$pay_monthly_fee->regist_no = $student;
		$pay_monthly_fee->date1 = $paid_till_month->date1;
		$pay_monthly_fee->billing_date = $billing_date;
		$pay_monthly_fee->money_collected = 0;
		$pay_monthly_fee->fee_by_month = 0;
		$pay_monthly_fee->section = $fantom_discipline;
		$pay_monthly_fee->particulars = 1;
		$pay_monthly_fee->teacher1 = $request->instructor;
		$pay_monthly_fee->receipt_no = 0;
		$pay_monthly_fee->user = $request->user;
		$pay_monthly_fee->save();			

		$fee_months_counts = FeesDue::whereregistration_no($student)
								->whereparticulars(1)
								->wherediscipline_no($discipline)
								->whereteacher_no($teacher)
								->wherestatus(0)
								->get();

						foreach ($fee_months_counts as $fee_months_count)

						{
									
									$update_fees_due_table = FeesDue::find($fee_months_count->sno);
											$update_fees_due_table->status = 1;
											$update_fees_due_table->save();	

									 $insert_to_due = new FeesDue;
									 
									  $insert_to_due->registration_no = $student;
									  $insert_to_due->fee_date = $fee_months_count->fee_date;
									  $insert_to_due->discipline_no = $fantom_discipline;
									  $insert_to_due->teacher_no = $request->instructor;
									  $insert_to_due->particulars = 1;
									  $insert_to_due->save();

						}

		$finding_teacher = StudentTeacherMapping::whereregi_no($student)
											->wherediscipline($fantom_discipline)
											->wherestatus(1)
											->first();
	
		$fresh_months_count = FeesTransaction::whereregist_no($student)
								->whereparticulars(1)
								->wheresection($fantom_discipline)
								->whereteacher1($request->instructor)
								->count();

		$fee_months_count = FeesDue::whereregistration_no($student)
								->whereparticulars(1)
								->wherediscipline_no($fantom_discipline)
								->whereteacher_no($request->instructor)
								->wherestatus(0)
								->count();
		$amf_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->get();
		$scm_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->get();
		$exam_fee_dues = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($request->instructor)		
								->wheree_s_d_discipline($fantom_discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->get();	

								
		$scm_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->count();
		$amf_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->count();
		$exam_fee_due_count = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($request->instructor)		
								->wheree_s_d_discipline($fantom_discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->count();
					
		$miscelleneous_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($request->instructor)
										->wheresub_cat(8)
										->wherestatus(0)
										->count();				

		$miscelleneous_dues = FeesDue::whereregistration_no($student)
										->whereteacher_no($request->instructor)
										->wheresub_cat(8)
										->wherestatus(0)
										->get();			

		$a_and_a_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($request->instructor)
										->wheresub_cat(10)
										->wherestatus(0)
										->count();				

		$a_and_a_dues = FeesDue::whereregistration_no($student)
										->whereteacher_no($request->instructor)
										->wheresub_cat(10)
										->wherestatus(0)
										->get();																						
		

		$late_fees_due_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($request->instructor)
										->whereparticulars(11)
										->wherestatus(0)
										->count();
		$late_fees_due = FeesDue::whereregistration_no($student)
									->whereteacher_no($request->instructor)
									->whereparticulars(11)
									->wherestatus(0)
									->get();	
																																						
		$amf_rate = GradesFee::wheregrades(9)->get();						
		$scm_rate = GradesFee::wheregrades(10)->get();													
		$enrolments = GradesFee::wheregrades(52)->get();
		$deposits = GradesFee::wheregrades(53)->get();
		$late_fee_rate = GradesFee::wheregrades(11)->get();	

		$theory_or_practicals = ExamStudentDatabase::wheree_s_d_roll_num($student)
											->wheree_s_d_teacher($request->instructor)		
											->wheree_s_d_discipline($fantom_discipline)
											->wheree_s_d_status(1)
											->count();

					if ($theory_or_practicals > 0)

					{						

		$theory_or_practicals = ExamStudentDatabase::wheree_s_d_roll_num($student)
											->wheree_s_d_teacher($request->instructor)		
											->wheree_s_d_discipline($fantom_discipline)
											->wheree_s_d_status(1)
											->first();

		$if_practical = ExamsTable::whereexam_no($theory_or_practicals->e_s_d_code)
										->first();

										if ($if_practical->category_code == 1)
										{
											$if_practical = 1;
										}
										else {
										$if_practical = 0;
										}
					}else{															
					
						$if_practical = 0;

					}

		$query = StudentTeacherMapping::wherediscipline($fantom_discipline)
										->whereteacher($request->instructor)
										->whereregi_no($student)
										->wherestatus(1)
										->get();
					
				
				return view('individual', compact('if_practical', 'a_and_a_count', 'a_and_a_dues', 'miscelleneous_count', 'miscelleneous_dues', 'query', 'enrolments', 'deposits', 'fresh_months_count', 'fee_months_count', 'amf_dues', 'scm_dues', 'amf_rate', 'scm_rate', 'scm_due_count', 'amf_due_count', 'exam_fee_due_count', 'exam_fee_dues', 'late_fees_due_count', 'late_fees_due', 'late_fee_rate'));
				
		}

		public function change_level($discipline, $teacher, $student)
		{
				


				$stu_information = StudentInformation::wherereg_no($student)->first();

				$stu_data_information = StudentTeacherMapping::whereregi_no($student)
																->whereteacher($teacher)
																->wherediscipline($discipline)
																->wherestatus(1)
																->first();
				$fee_parameters = GradesFee:: where('sub_category', '=', '1')
										->where('grades', '!=', '12')
										->get();

				$chosen_discipline = Discipline::where('discipline_id', '=', "$stu_data_information->discipline")->first();
				

			return view('Forms.edit_student', compact('stu_information', 'stu_data_information', 'fee_parameters', 'teacher_details'));
		}


		public function update_student(Request $request, $discipline, $teacher, $student)

				{

					$dob = date('Ymd', strtotime("$request->dob"));

					$update = StudentInformation::find($student);
					$update->stu_name = $request->stu_name;
					$update->dob = $dob;
					$update->father_name = $request->father_name;
					$update->father_designation = $request->father_designation;
					$update->mother_name = $request->mother_name;
					$update->mother_designation = $request->mother_designation;
					$update->address = $request->address;
					$update->pincode = $request->pincode;
					$update->phone_no = $request->phone_no;
					$update->email_address1 = $request->email_address1;
					$update->had_id = $request->has_id;

					$update->save();


		
		$finding_teacher = StudentTeacherMapping::whereregi_no($student)
											->wherediscipline($discipline)
											->wherestatus(1)
											->first();
	
		$fresh_months_count = FeesTransaction::whereregist_no($student)
								->whereparticulars(1)
								->wheresection($discipline)
								->whereteacher1($finding_teacher->teacher)
								->count();

		$fee_months_count = FeesDue::whereregistration_no($student)
								->whereparticulars(1)
								->wherediscipline_no($discipline)
								->whereteacher_no($finding_teacher->teacher)
								->wherestatus(0)
								->count();
		$amf_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->get();
		$scm_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->get();
		$exam_fee_dues = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($finding_teacher->teacher)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->get();	

								
		$scm_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->count();
		$amf_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->count();
		$exam_fee_due_count = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($finding_teacher->teacher)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->count();
					
		$miscelleneous_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(8)
										->wherestatus(0)
										->count();				

		$miscelleneous_dues = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(8)
										->wherestatus(0)
										->get();			

		$a_and_a_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(10)
										->wherestatus(0)
										->count();				

		$a_and_a_dues = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(10)
										->wherestatus(0)
										->get();																						
		

		$late_fees_due_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->whereparticulars(11)
										->wherestatus(0)
										->count();
		$late_fees_due = FeesDue::whereregistration_no($student)
									->whereteacher_no($finding_teacher->teacher)
									->whereparticulars(11)
									->wherestatus(0)
									->get();	
																																						
		$amf_rate = GradesFee::wheregrades(9)->get();						
		$scm_rate = GradesFee::wheregrades(10)->get();													
		$enrolments = GradesFee::wheregrades(52)->get();
		$deposits = GradesFee::wheregrades(53)->get();
		$late_fee_rate = GradesFee::wheregrades(11)->get();	

		$theory_or_practicals = ExamStudentDatabase::wheree_s_d_roll_num($student)
											->wheree_s_d_teacher($finding_teacher->teacher)		
											->wheree_s_d_discipline($discipline)
											->wheree_s_d_status(1)
											->count();

					if ($theory_or_practicals > 0)

					{						

		$theory_or_practicals = ExamStudentDatabase::wheree_s_d_roll_num($student)
											->wheree_s_d_teacher($finding_teacher->teacher)		
											->wheree_s_d_discipline($discipline)
											->wheree_s_d_status(1)
											->first();

		$if_practical = ExamsTable::whereexam_no($theory_or_practicals->e_s_d_code)
										->first();

										if ($if_practical->category_code == 1)
										{
											$if_practical = 1;
										}
										else {
										$if_practical = 0;
										}
					}else{															
					
						$if_practical = 0;

					}

		$query = StudentTeacherMapping::wherediscipline($discipline)
										->whereteacher($finding_teacher->teacher)
										->whereregi_no($student)
										->wherestatus(1)
										->get();
					
				
				return view('individual', compact('if_practical', 'a_and_a_count', 'a_and_a_dues', 'miscelleneous_count', 'miscelleneous_dues', 'query', 'enrolments', 'deposits', 'fresh_months_count', 'fee_months_count', 'amf_dues', 'scm_dues', 'amf_rate', 'scm_rate', 'scm_due_count', 'amf_due_count', 'exam_fee_due_count', 'exam_fee_dues', 'late_fees_due_count', 'late_fees_due', 'late_fee_rate'));
				

				}

		/*-----------CODE FOR THE DISPLAY BY TEACHER-----------------*/
	
	public function list_by_teacher($discipline, $teacher)
	{

		$find = StudentInformation::wherestatus(1)
									->orderby('stu_name', 'ASC')
									->get();

		$i = 0;

		foreach ($find as $iterate) 
		{
		
		$find_student_data = StudentTeacherMapping::whereregi_no($iterate->reg_no)
											->wherediscipline($discipline)
											->whereteacher($teacher)
											->wherestatus(1)
											->count();	

		if ($find_student_data > 0)
			{								

		$list_of_students[$i] = StudentTeacherMapping::whereregi_no($iterate->reg_no)
											->wherediscipline($discipline)
											->whereteacher($teacher)
											->wherestatus(1)
											->first();															
				
			$i = $i + 1;

			}

		}							
			
					
		return view('students_by_teacher', compact('list_of_students'));									
	}
	
		
	/*-----------END OF CODE FOR THE DISPLAY BY TEACHER-----------------*/		


public function tuition_fees_by_month(Request $request, $discipline, $teacher, $student)

{
		
		
		if (isset($_POST['pay_fees']))
	{
				
			/*-----------CODE FOR TAKING MONTHLY FEES-----------------*/
				
				$paid_till_month = FeesTransaction::select('date1')
													->whereregist_no($student)
													->wheresection($discipline)
													->whereparticulars(1)
													->orderby('date1', 'DESC')
													->count();
				
				$student_details = StudentTeacherMapping::whereregi_no($student)
																->wherediscipline($discipline)
																->wherestatus(1)
																->first();
																
											
																
						$student_level = $student_details->level;
						
						$student_monthly_fee = Gradesfee::wheregrades($student_level)
												->first();
						
						$billing_date = date('Ymd', strtotime("$request->billing_date"));
						
						
				
				if ($paid_till_month == 0)
				{
						$paid_till_month = date('Ym01');
						$months = $request->months_data;
						$for_months = array();
						for ($j=0; $j <=$months-1; $j++)
						{
							
							$for_months[$j] = date('Ymd', strtotime("$paid_till_month"));
							$paid_till_month = date('Ymd', strtotime("$paid_till_month + 1months"));
						
								foreach ($for_months as $for_month)
					{
						
						$pay_monthly_fee = new FeesTransaction;
						$pay_monthly_fee->regist_no = $student;
						$pay_monthly_fee->date1 = $for_month;
						$pay_monthly_fee->billing_date = $billing_date;
						$pay_monthly_fee->money_collected = $request->money_collected;
						$pay_monthly_fee->fee_by_month = $request->totaled_money;
						$pay_monthly_fee->section = $discipline;
						$pay_monthly_fee->particulars = 1;
						$pay_monthly_fee->teacher1 = $student_details->teacher;
						$pay_monthly_fee->receipt_no = $request->receipt_no;
						$pay_monthly_fee->user = $request->user;
						$pay_monthly_fee->save();
					}
						
						
						}
				
				} else {
						
				$paid_till_month = FeesTransaction::select('date1')
													->whereregist_no($student)
													->wheresection($discipline)
													->whereparticulars(1)
													->orderby('date1', 'DESC')
													->first();
						
				$paid_till_month = date('Ymd', strtotime("$paid_till_month[date1]"));
						
				$months = $request->months_data;
				$for_months = array();
				for ($j=0; $j <=$months-1; $j++)
				{
					
					$for_months[$j] = date('Ymd', strtotime("$paid_till_month + 1months"));
					$paid_till_month = date('Ymd', strtotime("$paid_till_month + 1months"));
					
						
				}
					
					
				foreach ($for_months as $for_month)
					{
						
						$pay_monthly_fee = new FeesTransaction;
						$pay_monthly_fee->regist_no = $student;
						$pay_monthly_fee->date1 = $for_month;
						$pay_monthly_fee->billing_date = $billing_date;
						$pay_monthly_fee->money_collected = $request->money_collected;
						$pay_monthly_fee->fee_by_month = $request->totaled_money;
						$pay_monthly_fee->section = $discipline;
						$pay_monthly_fee->particulars = 1;
						$pay_monthly_fee->teacher1 = $student_details->teacher;
						$pay_monthly_fee->receipt_no = $request->receipt_no;
						$pay_monthly_fee->user = $request->user;
						$pay_monthly_fee->save();
						
						$if_fee_pending = FeesDue::whereregistration_no($student)
											->whereparticulars(1)
											->wherediscipline_no($discipline)
											->wherefee_date($for_month)
											->wherestatus(0)
											->count();
						
								if ($if_fee_pending == 1)
								{
									$find_in_fees_due_table = FeesDue::whereregistration_no($student)
																->whereparticulars(1)
																->wherediscipline_no($discipline)
																->wherefee_date($for_month)
																->wherestatus(0)
																->first();
									
									$sno = $find_in_fees_due_table->sno;
									
									$update_fees_due_table = FeesDue::find($sno);
											$update_fees_due_table->status = 1;
											$update_fees_due_table->save();	
								}	
					
					
					}
								
					}
		/*-----------CODE FOR TAKING MONTHLY FEES ENDS-----------------*/
		
		
		


				$money_collected = $request->money_collected;

				$finding_teacher = StudentTeacherMapping::whereregi_no($student)
											->wherediscipline($discipline)
											->wherestatus(1)
											->first();
				
				$query = StudentTeacherMapping::wherediscipline($discipline)
										->whereteacher($finding_teacher->teacher)
										->whereregi_no($student)
										->wherestatus(1)
										->first();
				
				$totaled_money = $request->totaled_money;
				$money_collected = $request->money_collected;

				$money_in_account = $query->diff_amount;
				$calculation_diff_amount = $money_collected - $totaled_money;
								
				
					$updating_diff_amount = StudentTeacherMapping::find($query->sl_no);	
					$updating_diff_amount->diff_amount = $calculation_diff_amount;	
					$updating_diff_amount->save();
				
				
				


	}	
			
		$paid_till_month = FeesTransaction::select('date1')
													->whereregist_no($student)
													->wheresection($discipline)
													->whereparticulars(1)
													->orderby('date1', 'DESC')
													->first();
		if (empty($paid_till_month))
		{

			$next_month_to_pay = 0;

		}
		else 
			{

		$next_month_to_pay = date('Ymd', strtotime("$paid_till_month[date1]"));

		

		$next_month_to_pay = date('Ymd', strtotime("$next_month_to_pay + 1 month"));


			}

		$finding_teacher = StudentTeacherMapping::whereregi_no($student)
											->wherediscipline($discipline)
											->wherestatus(1)
											->first();
	

		$fresh_months_count = FeesTransaction::whereregist_no($student)
								->whereparticulars(1)
								->wheresection($discipline)
								->whereteacher1($finding_teacher->teacher)
								->count();

		$fee_months_count = FeesDue::whereregistration_no($student)
								->whereparticulars(1)
								->wherediscipline_no($discipline)
								->whereteacher_no($finding_teacher->teacher)
								->wherestatus(0)
								->count();
		$amf_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->get();
		$scm_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->get();
		$exam_fee_dues = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($finding_teacher->teacher)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->get();	

								
		$scm_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->count();
		$amf_due_count = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->count();
		$exam_fee_due_count = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_teacher($finding_teacher->teacher)		
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_status(1)
								->wheree_s_d_paid(0)
								->count();
					
		$miscelleneous_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(8)
										->wherestatus(0)
										->count();				

		$miscelleneous_dues = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->wheresub_cat(8)
										->wherestatus(0)
										->get();														
		

		$late_fees_due_count = FeesDue::whereregistration_no($student)
										->whereteacher_no($finding_teacher->teacher)
										->whereparticulars(11)
										->wherestatus(0)
										->count();
		$late_fees_due = FeesDue::whereregistration_no($student)
									->whereteacher_no($finding_teacher->teacher)
									->whereparticulars(11)
									->wherestatus(0)
									->get();	
																																						
		$amf_rate = GradesFee::wheregrades(9)->get();						
		$scm_rate = GradesFee::wheregrades(10)->get();													
		$enrolments = GradesFee::wheregrades(52)->get();
		$deposits = GradesFee::wheregrades(53)->get();
		$late_fee_rate = GradesFee::wheregrades(11)->get();	
		
				
		$query = StudentTeacherMapping::wherediscipline($discipline)
										->whereteacher($finding_teacher->teacher)
										->whereregi_no($student)
										->wherestatus(1)
										->get();
					
					$this_month_for_custom_fee = date('F Y');		
					
					$the_month = date('F Y', strtotime("$next_month_to_pay"));


				return view('fee_by_month', compact('query', 'the_month', 'next_month_to_pay', 'enrolments', 'deposits', 'fresh_months_count', 'fee_months_count', 'amf_dues', 'scm_dues', 'amf_rate', 'scm_rate', 'scm_due_count', 'amf_due_count', 'exam_fee_due_count', 'exam_fee_dues', 'late_fees_due_count', 'late_fees_due', 'late_fee_rate', 'this_month_for_custom_fee'));
				

}

public function history_report(Request $request, $discipline, $teacher, $student)

{

$TotalCollections = FeesTransaction::whereregist_no($student)
								->wheresection($discipline)
								->whereteacher1($teacher)
								->get();	

		return view('Reports.total_collections', compact('TotalCollections'));														
}

public function discontinue($discipline, $teacher, $student)
		{
				$if_fee_needs_paying = FeesDue::whereregistration_no($student)
												->whereteacher_no($teacher)
												->wherediscipline_no($discipline)
												->wherestatus(0)
												->count();

				if ($if_fee_needs_paying > 0)
				
				{

					$if_fee_needs_paying = FeesDue::whereregistration_no($student)
												->whereteacher_no($teacher)
												->wherediscipline_no($discipline)
												->wherestatus(0)
												->get();

					foreach ($if_fee_needs_paying as $unredeemable_fees)							
					{

						$update_fees_due_table = FeesDue::find($unredeemable_fees->sno);
						$update_fees_due_table->status = 2;
						$update_fees_due_table->save();	

					}


				$stu_information = StudentInformation::wherereg_no($student)->first();

				$stu_data_information = StudentTeacherMapping::whereregi_no($student)
																->whereteacher($teacher)
																->wherediscipline($discipline)
																->wherestatus(1)
																->first();

				$update_stu_data_information = StudentTeacherMapping::find($stu_data_information->sl_no);
				$update_stu_data_information->status = 0;
				$update_stu_data_information->save();		

					$stu_data_information = StudentTeacherMapping::whereregi_no($student)
																->whereteacher($teacher)
																->wherediscipline($discipline)
																->wherestatus(1)
																->count();

					if ($stu_data_information = 0)

					{
						$update_stu_information = StudentTeacherMapping::find($stu_information->reg_no);
						$update_stu_information->status = 0;
						$update_stu_information->save();	
					}
				} 

				else
				{

				$stu_information = StudentInformation::wherereg_no($student)->first();

				$stu_data_information = StudentTeacherMapping::whereregi_no($student)
																->whereteacher($teacher)
																->wherediscipline($discipline)
																->wherestatus(1)
																->first();

				$update_stu_data_information = StudentTeacherMapping::find($stu_data_information->sl_no);
				$update_stu_data_information->status = 0;
				$update_stu_data_information->save();		

					$stu_data_information = StudentTeacherMapping::whereregi_no($student)
																->whereteacher($teacher)
																->wherediscipline($discipline)
																->wherestatus(1)
																->count();

					if ($stu_data_information = 0)

					{
						$update_stu_information = StudentTeacherMapping::find($stu_information->reg_no);
						$update_stu_information->status = 0;
						$update_stu_information->save();	
					}
				}

							
			/*--------------HOME PAGE DISPLAY-----------------*/
		$late_fee_payment = 0;

				$this_date = date('Ymd');
				$tenth_day = date('d', strtotime("$this_date"));

				if ($tenth_day > 10)
			{
					$first_day = date('Ym01');
					$late_fees_due_check = LateFeeCounter::wheredate5($first_day)
															->wherelate_status(0)
															->count();
				
						if ($late_fees_due_check == 1)
						{
							$late_fee_payment = 1;
						}	

													
			}
		
			$all_disciplines = Discipline::all();

			foreach ($all_disciplines as $each_discipline)

			{

				$add_up_students = StudentTeacherMapping::wherediscipline($each_discipline->discipline_id)
															->wherestatus(1)
															->count();

				$update_student_strength = Discipline::find($each_discipline->discipline_id);
				$update_student_strength->strength = $add_up_students;
				$update_student_strength->save();
			}

		$total_no_of_students = StudentTeacherMapping::wherestatus(1)
													->count();	

		$query = Discipline::where('strength', '!=', '0')->get();
		return view('index', compact('query', 'late_fee_payment', 'total_no_of_students'));
		
			/*--------------HOME PAGE DISPLAY ENDS-----------------*/	
		}




}			




	