<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JunctionTeachersDiscipline;
use App\JunctionDisciplineGradeFee;
use App\FeesDue;
use App\Discipline;
use App\Teacher;
use App\GradesFee;
use App\RollNumber;
use App\VirtualRollNum;
use App\StudentInformation;
use App\StudentTeacherMapping;
use App\FeesTransaction;
use App\LateFeeCounter;

	
		
class AccountsController extends Controller
{

/*

   |------------------------------------------|
   |		VIEW RATE CHART 		 		  |
   |------------------------------------------|
	
*/
	

			/*--------------------------GRADED FEES------------------------------*/


	public function graded_fee(Request $request)

	{
		$rate_graded = $request->rate_graded;

		
		if (isset($_POST["rate_graded"]))
		{

				$switch = 1;
				$graded_rates = GradesFee::wheresub_category(1)->get();

				return view('Accounts.graded_rate_chart', compact('graded_rates', 'switch'));
		}
		
			$switch = 0;
			$graded_rates = GradesFee::wheresub_category(1)->get();

		return view('Accounts.graded_rate_chart', compact('graded_rates', 'switch'));

			/*----------------------------------END OF GRADED FEES-----------------------*/

	}		
			/*---------------------------------------SHORT TERM FEES---------------------*/

	public function short_fee(Request $request)

	{
		$rate_short_term = $request->rate_short_term;

		
		if (isset($_POST["rate_short_term"]))
		{

				$switch = 1;
				$short_term_rates = GradesFee::wheresub_category(2)->get();

				return view('Accounts.short_term_rate_chart', compact('short_term_rates', 'switch'));
		}
		
			$switch = 0;
			$short_term_rates = GradesFee::wheresub_category(2)->get();

		return view('Accounts.short_term_rate_chart', compact('short_term_rates', 'switch'));

	}	
		

		/*------------------------------------END OF SHORT TERM FEES--------------------------*/


	/*---------------------------------------SPECIAL PROGRAMS FEES---------------------*/

	public function special_fee(Request $request)

	{
		$rate_special_fee = $request->rate_special_fee;

		
		if (isset($_POST["rate_special_fee"]))
		{

				$switch = 1;
				$special_rates = GradesFee::wheresub_category(3)->get();

				return view('Accounts.special_rate_chart', compact('special_rates', 'switch'));
		}
		
			$switch = 0;
			$special_rates = GradesFee::wheresub_category(3)->get();

		return view('Accounts.special_rate_chart', compact('special_rates', 'switch'));

	}	
		

		/*------------------------------------END OF SPECIAL PROGRAMS FEES--------------------------*/	



	/*---------------------------------------ABRSM EXAM FEES---------------------*/

	public function abrsm_fee(Request $request)

	{
		$rate_abrsm_fee = $request->rate_abrsm_fee;

		
		if (isset($_POST["rate_abrsm_fee"]))
		{

				$switch = 1;
				$abrsm_rates_practicals = GradesFee::wheresub_category(4)
													->get();
				$abrsm_rates_theorys = GradesFee::wheresub_category(5)
												->get();							
							
							return view('Accounts.abrsm_rate_chart', compact('abrsm_rates_practicals', 'abrsm_rates_theorys', 'switch'));
		}
		
			$switch = 0;
			$abrsm_rates_practicals = GradesFee::wheresub_category(4)
													->get();
			$abrsm_rates_theorys = GradesFee::wheresub_category(5)
												->get();							
							
							return view('Accounts.abrsm_rate_chart', compact('abrsm_rates_practicals', 'abrsm_rates_theorys', 'switch'));

	}	
		

		/*------------------------------------END OF ABRSM EXAM FEES--------------------------*/	


		/*---------------------------------------Trinity EXAM FEES---------------------*/

	public function trinity_fee(Request $request)

	{
		$rate_trinity_fee = $request->rate_trinity_fee;

		
		if (isset($_POST["rate_trinity_fee"]))
		{

				$switch = 1;
				$trinity_rates_practicals = GradesFee::wheresub_category(6)
													->get();
				$trinity_rates_theorys = GradesFee::wheresub_category(7)
												->get();							
							
						return view('Accounts.trinity_rate_chart', compact('trinity_rates_practicals', 'trinity_rates_theorys', 'switch'));
		}
		
			$switch = 0;
			$trinity_rates_practicals = GradesFee::wheresub_category(6)
													->get();
				$trinity_rates_theorys = GradesFee::wheresub_category(7)
												->get();							
							
						return view('Accounts.trinity_rate_chart', compact('trinity_rates_practicals', 'trinity_rates_theorys', 'switch'));

	}	
		

		/*------------------------------------END OF Trinity EXAM FEES--------------------------*/	



		/*---------------------------------------ONE TIME PAYMENTS---------------------*/

	public function one_time_fee(Request $request)

	{
		$rate_one_time_fee = $request->rate_one_time_fee;

		
		if (isset($_POST["rate_one_time_fee"]))
		{

				$switch = 1;
				$one_time_rates = GradesFee::wheresub_category(8)->get();

				return view('Accounts.one_time_rate_chart', compact('one_time_rates', 'switch'));
		}
		
			$switch = 0;
			$one_time_rates = GradesFee::wheresub_category(8)->get();

		return view('Accounts.one_time_rate_chart', compact('one_time_rates', 'switch'));

	}	
	
	public function admin_fee(Request $request)

	{
		$rate_admin_fee = $request->rate_admin_fee;

		
		if (isset($_POST["rate_admin_fee"]))
		{

				$switch = 1;
				$admin_rates = GradesFee::wheresub_category(9)->get();

				return view('Accounts.admin_rate_chart', compact('admin_rates', 'switch'));
		}
		
			$switch = 0;
			$admin_rates = GradesFee::wheresub_category(9)->get();

		return view('Accounts.admin_rate_chart', compact('admin_rates', 'switch'));

	}		

		/*------------------------------------END OF ONE TIME PAYMENTS--------------------------*/	
	
	

/*END OF VIEW RATE CHART*/
	
/* 

   |------------------------------------------|
   |			UPDATE RATE CHART 		 	  |
   |------------------------------------------|
	
*/

  /*--------------------------GRADED FEES------------------------------*/

