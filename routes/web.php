<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('index');
});*/

Auth::routes();

Route::get('/', ['uses' => 'MainController@index']);

Route::post('/', ['uses' => 'MainController@index'])->name('search');

Route::get('/{discipline}', ['uses' => 'MainController@discipline'])->name('pgone');

Route::get('Exams/Info', ['uses' => 'ExamsController@registry'])->middleware('auth');

Route::post('Exams/Info/add', ['uses' => 'ExamsController@add_exam'])->middleware('auth');

Route::get('Exams/Exam_by_details/{exam_no}', ['uses' => 'ExamsController@exam_details'])->name('exam_details')->middleware('auth');

Route::get('Forms/History/{discipline}/{teacher}/{student}',  ['uses' => 'MainController@history_report'])->name('historical_report');


















Route::get('{discipline}/{student}', 'MainController@individual')->name('pgtwo');

Route::get('List_by_teacher/{discipline}/{teacher}', 'MainController@list_by_teacher')->name('details_by_teacher');

Route::post('{discipline}/{student}', 'MainController@individual')->middleware('auth');

Route::post('Forms/{discipline}/{teacher}/{student}', 'TotalController@total')->middleware('auth');

Route::get('Forms/Miscelleneous/{discipline}/{teacher}/{student}',  ['uses' => 'MainController@miscelleneous'])->name('miscelleneous');

Route::post('Forms/Miscelleneous/{discipline}/{teacher}/{student}',  ['uses' => 'MainController@miscelleneous'])->name('miscelleneous');

Route::get('Forms/Trinity_Practical/{discipline}/{teacher}/{student}', ['uses' => 'MainController@trinity_practical'])->middleware('auth');

Route::get('Forms/Trinity_Theory/{discipline}/{teacher}/{student}', ['uses' => 'MainController@trinity_theory'])->middleware('auth');

Route::get('Forms/ABRSM_Practical/{discipline}/{teacher}/{student}', ['uses' => 'MainController@abrsm_practical'])->middleware('auth');

Route::get('Forms/ABRSM_Theory/{discipline}/{teacher}/{student}', ['uses' => 'MainController@abrsm_theory'])->middleware('auth');

Route::post('Forms/Trinity_Practical/{discipline}/{teacher}/{student}', ['uses' => 'MainController@trinity_practical'])->name('enter_trinity_practical')->middleware('auth');

Route::post('Forms/Trinity_Theory/{discipline}/{teacher}/{student}', ['uses' => 'MainController@trinity_theory'])->name('enter_trinity_theory')->middleware('auth');

Route::post('Forms/ABRSM_Practical/{discipline}/{teacher}/{student}', ['uses' => 'MainController@abrsm_practical'])->name('enter_abrsm_practical')->middleware('auth');

Route::post('Forms/ABRSM_Theory/{discipline}/{teacher}/{student}', ['uses' => 'MainController@abrsm_theory'])->name('enter_abrsm_theory')->middleware('auth');

Route::get('Forms/Edit_Student/{discipline}/{teacher}/{regi_no}', 'MainController@edit_student')->name('edit_student')->middleware('auth');

Route::get('Forms/Edit_Student/Change_Parameters/{discipline}/{teacher}/{regi_no}', 'MainController@change_parameters')->name('change_parameters')->middleware('auth');

Route::post('Forms/Edit_Student/Change_Parameters/{discipline}/{teacher}/{regi_no}', 'MainController@change_parameters2')->name('change_parameters2')->middleware('auth');

Route::post('Forms/Edit_Student/Change_Parameters/Update/{discipline}/{teacher}/{regi_no}', 'MainController@change_parameters3')->name('complete_editing_parameters')->middleware('auth');

Route::get('Forms/Edit_Student/Change_Teacher/{discipline}/{teacher}/{regi_no}', 'MainController@change_teacher')->name('change_teacher')->middleware('auth');








Route::get('Forms/Edit_Student/Discontinue/{discipline}/{teacher}/{regi_no}', 'MainController@discontinue')->name('discontinue')->middleware('auth');

