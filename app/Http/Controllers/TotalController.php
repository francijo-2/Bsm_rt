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
use App\ExamStudentDatabase;


class TotalController extends Controller
{
    
	public function total_tuition_fees_by_month(Request $request, $discipline, $teacher, $student)
	{
			$query = StudentTeacherMapping::wherediscipline($discipline)
										->whereteacher($teacher)
										->whereregi_no($student)
										->wherestatus(1)
										->first();

				if (isset($_POST['first_monthly_fees']))
			{
				$total = $request->monthly_fee_rate;
				$this_month = date('F Y');
				$first_fee = 1;
				
				$total_b = $total - $query->diff_amount;
				

				
					$this_date = date('d F Y');

				return view('Forms.custom_monthly_total', compact('query', 'this_date', 'first_fee', 'total', 'total_b', 'this_month_for_custom_fee', 'this_month'));
			}

		
		
			
		if (isset($_POST['tuition_fees']))
			{
				$paid_till_month = FeesTransaction::select('date1')
													->whereregist_no($student)
													->wheresection($discipline)
													->whereteacher1($teacher)
													->whereparticulars(1)
													->orderby('date1', 'DESC')
													->first();
													
				
				$paid_till_month = date('Ymd', strtotime("$paid_till_month[date1]"));
				$monthly_fee_rate = $request->monthly_fee_rate;
				$total = $monthly_fee_rate;
				$first_fee = 0;
				
				$total_b = $total - $query->diff_amount;
					
					$next_month_to_pay = date('Ymd', strtotime("$paid_till_month + 1months"));
				
			}

				$next_month_to_pay = date('F Y', strtotime("$next_month_to_pay"));	

				
				$this_date = date('d F Y');

			return view('Forms.custom_monthly_total', compact('query', 'this_date', 'sum_total', 'first_fee', 'total_b', 'total', 'monthly_fee_rate', 'next_month_to_pay'));
	}