   public function update_graded_fee(Request $request)
	{

			$update_graded_fees = GradesFee::wheresub_category(1)->get();

			foreach ($update_graded_fees as $update_graded_fee)
			{	
					$grades = $update_graded_fee->grades;

					$update_graded_fees = GradesFee::wheresub_category($grades)->first();
					

					$fees = $_POST["$grades"];

					$update_graded_fee->fees = $fees;
					$update_graded_fee->save();

				
			}
			$switch = 0;
			$graded_rates = GradesFee::wheresub_category(1)->get();

		return view('Accounts.graded_rate_chart', compact('graded_rates', 'switch'));	
			
	}

/*--------------------------END OF GRADED FEES------------------------------*/


/*-------------------------SHORT TERM FEES------------------------------*/

   public function update_short_fee(Request $request)
	{

			$update_short_fees = GradesFee::wheresub_category(2)->get();

			foreach ($update_short_fees as $update_short_fee)
			{	
					$grades = $update_short_fee->grades;

					$update_short_fees = GradesFee::wheresub_category($grades)->first();
					

					$fees = $_POST["$grades"];

					$update_short_fee->fees = $fees;
					$update_short_fee->save();

				
			}
			$switch = 0;
			$short_term_rates = GradesFee::wheresub_category(2)->get();

		return view('Accounts.short_term_rate_chart', compact('short_term_rates', 'switch'));	
			
	}

/*--------------------------END OF SHORT TERM FEES------------------------------*/


	/*-------------------------SPECIAL PROGRAM FEES------------------------------*/

   public function update_special_fee(Request $request)
	{

			$update_special_fees = GradesFee::wheresub_category(3)->get();

			foreach ($update_special_fees as $update_special_fee)
			{	
					$grades = $update_special_fee->grades;

					$update_special_fees = GradesFee::wheresub_category($grades)->first();
					

					$fees = $_POST["$grades"];

					$update_special_fee->fees = $fees;
					$update_special_fee->save();

				
			}
			$switch = 0;
			$special_rates = GradesFee::wheresub_category(3)->get();

		return view('Accounts.special_rate_chart', compact('special_rates', 'switch'));	
			
	}

/*--------------------------END OF SPECIAL PROGRAM FEES------------------------------*/


/*-------------------------ABRSM EXAM FEES------------------------------*/

   public function update_abrsm_fee(Request $request)
	{

							/*----------------ABRSM PRACTICAL---------------*/


			$update_abrsm_fees = GradesFee::wheresub_category(4)->get();

			foreach ($update_abrsm_fees as $update_abrsm_fee)
			{	
					$grades = $update_abrsm_fee->grades;

					$update_abrsm_fees = GradesFee::wheresub_category($grades)->first();
					

					$fees = $_POST["$grades"];

					$update_abrsm_fee->fees = $fees;
					$update_abrsm_fee->save();
			}
			$switch = 0;
			$abrsm_rates_practicals = GradesFee::wheresub_category(4)->get();

							/*----------------END OF ABRSM PRACTICAL---------------*/
							


							/*----------------ABRSM THEORY---------------*/


			$update_abrsm_fees = GradesFee::wheresub_category(5)->get();

			foreach ($update_abrsm_fees as $update_abrsm_fee)
			{	
					$grades = $update_abrsm_fee->grades;

					$update_abrsm_fees = GradesFee::wheresub_category($grades)->first();
					

					$fees = $_POST["$grades"];

					$update_abrsm_fee->fees = $fees;
					$update_abrsm_fee->save();
			}
			$switch = 0;
			$abrsm_rates_theorys = GradesFee::wheresub_category(5)->get();

		return view('Accounts.abrsm_rate_chart', compact('abrsm_rates_theorys', 'abrsm_rates_practicals', 'switch'));	
			
	}


							/*----------------END OF ABRSM THEORY---------------*/


/*--------------------------END OF ABRSM EXAM FEES------------------------------*/


/*-------------------------TRINITY EXAM FEES------------------------------*/

   public function update_trinity_fee(Request $request)
	{

							/*----------------TRINITY PRACTICAL---------------*/


			$update_trinity_fees = GradesFee::wheresub_category(6)->get();

			foreach ($update_trinity_fees as $update_trinity_fee)
			{	
					$grades = $update_trinity_fee->grades;

					$update_trinity_fees = GradesFee::wheresub_category($grades)->first();
					

					$fees = $_POST["$grades"];

					$update_trinity_fee->fees = $fees;
					$update_trinity_fee->save();
			}
			$switch = 0;
			$trinity_rates_practicals = GradesFee::wheresub_category(6)->get();

							/*----------------END OF TRINITY PRACTICAL---------------*/
							


							/*----------------TRINITY THEORY---------------*/


			$update_trinity_fees = GradesFee::wheresub_category(7)->get();

			foreach ($update_trinity_fees as $update_trinity_fee)
			{	
					$grades = $update_trinity_fee->grades;

					$update_trinity_fees = GradesFee::wheresub_category($grades)->first();
					

					$fees = $_POST["$grades"];

					$update_trinity_fee->fees = $fees;
					$update_trinity_fee->save();
			}
			$switch = 0;
			$trinity_rates_theorys = GradesFee::wheresub_category(7)->get();

		return view('Accounts.trinity_rate_chart', compact('trinity_rates_theorys', 'trinity_rates_practicals', 'switch'));	
			
	}


							/*----------------END OF TRINITY THEORY---------------*/


/*--------------------------END OF TRINITY EXAM FEES------------------------------*/


 /*--------------------------ONE TIME PAYMENTS------------------------------*/

   public function update_one_time_fee(Request $request)
	{

			$update_one_time_fees = GradesFee::wheresub_category(8)->get();

			foreach ($update_one_time_fees as $update_one_time_fee)
			{	
					$grades = $update_one_time_fee->grades;

					$update_one_time_fees = GradesFee::wheresub_category($grades)->first();
					

					$fees = $_POST["$grades"];

					$update_one_time_fee->fees = $fees;
					$update_one_time_fee->save();

				
			}
			$switch = 0;
			$one_time_rates = GradesFee::wheresub_category(8)->get();

		return view('Accounts.one_time_rate_chart', compact('one_time_rates', 'switch'));	
			
	}

/*--------------------------ONE TIME PAYMENTS------------------------------*/

/*--------------------------ONE TIME PAYMENTS------------------------------*/

   public function update_admin_fee(Request $request)
	{

			$update_admin_fees = GradesFee::wheresub_category(9)->get();

			foreach ($update_admin_fees as $update_admin_fee)
			{	
					$grades = $update_admin_fee->grades;

					$update_admin_fees = GradesFee::wheresub_category($grades)->first();
					

					$fees = $_POST["$grades"];

					$update_admin_fee->fees = $fees;
					$update_admin_fee->save();

				
			}
			$switch = 0;
			$admin_rates = GradesFee::wheresub_category(9)->get();

		return view('Accounts.admin_rate_chart', compact('admin_rates', 'switch'));	
			
	}

/*--------------------------ONE TIME PAYMENTS------------------------------*/