Route::get('Forms/Edit_Student/Change_Level/{discipline}/{teacher}/{regi_no}', 'MainController@change_level')->name('change_level')->middleware('auth');

Route::post('Forms/Edit_Student/{discipline}/{teacher}/{regi_no}', 'MainController@update_student')->name('edit_student')->middleware('auth');

Route::post('Forms/Notes/{{ $q->discipline }}/{{ $q->teacher }}/{{ $q->regi_no }}', 'MainController@individual')->middleware('auth');

Route::get('Forms/Tuition_fees_by_month/{discipline}/{teacher}/{student}', 'MainController@tuition_fees_by_month')->name('tuition_fees_by_month')->middleware('auth');

Route::post('Forms/Tuition_fees_by_month/Total/{discipline}/{teacher}/{student}', 'TotalController@total_tuition_fees_by_month')->name('total_tuition_fees_by_month')->middleware('auth');

Route::post('Forms/Tuition_fees_by_month/Take_Fees/{discipline}/{teacher}/{student}', 'MainController@tuition_fees_by_month')->name('take_tuition_fees_by_month')->middleware('auth');

Route::get('/Forms/Aural_and_Accompaniment/{discipline}/{teacher}/{student}', 'MainController@aural_and_accompaniment')->name('aural_and_accompaniment')->middleware('auth');

Route::post('/Forms/Aural_and_Accompaniment/{discipline}/{teacher}/{student}', 'MainController@aural_and_accompaniment')->name('aural_and_accompaniment_to_pay')->middleware('auth');

Route::get('Accounts/Accounts/Info', ['uses' => 'AccountsController@main']);

Route::get('Accounts/Accounts/Late_Fees_Update', ['uses' => 'AccountsController@lateupdate'])->name('late_fees_update');

Route::get('Accounts/Accounts/New_admission', ['uses' => 'AccountsController@new_admission'])->name('new_admission')->middleware('auth');

Route::post('Accounts/Accounts/New_admission/Step2', ['uses' => 'AccountsController@new_admission2'])->middleware('auth');

Route::post('Accounts/Accounts/New_admission/EnterStudentIndividual', ['uses' => 'AccountsController@enter_new_graded_student'])->middleware('auth');

Route::post('Accounts/Accounts/New_admission/EnterStudentGroup', ['uses' => 'AccountsController@enter_new_group_student'])->middleware('auth');

Route::get('Accounts/Accounts/SpecialProgram', ['uses' => 'AccountsController@special_program'])->name('special_program')->middleware('auth');

Route::post('Accounts/Accounts/SpecialProgram/EnterTeacher', ['uses' => 'AccountsController@special_programs2'])->name('special_program_teacher')->middleware('auth')->middleware('auth');

Route::post('Accounts/Accounts/SpecialProgram/EnterStudentSpecialProgram', ['uses' => 'AccountsController@special_program3'])->name('special_program_enter_student')->middleware('auth')->middleware('auth');

Route::get('Accounts/Accounts/ShortTermPrograms', ['uses' => 'AccountsController@short_term_program'])->name('short_term_program')->middleware('auth');

Route::post('Accounts/Accounts/ShortTermPrograms/EnterTeacher', ['uses' => 'AccountsController@short_term_program2'])->name('short_term_select_teacher')->middleware('auth')->middleware('auth');

Route::post('Accounts/Accounts/ShortTermPrograms/EnterStudentShortTerm', ['uses' => 'AccountsController@short_term_program3'])->name('short_term_enter_student')->middleware('auth')->middleware('auth');

Route::get('Accounts/Accounts/Graded_Prg', ['uses' => 'AccountsController@graded_fee'])->name('graded_fee')->middleware('auth');

Route::post('Accounts/Accounts/Graded_Prg/Edit', ['uses' => 'AccountsController@graded_fee'])->name('edit_graded_fee')->middleware('auth');

Route::post('Accounts/Accounts/Graded_Prg/Updated', ['uses' => 'AccountsController@update_graded_fee'])->name('update_graded_fee')->middleware('auth');

Route::get('Accounts/Accounts/Short_prg', ['uses' => 'AccountsController@short_fee'])->name('short_fee')->middleware('auth');