    public function total(Request $request, $discipline, $teacher, $student)
	{
		$query = StudentTeacherMapping::wherediscipline($discipline)
										->whereteacher($teacher)
										->whereregi_no($student)
										->wherestatus(1)
										->first();
				
			
				
				$total = 0;
				/*MONTHLY FEES*/
		if (isset($_POST['first_monthly_fees']))
			{
				$first_month = date('Ymd');
				$first_month_again = date('Ymd');
				$monthly_fee_rate = $request->monthly_fee_rate;
				$months = $request->months;
				$no_of_months = $request->months;
				$total_monthly_fees = $monthly_fee_rate*$months;
				$total = $total + $total_monthly_fees;
				$for_months = array();
				for ($j=0; $j <=$months-1; $j++)
				{
					
					$for_months[$j] = date('F Y', strtotime("$first_month"));
					$first_month = date('Ymd', strtotime("$first_month + 1months"));
				}
				
			}
			
		if (isset($_POST['tuition_fees']))
			{
				$paid_till_month = FeesTransaction::select('date1')
													->whereregist_no($student)
													->wheresection($discipline)
													->whereteacher1($teacher)
													->whereparticulars(1)
													->orderby('date1', 'DESC')
													->first();
													
				
				$paid_till_month = date('Ymd', strtotime("$paid_till_month[date1]"));
				$monthly_fee_rate = $request->monthly_fee_rate;
				$months = $request->months;
				$no_of_months = $request->months;
				$total_monthly_fees = $monthly_fee_rate*$months;
				$total = $total + $total_monthly_fees;
				$for_months = array();
				for ($j=0; $j <=$months-1; $j++)
				{
					
					$for_months[$j] = date('F Y', strtotime("$paid_till_month + 1months"));
					$paid_till_month = date('Ymd', strtotime("$paid_till_month + 1months"));
				}
			}
				
				/*MONTHLY FEES ENDS HERE*/
				
				/*SCM FEES*/
		
		$scm_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(10)
								->wherestatus(0)
								->get();
		
		foreach ($scm_dues as $scm_due)
		{
		
			if (isset($_POST["$scm_due->sno"]))	
			{	
				
				$scm_fee_rate = $request->scm_fee_rate;
				$total = $total + $scm_fee_rate;
				
			}
		
		}
		
				
				/*SCM FEES ENDS HERE*/


		/*LATE FEES*/
		
		$late_dues = FeesDue::whereregistration_no($student)
								->wherediscipline_no($discipline)
								->whereparticulars(11)
								->wherestatus(0)
								->get();
		
		$late_fee_dues = array();
		$x = 0;

		foreach ($late_dues as $late_due)
		{
		

			if (isset($_POST["$late_due->sno"]))	
			{	
				
				$late_fee_rate = $request->late_fee_rate;
				$total = $total + $late_fee_rate;
				
				$late_fee_dues[$x] = FeesDue::wheresno($late_due->sno)
									->first();

								$x = $x + 1;	
			}
		
		}
		
				
				/*LATE FEES ENDS HERE*/




				/*AMF FEES*/
		
		
		$amf_dues = FeesDue::whereregistration_no($student)
								->whereparticulars(9)
								->wherestatus(0)
								->get();
		
		
		
		foreach ($amf_dues as $amf_due)
		{
		
			if (isset($_POST["$amf_due->sno"]))	
			{	
				
				$amf_fee_rate = $request->amf_fee_rate;
				$total = $total + $amf_fee_rate;
				

			}		
		}
				/*AMF FEES ENDS HERE*/	







/*MISCELLENEOUS FEES*/
		
		
		$miscelleneous_dues = FeesDue::whereregistration_no($student)
								->wheresub_cat(8)
								->wherestatus(0)
								->get();
		
		$a = 0;
		
		foreach ($miscelleneous_dues as $miscelleneous_due)
		{
			

			if (isset($_POST["$miscelleneous_due->sno"]))	
			{	
				
				$miscelleneous_fee_rate = FeesDue::wheresno($miscelleneous_due->sno)
								->wheresub_cat(8)
								->wherestatus(0)
								->first();

				$miscelleneous_fee_rate = GradesFee::wheregrades($miscelleneous_fee_rate->particulars)
									->first();				

				$miscelleneous_dues_array[$a] = FeesDue::wheresno($miscelleneous_due->sno)
								->wheresub_cat(8)
								->wherestatus(0)
								->first();	

					$a = $a + 1;							

				$miscelleneous_fee_rate = $miscelleneous_fee_rate->fees;
				$total = $total + $miscelleneous_fee_rate;
				
			}		
		}
				/*MISCELLENEOUS FEES ENDS HERE*/




				/*ENROLMENT FEES*/
			

			if (isset($_POST['enrolment']))	
			{	
				
				 

				$enrolment_fee_rate = GradesFee::wheregrades(52)
									->first();				


				$enrolment_fee_rate = $enrolment_fee_rate->fees;
				$total = $total + $enrolment_fee_rate;
				
			}		
		
				/*ENROLMENT FEES ENDS HERE*/	


/*REFUNDABLE DEPOSIT*/
		
		
		if (isset($_POST['deposit']))	
			{	
				
				$deposit_rate = $request->re_fund_deposit;
				$total = $total + $deposit_rate;
				
			}		
		
				/*REFUNDABLE DEPOSIT ENDS HERE*/


				/*EXAM FEES*/
		
		
		$exam_dues = ExamStudentDatabase::wheree_s_d_roll_num($student)
								->wheree_s_d_discipline($discipline)
								->wheree_s_d_teacher($teacher)
								->wheree_s_d_paid(0)
								->wheree_s_d_status(1)
								->get();
		
		
		
		foreach ($exam_dues as $exam_due)
		{
		
			if (isset($_POST[$exam_due->e_s_d_no]))	
			{	
				
				$exam_fee_rate = GradesFee::wheregrades($exam_due->e_s_d_grades)
								->first();
				$exam_fee_rate = $exam_fee_rate->fees;				

				$total = $total + $exam_fee_rate;
				
			}		
		}
				/*EXAM FEES ENDS HERE*/	



				/*AURAL AND ACCOMPANIMENT FEES*/


		
	$aural_and_accompaniment_dues = FeesDue::whereregistration_no($student)
									->wheresub_cat(10)
									->wherestatus(0)
									->get();
		
		$a = 0;
		
		foreach ($aural_and_accompaniment_dues as $aural_and_accompaniment_due)
		{
			

			if (isset($_POST["$aural_and_accompaniment_due->sno"]))	
			{	
				
				$aural_and_accompaniment_fees_rate = FeesDue::wheresno($aural_and_accompaniment_due->sno)
														->wheresub_cat(10)
														->wherestatus(0)
														->first();

				$aural_and_accompaniment_fees_rate = GradesFee::wheregrades($aural_and_accompaniment_fees_rate->particulars)
									->first();				

				$aural_and_accompaniment_dues_array[$a] = FeesDue::wheresno($aural_and_accompaniment_due->sno)
								->wheresub_cat(10)
								->wherestatus(0)
								->first();	

					$a = $a + 1;							

				$aural_and_accompaniment_fees_rate = $aural_and_accompaniment_fees_rate->fees;
				$total = $total + $aural_and_accompaniment_fees_rate;
				
			}		
		}			








				/*AURAL AND ACCOMPANIMENT FEES ENDS HERE*/







				$total = $total - $query->diff_amount;
				
				$date_for_display = date('d F Y');

	return view('Forms.total', compact('query', 'aural_and_accompaniment_dues_array', 'aural_and_accompaniment_fees_rate', 'date_for_display', 'enrolment_fee_rate', 'deposit_rate', 'miscelleneous_dues_array', 'miscelleneous_fee_rate', 'fantom_months', 'scm_dues', 'amf_dues', 'for_months', 'scm_fee_rate', 'amf_fee_rate', 'monthly_fee_rate', 'total', 'no_of_months', 'late_fee_rate', 'late_dues', 'exam_fee_rate', 'exam_dues', 'late_fee_dues'));
	
	}
}