   public function main(Request $request)
   	{
		if (isset($_POST["make_report"]))

			{
				$from_date = date('Ymd', strtotime("$request->from_date"));


				$till_date = date('Ymd', strtotime("$request->till_date"));

			$today = date('Ymd');
		
		/*--------------REPORTS-----------------*/

		$NumStu = StudentTeacherMapping::where('date_of_joining', '<=', "$till_date")
									->where('date_change', '<', "$from_date")
									->count();


		
		$TotalCollection = FeesTransaction::where('billing_date', '>=', "$from_date")
											->where('billing_date', '<=', "$till_date")
											->sum('fee_by_month');
		
		$TotalCollection_scm = FeesTransaction::whereparticulars(10)
											->where('billing_date', '>=', "$from_date")
											->where('billing_date', '<=', "$till_date")
											->sum('fee_by_month');		

		$TotalCollection_amf = FeesTransaction::whereparticulars(9)
											->where('billing_date', '>=', "$from_date")
											->where('billing_date', '<=', "$till_date")
											->sum('fee_by_month');	
											
		$TotalCollection_monthly = FeesTransaction::whereparticulars(1)
											->where('billing_date', '>=', "$from_date")
											->where('billing_date', '<=', "$till_date")
											->sum('fee_by_month');																											

		$NumFeeDefaulters = FeesDue::wherestatus(0)->count();
						

				/*--------------END OF REPORTS-----------------*/

			

				/*--------------SETTING STUDENT DATA WITHOUT ID CARDS-----------------*/

				$students_without_id = StudentInformation::wherehad_id(0)
														->wherestatus(1)
														->count();

				/*--------------END OF SETTING STUDENT DATA WITHOUT ID CARDS-----------------*/

				$today_date = date('d');
				$first_day = ('Ym01');
				
					$late_fee_payment = 0;

					
				if ($today_date > 10)
				{
					$late_fees_due_check = LateFeeCounter::wheredate5($first_day)
															->wherelate_status(0)
															->count();
						


						if ($late_fees_due_check == 1)
						{
							$late_fee_payment = 1;
						}	

						else 
						{

							$late_fee_payment = 0;

						}								
				}

		$sum_admin = 0;		
		$TotalCollection_other_fee_dues = FeesDue::where('particulars', '>', '1')
											->wherestatus(0)
											->get();

		foreach ($TotalCollection_other_fee_dues as $other_dues)	

		{
				
				$sum_step_1 = GradesFee::wheregrades($other_dues->particulars)->first();
				$sum_admin = $sum_admin + $sum_step_1->fees;


		}			
	
		$sum_late = 0;		
		$TotalCollection_monthly_late_dues = FeesDue::where('particulars', '=', '11')
											->wherestatus(0)
											->get();

		foreach ($TotalCollection_monthly_late_dues as $late_due)	

		{
				
				$sum_step_1 = GradesFee::wheregrades($late_due->particulars)->first();
				$sum_late = $sum_late + $sum_step_1->fees;


		}			

		$sum = 0;
		$TotalCollection_monthly_fee_dues = FeesDue::whereparticulars(1)
											->wherestatus(0)
											->get();

		foreach ($TotalCollection_monthly_fee_dues as $monthly_due)	

		{
				
				$sum_step_1 = GradesFee::wheregrades($monthly_due->getStuDetails()->level)->first();

				$sum = $sum + $sum_step_1->fees;

				
		}										
		
	return view('Accounts.accounts', compact('NumStu', 'TotalCollection_scm', 'TotalCollection_amf', 'TotalCollection_monthly', 'from_date', 'till_date', 'TotalCollection', 'NumFeeDefaulters', 'late_fee_payment', 'students_without_id', 'sum', 'sum_admin', 'sum_late'));





			}

				$from_date = date('Ymd');


				$till_date = date('Ymd');



			$today = date('Ymd');
		
		$NumStu = StudentTeacherMapping::wherestatus(1)->count();
		$TotalCollection = FeesTransaction::wherebilling_date($today)->sum('fee_by_month');
		$TotalCollection_scm = FeesTransaction::whereparticulars(10)
											->where('billing_date', '>=', "$from_date")
											->where('billing_date', '<=', "$till_date")
											->sum('fee_by_month');		

		$TotalCollection_amf = FeesTransaction::whereparticulars(9)
											->wherebilling_date($today)->sum('fee_by_month');	
											
		$TotalCollection_monthly = FeesTransaction::whereparticulars(1)
											->wherebilling_date($today)->sum('fee_by_month');	

		$NumFeeDefaulters = FeesDue::wherestatus(0)->count();
						

				/*--------------SETTING STUDENT DATA WITHOUT ID CARDS-----------------*/

				$students_without_id = StudentInformation::wherehad_id(0)
														->wherestatus(1)
														->count();

				/*--------------END OF SETTING STUDENT DATA WITHOUT ID CARDS-----------------*/

				$today_date = date('d');
				$first_day = date('Ym01');
				
					$late_fee_payment = 0;

					
				
				if ($today_date > 10)
				{
					$late_fees_due_check = LateFeeCounter::wheredate5($first_day)
															->wherelate_status(0)
															->count();
						

						if ($late_fees_due_check == 1)
						{
							$late_fee_payment = 1;

						}	

						else 
						{

							$late_fee_payment = 0;

						}								
				}


		$sum_admin = 0;		
		$TotalCollection_monthly_admin_dues = FeesDue::where('particulars', '>', '1')
											->where('particulars', '!=', '11')
											->wherestatus(0)
											->get();

		foreach ($TotalCollection_monthly_admin_dues as $monthly_due)	

		{
				
				$sum_step_1 = GradesFee::wheregrades($monthly_due->particulars)->first();
				$sum_admin = $sum_admin + $sum_step_1->fees;


		}			


		$sum_late = 0;		
		$TotalCollection_monthly_late_dues = FeesDue::where('particulars', '=', '11')
											->wherestatus(0)
											->get();

		foreach ($TotalCollection_monthly_late_dues as $late_due)	

		{
				
				$sum_step_1 = GradesFee::wheregrades($late_due->particulars)->first();
				$sum_late = $sum_late + $sum_step_1->fees;


		}			
	

		$sum = 0;
		$TotalCollection_monthly_fee_dues = FeesDue::whereparticulars(1)
											->wherestatus(0)
											->get();

		foreach ($TotalCollection_monthly_fee_dues as $monthly_due)	

		{
				
		$sum_step_1 = GradesFee::wheregrades($monthly_due->getStuDetails()->level)->first();
		$sum = $sum + $sum_step_1->fees;

				
		}								

		
	return view('Accounts.accounts', compact('NumStu', 'TotalCollection_scm', 'TotalCollection_amf', 'TotalCollection_monthly', 'from_date', 'till_date', 'TotalCollection', 'NumFeeDefaulters', 'late_fee_payment', 'students_without_id', 'sum', 'sum_admin', 'sum_late'));


	
	}