Route::post('Accounts/Accounts/Short_prg/Edit', ['uses' => 'AccountsController@short_fee'])->name('edit_short_fee')->middleware('auth');

Route::post('Accounts/Accounts/Short_prg/Updated', ['uses' => 'AccountsController@update_short_fee'])->name('update_short_fee')->middleware('auth');

Route::get('Accounts/Accounts/Special_prg', ['uses' => 'AccountsController@special_fee'])->name('special_fee')->middleware('auth');

Route::post('Accounts/Accounts/Special_prg/Edit', ['uses' => 'AccountsController@special_fee'])->name('edit_special_fee')->middleware('auth');

Route::post('Accounts/Accounts/Special_prg/Updated', ['uses' => 'AccountsController@update_special_fee'])->name('update_special_fee')->middleware('auth');

Route::get('Accounts/Accounts/ABRSM_prg', ['uses' => 'AccountsController@abrsm_fee'])->name('abrsm_fee')->middleware('auth');

Route::post('Accounts/Accounts/ABRSM_prg/Edit', ['uses' => 'AccountsController@abrsm_fee'])->name('edit_abrsm_fee')->middleware('auth');

Route::post('Accounts/Accounts/ABRSM_prg/Updated', ['uses' => 'AccountsController@update_abrsm_fee'])->name('update_abrsm_fee')->middleware('auth');

Route::get('Accounts/Accounts/Trinity_Prg', ['uses' => 'AccountsController@trinity_fee'])->name('trinity_fee');

Route::post('Accounts/Accounts/Trinity_Prg/Edit', ['uses' => 'AccountsController@trinity_fee'])->name('edit_trinity_fee')->middleware('auth');

Route::post('Accounts/Accounts/Trinity_Prg/Updated', ['uses' => 'AccountsController@update_trinity_fee'])->name('update_trinity_fee');

Route::get('Accounts/Accounts/One_Time_Prg', ['uses' => 'AccountsController@one_time_fee'])->name('one_time_fee')->middleware('auth');

Route::post('Accounts/Accounts/One_Time_Prg/Edit', ['uses' => 'AccountsController@one_time_fee'])->name('edit_one_time_fee')->middleware('auth');

Route::post('Accounts/Accounts/One_Time_Prg/Updated', ['uses' => 'AccountsController@update_one_time_fee'])->name('update_one_time_fee')->middleware('auth');

Route::get('Accounts/Accounts/Admin_Prg', ['uses' => 'AccountsController@admin_fee'])->name('admin_fee')->middleware('auth');

Route::post('Accounts/Accounts/Admin_Prg/Edit', ['uses' => 'AccountsController@admin_fee'])->name('edit_admin_fee')->middleware('auth');

Route::post('Accounts/Accounts/Admin_Prg/Updated', ['uses' => 'AccountsController@update_admin_fee'])->name('update_admin_fee')->middleware('auth');

Route::get('Accounts/Accounts/Students_needing_id', ['uses' => 'AccountsController@students_needing_id'])->name('students_needing_id');

Route::post('Reports/{from_date}/{till_date}', ['uses' => 'AccountsController@main'])->name('accounts_reports');

Route::get('Reports/Total_Collections{from_date}/{till_date}', ['uses' => 'AccountsController@reports_total_collections'])->name('accounts_reports_total');

Route::get('Reports/SCM_Report{from_date}/{till_date}', ['uses' => 'AccountsController@reports_scm_collections'])->name('accounts_scm_report');

Route::get('Reports/AMF_Report{from_date}/{till_date}', ['uses' => 'AccountsController@reports_amf_collections'])->name('accounts_amf_report');

Route::get('Reports/Monthly_Fee_Due/List', ['uses' => 'AccountsController@reports_monthly_fee_due'])->name('accounts_monthly_fee_due');

Route::get('Reports/Admin_Fee_Due/List', ['uses' => 'AccountsController@reports_admin_fee_due'])->name('accounts_admin_fee_due');

Route::get('Reports/Late_Fee_Due/List', ['uses' => 'AccountsController@reports_late_fee_due'])->name('accounts_late_fee_due');













