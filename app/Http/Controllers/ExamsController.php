<?php

namespace App\Http\Controllers;

use App\ExamsTable;
use App\ExamStudentDatabase;

use Illuminate\Http\Request;

class ExamsController extends Controller
{
    
	public function exam_details($exam_no)
	{	
	
		$query = ExamStudentDatabase::wheree_s_d_code($exam_no)->get();
		

		
		
		return view('Exams.Details_by_Exams', compact('query'));
	}




    public function registry()
	{	
	
		$query = ExamsTable::wherestatus(1)->get();
		$message = 0;


		
		return view('Exams.registration', compact('query', 'message'));
	}


	public function add_exam(Request $request)
	{	
		$query = ExamsTable::wherestatus(1)->get();	
			if (isset($_POST['add_trinity']))
				{
					return view('Exams.add_trinity');
				}
			if (isset($_POST['add_abrsm']))
				{
					return view('Exams.add_abrsm');
				}	
				
			if (isset($_POST['submit_trinity_exam']))
				{
					$message = 1;
										
					$approx_date = date('Ymd', strtotime("$request->approx_date"));
					$date_in_name = date('F Y', strtotime("$request->approx_date"));
					$last_date = date('Ymd', strtotime("$request->last_date"));
					$exam_name = $request->category;
					if ($exam_name == 1)
						{
							$name = "Trinity Practical $date_in_name";
						}
					else
						{
							$name = "Trinity Theory $date_in_name";
						}	
					$insert_to_trinity = new ExamsTable;
					
					$insert_to_trinity->exam_code = $request->trinity;
					$insert_to_trinity->exam_name = $name;	
					$insert_to_trinity->category_code = $request->category;
					$insert_to_trinity->approx_date = $approx_date;
					$insert_to_trinity->last_app_date = $last_date;
					$insert_to_trinity->user = $request->user;
					$insert_to_trinity->save();
				$query = ExamsTable::wherestatus(1)->get();
				
					return view('Exams.registration', compact('query', 'message'));
	
				}
			if (isset($_POST['submit_ABRSM_exam']))
				{
					$message = 1;
					
					
					$approx_date = date('Ymd', strtotime("$request->approx_date"));
					$date_in_name = date('F Y', strtotime("$request->approx_date"));
					$last_date = date('Ymd', strtotime("$request->last_date"));
					$exam_name = $request->category;
					if ($exam_name == 1)
						{
							$name = "ABRSM Practical $date_in_name";
						}
					else
						{
							$name = "ABRSM Theory $date_in_name";
						}	
					
					$insert_to_abrsm = new ExamsTable;
					
					$insert_to_abrsm->exam_code = $request->abrsm;
					$insert_to_abrsm->exam_name = $name;	
					$insert_to_abrsm->category_code = $request->category;
					$insert_to_abrsm->approx_date = $approx_date;
					$insert_to_abrsm->last_app_date = $last_date;
					$insert_to_abrsm->user = $request->user;
					$insert_to_abrsm->save();
				$query = ExamsTable::wherestatus(1)->get();
				
					return view('Exams.registration', compact('query', 'message'));
	
				}				
	}
}