		/*--------------LISTING REPORTS-----------------*/

public function reports_total_collections(Request $request, $from_date, $till_date)

{

		$TotalCollection = FeesTransaction::where('billing_date', '>=', "$from_date")
											->where('billing_date', '<=', "$till_date")
											->sum('fee_by_month');


		$TotalCollections = FeesTransaction::where('billing_date', '>=', "$from_date")
											->where('billing_date', '<=', "$till_date")
											->get();									
		
		$TotalCollection_amf = FeesTransaction::whereparticulars(9)
											->where('billing_date', '>=', "$from_date")
											->where('billing_date', '<=', "$till_date")
											->sum('fee_by_month');	
											
		$TotalCollection_monthly = FeesTransaction::whereparticulars(1)
											->where('billing_date', '>=', "$from_date")
											->where('billing_date', '<=', "$till_date")
											->sum('fee_by_month');	

		

		return view('Reports.total_collections', compact('TotalCollections', 'TotalCollection_scm_list'));									

}

public function reports_scm_collections(Request $request, $from_date, $till_date)

{
		$TotalCollection_scm = FeesTransaction::whereparticulars(10)
											->where('billing_date', '>=', "$from_date")
											->where('billing_date', '<=', "$till_date")
											->sum('fee_by_month');		

		$TotalCollection_scm_list = FeesTransaction::whereparticulars(10)
											->where('billing_date', '>=', "$from_date")
											->where('billing_date', '<=', "$till_date")
											->get();					

		return view('Reports.scm_report', compact('TotalCollection_scm', 'TotalCollection_scm_list'));									
									
}

public function reports_amf_collections(Request $request, $from_date, $till_date)

{
		$TotalCollection_amf = FeesTransaction::whereparticulars(9)
											->where('billing_date', '>=', "$from_date")
											->where('billing_date', '<=', "$till_date")
											->sum('fee_by_month');	

		$TotalCollection_amf_list = FeesTransaction::whereparticulars(9)
											->where('billing_date', '>=', "$from_date")
											->where('billing_date', '<=', "$till_date")
											->get();										

		return view('Reports.amf_report', compact('TotalCollection_amf', 'TotalCollection_amf_list'));									
									
}

public function reports_monthly_fee_due()

{
		
		$TotalCollection_monthly_fee_dues_list = FeesDue::whereparticulars(1)
											->wherestatus(0)
											->get();
		$sum = 0;									
		foreach ($TotalCollection_monthly_fee_dues_list as $monthly_due)	

		{
				
				$sum_step_1 = GradesFee::wheregrades($monthly_due->particulars)->first();
				$sum = $sum + $sum_step_1->fees;


		}								

		return view('Reports.monthly_fee_due', compact('TotalCollection_monthly_fee_dues_list'));									
									
}

public function reports_admin_fee_due()

{
		$TotalCollection_admin_fee_dues_list = FeesDue::where('particulars', '>', '1')
											->where('particulars', '!=', '11')
											->wherestatus(0)
											->get();
		$sum = 0;									
		foreach ($TotalCollection_admin_fee_dues_list as $due)	

		{
				
				$sum_step_1 = GradesFee::wheregrades($due->particulars)->first();
				$sum = $sum + $sum_step_1->fees;


		}								

		return view('Reports.admin_fee_due', compact('TotalCollection_admin_fee_dues_list'));									
									
}





public function reports_late_fee_due()

{
		$TotalCollection_late_fee_dues_list = FeesDue::where('particulars', '=', '11')
											->wherestatus(0)
											->get();
		$sum_late = 0;									
		foreach ($TotalCollection_late_fee_dues_list as $due)	

		{
				
				$sum_step_1 = GradesFee::wheregrades($due->particulars)->first();
				$sum_late = $sum_late + $sum_step_1->fees;


		}								

		return view('Reports.late_fee_due', compact('TotalCollection_late_fee_dues_list', 'sum_late'));									
									
}


				/*--------------END OF LISTING REPORTS-----------------*/
	
	public function lateupdate()
	{

				$from_date = date('Ymd');


				$till_date = date('Ymd');



		$today = date('Ymd');
		
		
		
		$TotalCollection_scm = FeesTransaction::whereparticulars(10)
											->where('billing_date', '>=', "$from_date")
											->where('billing_date', '<=', "$till_date")
											->sum('fee_by_month');		

		$TotalCollection_amf = FeesTransaction::whereparticulars(9)
											->wherebilling_date($today)->sum('fee_by_month');	
											
		$TotalCollection_monthly = FeesTransaction::whereparticulars(1)
											->wherebilling_date($today)->sum('fee_by_month');	




		$today = date('Ymd');
		
		$NumStu = StudentTeacherMapping::wherestatus(1)->count();
		$TotalCollection = FeesTransaction::wherebilling_date($today)->sum('fee_by_month');
		$NumFeeDefaulters = FeesDue::wherestatus(0)->count();


				$first_day = date('Ym01');

				
								
						$if_in_fee_due_list = FeesDue::wherefee_date($first_day)
														->whereparticulars(1)
														->wherestatus(0)
														->get();

						foreach ($if_in_fee_due_list as $late_list) 
						{
																
																						
							
									
									  $insert_to_due = new FeesDue;
									 
									  $insert_to_due->registration_no = $late_list->registration_no;
									  $insert_to_due->fee_date = $first_day;
									  $insert_to_due->discipline_no = $late_list->discipline_no;
									  $insert_to_due->teacher_no = $late_list->teacher_no;
									  $insert_to_due->particulars = 11;
									  $insert_to_due->save();


						}
						 	
						
						

						
								
						$update_late_counter = LateFeeCounter::wheredate5($first_day)->first();

						$update_late_counter = LateFeeCounter::find($update_late_counter->late_no);
										$update_late_counter->late_status = 1;
										$update_late_counter->save();	
			

			/*--------------SETTING STUDENT DATA WITHOUT ID CARDS-----------------*/

				$students_without_id = StudentInformation::wherehad_id(0)
														->wherestatus(1)
														->count();




				/*--------------END OF SETTING STUDENT DATA WITHOUT ID CARDS-----------------*/
					
					$late_fee_payment = 0;

					return view('Accounts.accounts', compact('TotalCollection_monthly', 'TotalCollection_scm', 'TotalCollection_amf', 'till_date', 'from_date', 'NumStu', 'TotalCollection', 'NumFeeDefaulters', 'late_fee_payment', 'students_without_id'));
			}								



	public function new_admission()
   	{
		$query = Discipline::whereSubCategory(1)->get();
		
	return view('Accounts.new_admission', compact('query'));
	}
	
	
	public function new_admission2(Request $request)
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

					
										
		$chosen_discipline = Discipline::where('discipline_id', '=', "$discipline_id")->first();
		$query_count = JunctionTeachersDiscipline::where('discipline', '=', "$discipline_id")->count();
		$query = JunctionTeachersDiscipline::where('discipline', '=', "$discipline_id")->get();
		$l = 0;
		

		
		for ($j=0; $j <= $query_count-1; $j++)
		{
			$teacher_details[$j] = Teacher::where('teachers_id', '=', $query[$l]->teachers)->first();
			$l = $l+1;
		}
			if ($lesson_mode == 1)
			{
				return view('Accounts.individual_admission', compact('stu_name', 'fee_parameters', 'dob', 'discipline_id', 'lesson_mode', 'father_name', 'father_designation', 'mother_name', 'mother_designation', 'address', 'pincode', 'phone_no', 'email_address1', 'chosen_discipline', 'teacher_details', 'query_count'));
			}
			
			else
			{
			
	return view('Accounts.group_admission', compact('stu_name', 'fee_parameters', 'dob', 'discipline_id', 'lesson_mode', 'father_name', 'father_designation', 'mother_name', 'mother_designation', 'address', 'pincode', 'phone_no', 'email_address1', 'chosen_discipline', 'teacher_details', 'query_count'));
			}
	
	}
	
	public function enter_new_graded_student(Request $request)
	{
				
		$dob = $request->dob;
		$dob = date('Ymd', strtotime("$dob"));
		

	
				
		$roll_count = RollNumber::count();
		$roll_number = RollNumber::where('Serial', '=', "$roll_count")->first();
		$next_roll_no = $roll_number['Final'] + 1;
		
	
		
		$virtual_roll_count = VirtualRollNum::count();
		$virtual_roll_number = VirtualRollNum::where('VirtualNo', '=', "$virtual_roll_count")->first();
		$next_no = $virtual_roll_number['VirtualRoll'] + 1;
		
				
		$date = date('Ym01');
		
		/*--------------INSERTING NEW STUDENT DETAILS-----------------*/		
		
		
		$new_student = new StudentInformation;
		
		$new_student->reg_no = $roll_number['Final'];
		$new_student->serial_annualised = $virtual_roll_number['VirtualRoll'];
		$new_student->pre_no = $virtual_roll_number['VirtualPre'];
		$new_student->post_no = $virtual_roll_number['VirtualPost'];
		$new_student->stu_name = $request->stu_name;
		$new_student->dob = $dob;
		$new_student->joining_date = $date;
		$new_student->scm = $date;
		$new_student->exemption = 0;
		$new_student->admin_fee_exemption = 0;
		$new_student->landline = $request->phone_no;
		$new_student->phone_no = $request->phone_no;
		$new_student->pincode = $request->pincode;
		$new_student->address = $request->address;
		$new_student->father_name = $request->father_name;
		$new_student->father_designation = $request->father_designation;
		$new_student->mother_name = $request->mother_name;
		$new_student->mother_designation = $request->mother_designation;
		$new_student->email_address1 = $request->email_address1;
		$new_student->email_address2 = 'FFF';
		$new_student->email_address3 = 'FFF';
		$new_student->status = 1;
		$new_student->user = $request->user;
		$new_student->had_id = 0;
		$new_student->save();
		
		$fantom_discipline = $request->fantom_discipline;
		
		$new_student = new StudentTeacherMapping;
		$new_student->regi_no = $roll_number['Final'];
		$new_student->level = $request->grades;
		$new_student->discipline = $fantom_discipline;
		$new_student->date_of_joining = $date;
		$new_student->date_change = '19870101';
		$new_student->teacher = $request->instructor;
		$new_student->special_fee = '0';
		$new_student->status = '1';
		$new_student->diff_amount = '0';
		$new_student->enrolment = '0';
		$new_student->enrolment = '0';
		$new_student->refundable_deposit = '0';
		$new_student->frequency = '1';
		$new_student->user = $request->user;
		$new_student->save();
		
		
	$update = VirtualRollNum::find($virtual_roll_count);
			$update->VirtualRoll = $next_no;
			$update->save();
			
	$update = RollNumber::find($roll_count);
			$update->Final = $next_roll_no;
			$update->save();
				
				
		$amf_rate = GradesFee::wheregrades(9)->get();						
		$scm_rate = GradesFee::wheregrades(10)->get();
		$enrolments = GradesFee::wheregrades(52)->get();
		$deposits = GradesFee::wheregrades(53)->get();
		
		/*--------------INSERTING SCM -----------------*/
		
		$insert_to_due = new FeesDue;
		$insert_to_due->registration_no = $roll_number['Final'];
		$insert_to_due->fee_date = $date;
		$insert_to_due->particulars = 10;
		$insert_to_due->save();	
		
		/*--------------END OF INSERTING SCM -----------------*/
		
		/*--------------INSERTING AMF-----------------*/
		
		$insert_to_due = new FeesDue;
		$insert_to_due->registration_no = $roll_number['Final'];
		$insert_to_due->fee_date = $date;
		$insert_to_due->particulars = 9;
		$insert_to_due->save();	
		
		/*--------------END OF INSERTING AMF -----------------*/
		
	$amf_dues = FeesDue::whereregistration_no($roll_number['Final'])
								->whereparticulars(9)
								->wherestatus(0)
								->get();
	
	$scm_dues = FeesDue::whereregistration_no($roll_number['Final'])
								->whereparticulars(10)
								->wherestatus(0)
								->get();
		
		$query = StudentTeacherMapping::wherediscipline($fantom_discipline)
										->whereregi_no($roll_number['Final'])
										->get();
					
				
				return view('new_admission', compact('query', 'amf_rate', 'scm_rate', 'enrolments', 'deposits', 'amf_dues', 'scm_dues'));
		}
		
		
		
		
		
		
		
		public function enter_new_group_student(Request $request)
	{
				
		$dob = $request->dob;
		$dob = date('Ymd', strtotime("$dob"));
		
	
				
		$roll_count = RollNumber::count();
		$roll_number = RollNumber::where('Serial', '=', "$roll_count")->first();
		$next_roll_no = $roll_number['Final'] + 1;
		
	
		
		$virtual_roll_count = VirtualRollNum::count();
		$virtual_roll_number = VirtualRollNum::where('VirtualNo', '=', "$virtual_roll_count")->first();
		$next_no = $virtual_roll_number['VirtualRoll'] + 1;
		
				
		$date = date('Ym01');
		
		

		/*--------------INSERTING NEW STUDENT DETAILS-----------------*/		
		
		
		$new_student = new StudentInformation;
		
		$new_student->reg_no = $roll_number['Final'];
		$new_student->serial_annualised = $virtual_roll_number['VirtualRoll'];
		$new_student->pre_no = $virtual_roll_number['VirtualPre'];
		$new_student->post_no = $virtual_roll_number['VirtualPost'];
		$new_student->stu_name = $request->stu_name;
		$new_student->dob = $dob;
		$new_student->joining_date = $date;
		$new_student->scm = $date;
		$new_student->exemption = 0;
		$new_student->admin_fee_exemption = 0;
		$new_student->landline = $request->phone_no;
		$new_student->phone_no = $request->phone_no;
		$new_student->pincode = $request->pincode;
		$new_student->address = $request->address;
		$new_student->father_name = $request->father_name;
		$new_student->father_designation = $request->father_designation;
		$new_student->mother_name = $request->mother_name;
		$new_student->mother_designation = $request->mother_designation;
		$new_student->email_address1 = $request->email_address1;
		$new_student->email_address2 = 'FFF';
		$new_student->email_address3 = 'FFF';
		$new_student->status = 1;
		$new_student->user = $request->user;
		$new_student->had_id = 0;
		$new_student->save();
		
		$fantom_discipline = $request->fantom_discipline;
		
		$new_student = new StudentTeacherMapping;
		$new_student->regi_no = $roll_number['Final'];
		
		if ($request->lesson_mode == 3)

			{
				$new_student->level = 73;
			}
			else {
		$new_student->level = 12;
				 }	
		$new_student->discipline = $fantom_discipline;
		$new_student->date_of_joining = $date;
		$new_student->date_change = '19870101';
		$new_student->teacher = $request->instructor;
		$new_student->special_fee = '0';
		$new_student->status = '1';
		$new_student->diff_amount = '0';
		$new_student->enrolment = '0';
		$new_student->enrolment = '0';
		$new_student->refundable_deposit = '0';
		$new_student->frequency = '1';
		$new_student->user = $request->user;
		$new_student->save();
		
		
	$update = VirtualRollNum::find($virtual_roll_count);
			$update->VirtualRoll = $next_no;
			$update->save();
			
	$update = RollNumber::find($roll_count);
			$update->Final = $next_roll_no;
			$update->save();
				
	
			
			
		$amf_rate = GradesFee::wheregrades(9)->get();						
		$scm_rate = GradesFee::wheregrades(10)->get();
		$enrolments = GradesFee::wheregrades(52)->get();
		$deposits = GradesFee::wheregrades(53)->get();
		
		/*--------------INSERTING SCM -----------------*/
		
		$insert_to_due = new FeesDue;
		$insert_to_due->registration_no = $roll_number['Final'];
		$insert_to_due->fee_date = $date;
		$insert_to_due->particulars = 10;
		$insert_to_due->save();	
		
		/*--------------END OF INSERTING SCM -----------------*/
		
		/*--------------INSERTING AMF-----------------*/
		
		$insert_to_due = new FeesDue;
		$insert_to_due->registration_no = $roll_number['Final'];
		$insert_to_due->fee_date = $date;
		$insert_to_due->particulars = 9;
		$insert_to_due->save();	
		
		/*--------------END OF INSERTING AMF -----------------*/
		
	$amf_dues = FeesDue::whereregistration_no($roll_number['Final'])
								->whereparticulars(9)
								->wherestatus(0)
								->get();
	
	$scm_dues = FeesDue::whereregistration_no($roll_number['Final'])
								->whereparticulars(10)
								->wherestatus(0)
								->get();
		
	$query = StudentTeacherMapping::wherediscipline($fantom_discipline)
										->whereregi_no($roll_number['Final'])
										->get();
					
			
				return view('new_admission', compact('query', 'amf_rate', 'scm_rate', 'enrolments', 'deposits', 'amf_dues', 'scm_dues'));
		
		
		}
	
	/*----------APPLICATION FOR SPECIAL PROGRAM----------*/
	
		public function special_program()
   	{
	
	$query = Discipline::whereSubCategory(3)->get();
		
	return view('Accounts.special_programs',compact('query'));
	

	}


	public function special_programs2(Request $request)
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
		
		$fees = JunctionDisciplineGradeFee::wherediscipline($discipline_id)->first();

		$fee_parameters = GradesFee::wheregrades($fees->fees)->get();

														
		$chosen_discipline = Discipline::where('discipline_id', '=', "$discipline_id")->first();
		$query_count = JunctionTeachersDiscipline::where('discipline', '=', "$discipline_id")->count();
		$query = JunctionTeachersDiscipline::where('discipline', '=', "$discipline_id")->get();
		$l = 0;
		
		
		for ($j=0; $j <=$query_count-1; $j++)
		{
			$teacher_details[$j] = Teacher::where('teachers_id', '=', $query[$l]->teachers)->first();
			$l = $l+1;
		}
			
			
				return view('Accounts.special_programs', compact('stu_name', 'fee_parameters', 'dob', 'discipline_id', 'lesson_mode', 'father_name', 'father_designation', 'mother_name', 'mother_designation', 'address', 'pincode', 'phone_no', 'email_address1', 'chosen_discipline', 'teacher_details', 'query_count'));
			
	
	}

	public function special_program3(Request $request)

	{

		$dob = $request->dob;
		$dob = date('Ymd', strtotime("$dob"));
		
	
				
		$roll_count = RollNumber::count();
		$roll_number = RollNumber::where('Serial', '=', "$roll_count")->first();
		$next_roll_no = $roll_number['Final'] + 1;
		
	
		
		$virtual_roll_count = VirtualRollNum::count();
		$virtual_roll_number = VirtualRollNum::where('VirtualNo', '=', "$virtual_roll_count")->first();
		$next_no = $virtual_roll_number['VirtualRoll'] + 1;
		
				
		$date = date('Ym01');
		
		

			/*--------------INSERTING NEW STUDENT DETAILS-----------------*/		
		
		
		$fantom_discipline = $request->fantom_discipline;


		$new_student = new StudentInformation;
		
		$new_student->reg_no = $roll_number['Final'];
		$new_student->serial_annualised = $virtual_roll_number['VirtualRoll'];
		$new_student->pre_no = $virtual_roll_number['VirtualPre'];
		$new_student->post_no = $virtual_roll_number['VirtualPost'];
		$new_student->stu_name = $request->stu_name;
		$new_student->dob = $dob;
		$new_student->joining_date = $date;
		$new_student->scm = $date;
		$new_student->exemption = 0;
		$new_student->admin_fee_exemption = 0;
		$new_student->landline = $request->phone_no;
		$new_student->phone_no = $request->phone_no;
		$new_student->pincode = $request->pincode;
		$new_student->address = $request->address;
		$new_student->father_name = $request->father_name;
		$new_student->father_designation = $request->father_designation;
		$new_student->mother_name = $request->mother_name;
		$new_student->mother_designation = $request->mother_designation;
		$new_student->email_address1 = $request->email_address1;
		$new_student->email_address2 = 'FFF';
		$new_student->email_address3 = 'FFF';
		$new_student->status = 1;
		$new_student->user = $request->user;
		$new_student->had_id = 0;
		$new_student->save();
		
		
		
		$new_student = new StudentTeacherMapping;
		$new_student->regi_no = $roll_number['Final'];
		$new_student->level = $request->grades;
		$new_student->discipline = $fantom_discipline;
		$new_student->date_of_joining = $date;
		$new_student->date_change = '19870101';
		$new_student->teacher = $request->instructor;
		$new_student->special_fee = '0';
		$new_student->status = '1';
		$new_student->diff_amount = '0';
		$new_student->enrolment = '0';
		$new_student->refundable_deposit = '0';
		$new_student->frequency = '1';
		$new_student->user = $request->user;
		$new_student->save();
		
		
	$update = VirtualRollNum::find($virtual_roll_count);
			$update->VirtualRoll = $next_no;
			$update->save();
			
	$update = RollNumber::find($roll_count);
			$update->Final = $next_roll_no;
			$update->save();
				
	
			
			
		$amf_rate = GradesFee::wheregrades(9)->get();						
		$scm_rate = GradesFee::wheregrades(10)->get();
		$enrolments = GradesFee::wheregrades(52)->get();
		$deposits = GradesFee::wheregrades(53)->get();
		
		/*--------------INSERTING SCM -----------------*/
		

		$insert_to_due = new FeesDue;
		$insert_to_due->registration_no = $roll_number['Final'];
		$insert_to_due->fee_date = $date;
		$insert_to_due->particulars = 10;
		$insert_to_due->save();	

		
		
		/*--------------END OF INSERTING SCM -----------------*/
		
		/*--------------INSERTING AMF-----------------*/
		
		$insert_to_due = new FeesDue;
		$insert_to_due->registration_no = $roll_number['Final'];
		$insert_to_due->fee_date = $date;
		$insert_to_due->particulars = 9;
		$insert_to_due->save();	
		
		
		/*--------------END OF INSERTING AMF -----------------*/
		
	$amf_dues = FeesDue::whereregistration_no($roll_number['Final'])
								->whereparticulars(9)
								->wherestatus(0)
								->get();
	
	$scm_dues = FeesDue::whereregistration_no($roll_number['Final'])
								->whereparticulars(10)
								->wherestatus(0)
								->get();
		
	$query = StudentTeacherMapping::wherediscipline($fantom_discipline)
										->whereregi_no($roll_number['Final'])
										->get();
					
				
				return view('new_admission', compact('query', 'amf_rate', 'scm_rate', 'enrolments', 'deposits', 'amf_dues', 'scm_dues'));

	}

	/*----------END OF APPLICATION FOR SPECIAL PROGRAM----------*/


	/*----------APPLICATION FOR SHORT TERM PROGRAM----------*/

	public function short_term_program()
   	{
	
	$query = Discipline::whereSubCategory(2)->get();
		
	return view('Accounts.short_term_program',compact('query'));
	
	}

	public function short_term_program2(Request $request)
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
		
		$fees = JunctionDisciplineGradeFee::wherediscipline($discipline_id)->first();

		$fee_parameters = GradesFee::wheregrades($fees->fees)->get();

														
		$chosen_discipline = Discipline::where('discipline_id', '=', "$discipline_id")->first();
		$query_count = JunctionTeachersDiscipline::where('discipline', '=', "$discipline_id")->count();
		$query = JunctionTeachersDiscipline::where('discipline', '=', "$discipline_id")->get();
		$l = 0;
		
		
		for ($j=0; $j <=$query_count-1; $j++)
		{
			$teacher_details[$j] = Teacher::where('teachers_id', '=', $query[$l]->teachers)->first();
			$l = $l+1;
		}
			
			
				return view('Accounts.short_term_admission', compact('stu_name', 'fee_parameters', 'dob', 'discipline_id', 'lesson_mode', 'father_name', 'father_designation', 'mother_name', 'mother_designation', 'address', 'pincode', 'phone_no', 'email_address1', 'chosen_discipline', 'teacher_details', 'query_count'));
			
	
	}


	public function short_term_program3(Request $request)

	{

		$dob = $request->dob;
		$dob = date('Ymd', strtotime("$dob"));
		
	
				
		$roll_count = RollNumber::count();
		$roll_number = RollNumber::where('Serial', '=', "$roll_count")->first();
		$next_roll_no = $roll_number['Final'] + 1;
		
	
		
		$virtual_roll_count = VirtualRollNum::count();
		$virtual_roll_number = VirtualRollNum::where('VirtualNo', '=', "$virtual_roll_count")->first();
		$next_no = $virtual_roll_number['VirtualRoll'] + 1;
		
				
		$date = date('Ym01');
		
		

			/*--------------INSERTING NEW STUDENT DETAILS-----------------*/		
		
		
		$fantom_discipline = $request->fantom_discipline;

		if ($fantom_discipline == 15)

		{

			$new_student = new StudentInformation;
		
		$new_student->reg_no = $roll_number['Final'];
		$new_student->serial_annualised = $virtual_roll_number['VirtualRoll'];
		$new_student->pre_no = $virtual_roll_number['VirtualPre'];
		$new_student->post_no = $virtual_roll_number['VirtualPost'];
		$new_student->stu_name = $request->stu_name;
		$new_student->dob = $dob;
		$new_student->joining_date = $date;
		$new_student->scm = $date;
		$new_student->exemption = 0;
		$new_student->admin_fee_exemption = 0;
		$new_student->landline = $request->phone_no;
		$new_student->phone_no = $request->phone_no;
		$new_student->pincode = $request->pincode;
		$new_student->address = $request->address;
		$new_student->father_name = $request->father_name;
		$new_student->father_designation = $request->father_designation;
		$new_student->mother_name = $request->mother_name;
		$new_student->mother_designation = $request->mother_designation;
		$new_student->email_address1 = $request->email_address1;
		$new_student->email_address2 = 'FFF';
		$new_student->email_address3 = 'FFF';
		$new_student->status = 1;
		$new_student->user = $request->user;
		$new_student->had_id = 0;
		$new_student->save();
		
		
		
		$new_student = new StudentTeacherMapping;
		$new_student->regi_no = $roll_number['Final'];
		$new_student->level = $request->grades;
		$new_student->discipline = $fantom_discipline;
		$new_student->date_of_joining = $date;
		$new_student->date_change = '19870101';
		$new_student->teacher = $request->instructor;
		$new_student->special_fee = '0';
		$new_student->status = '1';
		$new_student->diff_amount = '0';
		$new_student->enrolment = '1';
		$new_student->refundable_deposit = '0';
		$new_student->frequency = '1';
		$new_student->user = $request->user;
		$new_student->save();

		$update = VirtualRollNum::find($virtual_roll_count);
			$update->VirtualRoll = $next_no;
			$update->save();
			
		$update = RollNumber::find($roll_count);
			$update->Final = $next_roll_no;
			$update->save();


			$amf_rate = GradesFee::wheregrades(9)->get();						
			$scm_rate = GradesFee::wheregrades(10)->get();
			$enrolments = GradesFee::wheregrades(52)->get();
			$deposits = GradesFee::wheregrades(53)->get();

		}
			else 

			{


		$new_student = new StudentInformation;
		
		$new_student->reg_no = $roll_number['Final'];
		$new_student->serial_annualised = $virtual_roll_number['VirtualRoll'];
		$new_student->pre_no = $virtual_roll_number['VirtualPre'];
		$new_student->post_no = $virtual_roll_number['VirtualPost'];
		$new_student->stu_name = $request->stu_name;
		$new_student->dob = $dob;
		$new_student->joining_date = $date;
		$new_student->scm = $date;
		$new_student->exemption = 0;
		$new_student->admin_fee_exemption = 0;
		$new_student->landline = $request->phone_no;
		$new_student->phone_no = $request->phone_no;
		$new_student->pincode = $request->pincode;
		$new_student->address = $request->address;
		$new_student->father_name = $request->father_name;
		$new_student->father_designation = $request->father_designation;
		$new_student->mother_name = $request->mother_name;
		$new_student->mother_designation = $request->mother_designation;
		$new_student->email_address1 = $request->email_address1;
		$new_student->email_address2 = 'FFF';
		$new_student->email_address3 = 'FFF';
		$new_student->status = 1;
		$new_student->user = $request->user;
		$new_student->had_id = 0;
		$new_student->save();
		
		
		
		$new_student = new StudentTeacherMapping;
		$new_student->regi_no = $roll_number['Final'];
		$new_student->level = $request->grades;
		$new_student->discipline = $fantom_discipline;
		$new_student->date_of_joining = $date;
		$new_student->date_change = '19870101';
		$new_student->teacher = $request->instructor;
		$new_student->special_fee = '0';
		$new_student->status = '1';
		$new_student->diff_amount = '0';
		$new_student->enrolment = '0';
		$new_student->refundable_deposit = '0';
		$new_student->frequency = '1';
		$new_student->user = $request->user;
		$new_student->save();
		
		
	$update = VirtualRollNum::find($virtual_roll_count);
			$update->VirtualRoll = $next_no;
			$update->save();
			
	$update = RollNumber::find($roll_count);
			$update->Final = $next_roll_no;
			$update->save();
				
	
			
			
		$amf_rate = GradesFee::wheregrades(9)->get();						
		$scm_rate = GradesFee::wheregrades(10)->get();
		$enrolments = GradesFee::wheregrades(52)->get();
		$deposits = GradesFee::wheregrades(53)->get();
		
		/*--------------INSERTING SCM -----------------*/
		if ($fantom_discipline != 16)

		{	


		$insert_to_due = new FeesDue;
		$insert_to_due->registration_no = $roll_number['Final'];
		$insert_to_due->fee_date = $date;
		$insert_to_due->particulars = 10;
		$insert_to_due->save();	

		}
		
		/*--------------END OF INSERTING SCM -----------------*/
		
		/*--------------INSERTING AMF-----------------*/
		
		$insert_to_due = new FeesDue;
		$insert_to_due->registration_no = $roll_number['Final'];
		$insert_to_due->fee_date = $date;
		$insert_to_due->particulars = 9;
		$insert_to_due->save();	
		
	}	
		/*--------------END OF INSERTING AMF -----------------*/
		
	$amf_dues = FeesDue::whereregistration_no($roll_number['Final'])
								->whereparticulars(9)
								->wherestatus(0)
								->get();
	
	$scm_dues = FeesDue::whereregistration_no($roll_number['Final'])
								->whereparticulars(10)
								->wherestatus(0)
								->get();
		
	$query = StudentTeacherMapping::wherediscipline($fantom_discipline)
										->whereregi_no($roll_number['Final'])
										->get();
					
				
				return view('new_admission', compact('query', 'amf_rate', 'scm_rate', 'enrolments', 'deposits', 'amf_dues', 'scm_dues'));
		
	
	}



		/*------------END OF APPLICATION FOR SHORT TERM PROGRAM-----------*/


		/*------------CODE FOR LIST OF STUDENTS NEEDING ID CARDS-----------*/


		public function students_needing_id()
		{

			$list_of_students_without_id = StudentInformation::wherehad_id(0)
																->wherestatus(1)
																->get();

			return view('Accounts.id_information', compact('list_of_students_without_id'));
		}

		/*------------END OF CODE FOR LIST OF STUDENTS NEEDING ID CARDS-----------*/
}	
