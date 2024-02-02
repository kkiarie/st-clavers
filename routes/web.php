<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

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


Route::get('test-index', 'App\Http\Controllers\TestController@index');


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('rtl', function () {
		return view('rtl');
	})->name('rtl');

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

    Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');



		Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);


	Route::post('profile/password', 'App\Http\Controllers\ProfileController@password');

    Route::get('/logout', [SessionsController::class, 'destroy']);

    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');



Route::get('school-program', 'App\Http\Controllers\FeedController@schoolProgram');



Route::get('menu-setup/create/{id}/{pid}', 'App\Http\Controllers\Admin\MenuController@create')->middleware('accountsuspend','auth');


Route::resource('menu-setup', 'App\Http\Controllers\Admin\MenuController')->middleware('accountsuspend','auth');
Route::resource('setting', 'App\Http\Controllers\Admin\SettingController')->middleware('accountsuspend','auth');





Route::resource('setup', 'App\Http\Controllers\Admin\SetupController')->middleware('accountsuspend','auth');
Route::get('setup-config/create/{id}', 'App\Http\Controllers\Admin\SetupConfigController@create')->middleware('accountsuspend','auth');

Route::resource('setup-config', 'App\Http\Controllers\Admin\SetupConfigController')->middleware('accountsuspend','auth');



Route::resource('roles', 'App\Http\Controllers\Admin\AssignMenuController')->middleware('accountsuspend','auth');

Route::get('roles/create/{id}', 'App\Http\Controllers\Admin\AssignMenuController@create')->middleware('accountsuspend','auth');


Route::resource('students', 'App\Http\Controllers\Admin\StudentController')->middleware('accountsuspend','auth');
Route::resource('teachers', 'App\Http\Controllers\Admin\TeacherController')->middleware('accountsuspend','auth');
Route::resource('parents', 'App\Http\Controllers\Admin\ParentController')->middleware('accountsuspend','auth');








Route::post('studentsQuery', 'App\Http\Controllers\Admin\StudentController@studentsQuery')->middleware('accountsuspend','auth');

Route::post('teachersQuery', 'App\Http\Controllers\Admin\TeacherController@teachersQuery')->middleware('accountsuspend','auth');


Route::resource('grades', 'App\Http\Controllers\Admin\GradeController')->middleware('accountsuspend','auth');

Route::post('gradesQuery', 'App\Http\Controllers\Admin\GradeController@gradesQuery')->middleware('accountsuspend','auth');





Route::resource('program', 'App\Http\Controllers\Admin\ProgramController')->middleware('accountsuspend','auth');


Route::get('program-pdf/{id}', 'App\Http\Controllers\Admin\ProgramController@pdf')->middleware('accountsuspend','auth');

Route::post('programQuery', 'App\Http\Controllers\Admin\ProgramController@programQuery')->middleware('accountsuspend','auth');



Route::resource('program-subject', 'App\Http\Controllers\Admin\ProgramSubjectController')->middleware('accountsuspend','auth');
Route::get('program-subject/create/{id}', 'App\Http\Controllers\Admin\ProgramSubjectController@create')->middleware('accountsuspend','auth');


Route::post('parentQuery', 'App\Http\Controllers\Admin\ParentController@parentQuery')->middleware('accountsuspend','auth');



Route::resource('notification', 'App\Http\Controllers\Admin\NotificationController')->middleware('accountsuspend','auth');


Route::post('notificationQuery', 'App\Http\Controllers\Admin\NotificationController@notificationQuery')->middleware('accountsuspend','auth');




Route::get('my-notification', 'App\Http\Controllers\Admin\NotificationController@mynotification')->middleware('accountsuspend','auth');




Route::resource('ledger-codes', 'App\Http\Controllers\Admin\LedgerCodeController')->middleware('accountsuspend','auth');
Route::get('ledger-code-items/create/{id}', 'App\Http\Controllers\Admin\LedgerCodeItemController@create')->middleware('accountsuspend','auth');


Route::resource('ledger-code-items', 'App\Http\Controllers\Admin\LedgerCodeItemController')->middleware('accountsuspend','auth');




Route::post('ledgerQuery', 'App\Http\Controllers\Admin\LedgerCodeController@ledgerQuery')->middleware('accountsuspend','auth');



Route::resource('inventory-master-list', 'App\Http\Controllers\Admin\InventoryMasterController')->middleware('accountsuspend','auth');




Route::post('inventoryQuery', 'App\Http\Controllers\Admin\InventoryMasterController@inventoryQuery')->middleware('accountsuspend','auth');


Route::resource('assign-student-class', 'App\Http\Controllers\Admin\AssignStudentClassController')->middleware('accountsuspend','auth');


Route::get('assign-student-class/create/{id}', 'App\Http\Controllers\Admin\AssignStudentClassController@create')->middleware('accountsuspend','auth');



Route::get('students-link-parent/{id}', 'App\Http\Controllers\Admin\StudentController@parentLink')->middleware('accountsuspend','auth');



Route::post('processParentLink', 'App\Http\Controllers\Admin\StudentController@processParentLink')->middleware('accountsuspend','auth');



Route::get('class-student-report', 'App\Http\Controllers\Admin\StudentController@classStudentReport')->middleware('accountsuspend','auth');




Route::post('reportDataProcess', 'App\Http\Controllers\Admin\StudentController@reportDataProcess')->middleware('accountsuspend','auth');







Route::get('class-student-report-summary', 'App\Http\Controllers\Admin\StudentController@classStudentReportSummary')->middleware('accountsuspend','auth');




Route::post('reportDataProcessSummary', 'App\Http\Controllers\Admin\StudentController@reportDataProcessSummary')->middleware('accountsuspend','auth');





Route::resource('resources-hub', 'App\Http\Controllers\Admin\ResourceHubMaterialController')->middleware('accountsuspend','auth');

Route::get('resources-hub-publish/{id}', 'App\Http\Controllers\Admin\ResourceHubMaterialController@ResourcePublish')->middleware('accountsuspend','auth');

Route::get('my-resources-hub', 'App\Http\Controllers\Admin\ResourceHubMaterialController@myResourceHub')->middleware('accountsuspend','auth');




Route::resource('fee-structure', 'App\Http\Controllers\Admin\FeeStructureController')->middleware('accountsuspend','auth');

Route::get('fee-structure/create/{id}', 'App\Http\Controllers\Admin\FeeStructureController@create')->middleware('accountsuspend','auth');


Route::get('fee-structure-complete/{id}', 'App\Http\Controllers\Admin\FeeStructureController@complete')->middleware('accountsuspend','auth');



Route::get('fee-structure-pdf/{id}', 'App\Http\Controllers\Admin\FeeStructureController@pdf')->middleware('accountsuspend','auth');



Route::get('fee-hub', 'App\Http\Controllers\Admin\ParentHubController@feeHub')->middleware('accountsuspend','auth');


Route::get('child-hub', 'App\Http\Controllers\Admin\ParentHubController@childHub')->middleware('accountsuspend','auth');




Route::resource('fee-payment', 'App\Http\Controllers\Admin\FeePaymentController')->middleware('accountsuspend','auth');



Route::post('feepaymentProc', 'App\Http\Controllers\Admin\FeePaymentController@feepaymentProc')->middleware('accountsuspend','auth');


Route::get('fee-payment-choice/{id}', 'App\Http\Controllers\Admin\FeePaymentController@choice')->middleware('accountsuspend','auth');


Route::get('fee-payment/create/{FeeID}/{userID}',
'App\Http\Controllers\Admin\FeePaymentController@create')->middleware('accountsuspend','auth');



Route::get('fee-payment/complete/{id}',
'App\Http\Controllers\Admin\FeePaymentController@complete')->middleware('accountsuspend','auth');



Route::get('fee-payment-pdf/{id}',
'App\Http\Controllers\Admin\FeePaymentController@pdf')->middleware('accountsuspend','auth');


Route::get('fee-payment-history/{id}','App\Http\Controllers\Admin\FeePaymentController@feeHistory')
->middleware('accountsuspend','auth');


Route::get('student-parent-unmerge/{id}',
'App\Http\Controllers\Admin\StudentController@parentUmerge')->middleware('accountsuspend','auth');



Route::get('parent-payment-history/{id}','App\Http\Controllers\Admin\ParentHubController@feeHistory')
->middleware('accountsuspend','auth');


Route::resource('class-teachers', 'App\Http\Controllers\Admin\ClassTeacherController')->middleware('accountsuspend','auth');



Route::resource('subject-teachers', 'App\Http\Controllers\Admin\SubjectTeacherController')->middleware('accountsuspend','auth');

Route::resource('diary', 'App\Http\Controllers\Admin\DiaryController')->middleware('accountsuspend','auth');



Route::post('diaryQuery', 'App\Http\Controllers\Admin\DiaryController@diaryQuery')->middleware('accountsuspend','auth');






Route::get('diary-complete/{id}', 'App\Http\Controllers\Admin\DiaryController@complete')->middleware('accountsuspend','auth');

Route::get('parent-hub-diary', 'App\Http\Controllers\Admin\ParentHubController@hubDiary')->middleware('accountsuspend','auth');




Route::resource('student-attendance', 'App\Http\Controllers\Admin\StudentAttendanceController')->middleware('accountsuspend','auth');



Route::post('studentAttendProc', 'App\Http\Controllers\Admin\StudentAttendanceController@studentAttendProc')->middleware('accountsuspend','auth');


Route::get('student-attendance-choice/{id}', 'App\Http\Controllers\Admin\StudentAttendanceController@choice')->middleware('accountsuspend','auth');




Route::get('students-attendance-gen/{id}', 'App\Http\Controllers\StudentAttendanceController@attendanceGen');



Route::get('students-attendance-validate/{id}', 'App\Http\Controllers\StudentAttendanceController@attendanceValidate');




Route::resource('exams-configuration', 'App\Http\Controllers\Admin\ExamConfigurationController')->middleware('accountsuspend','auth');



Route::get('exams-configuration/create/{id}', 'App\Http\Controllers\Admin\ExamConfigurationController@create')->middleware('accountsuspend','auth');






Route::resource('student-performance', 'App\Http\Controllers\Admin\StudentPerformanceController')->middleware('accountsuspend','auth');



Route::post('performanceProc', 'App\Http\Controllers\Admin\StudentPerformanceController@performanceProc')->middleware('accountsuspend','auth');




Route::get('student-performance/create/{exam_record}/{term}/{grade}/{subject}', 'App\Http\Controllers\Admin\StudentPerformanceController@create')->middleware('accountsuspend','auth');






Route::get('student-performance-report', 'App\Http\Controllers\Admin\StudentPerformanceController@studentPerformanceReport')->middleware('accountsuspend','auth');




Route::post('studentReportProc', 'App\Http\Controllers\Admin\StudentPerformanceController@studentReportProc')
->middleware('accountsuspend','auth');




Route::resource('procurement', 'App\Http\Controllers\Admin\ProcurementController')
->middleware('accountsuspend','auth');




Route::get('procurement/create/{id}', 'App\Http\Controllers\Admin\ProcurementController@create')
->middleware('accountsuspend','auth');



Route::post('procurement-search-process', 'App\Http\Controllers\Admin\ProcurementController@searchProcess')
->middleware('accountsuspend','auth');




Route::get('procurement/pdf/{id}', 'App\Http\Controllers\Admin\ProcurementController@pdf')
->middleware('accountsuspend','auth');



// Route::resource('procurement-quotes', 'App\Http\Controllers\Admin\ProcurementQuotesController')
// ->middleware('accountsuspend','auth');




Route::get('procurement/submission/{id}', 'App\Http\Controllers\Admin\ProcurementController@submission')
->middleware('accountsuspend','auth');






Route::get('procurement/complete/{id}', 'App\Http\Controllers\Admin\ProcurementController@complete')
->middleware('accountsuspend','auth');


Route::get('procurement/cancel/{id}', 'App\Http\Controllers\Admin\ProcurementController@cancelRequest')
->middleware('accountsuspend','auth');





Route::get('internalPay/{id}', 'App\Http\Controllers\Admin\ProcurementController@internalPay')
->middleware('accountsuspend','auth');


Route::post('internalPayProccess', 'App\Http\Controllers\Admin\ProcurementController@internalPayProccess')
->middleware('accountsuspend','auth');





Route::get('inventory-request/create/{id}', 'App\Http\Controllers\Admin\InventoryRequestController@create')->middleware('accountsuspend','auth');


Route::get('inventory-request-submit/{id}', 'App\Http\Controllers\Admin\InventoryRequestController@requestSubmit')->middleware('accountsuspend','auth');


Route::get('inventory-request-approve/{id}', 'App\Http\Controllers\Admin\InventoryRequestController@requestApprove')->middleware('accountsuspend','auth');



Route::get('inventory-request-collection/{id}', 'App\Http\Controllers\Admin\InventoryRequestController@requestCollection')->middleware('accountsuspend','auth');



Route::get('inventory-approval-list', 'App\Http\Controllers\Admin\InventoryRequestController@approvaList')->middleware('accountsuspend','auth');

Route::resource('inventory-request', 'App\Http\Controllers\Admin\InventoryRequestController')
->middleware('accountsuspend','auth');


Route::get('inventory-request/pdf/{id}', 'App\Http\Controllers\Admin\InventoryRequestController@pdf')
->middleware('accountsuspend','auth');








Route::resource('payment', 'App\Http\Controllers\Admin\PaymentController')
->middleware('accountsuspend','auth');



Route::get('payment-submission/{id}', 'App\Http\Controllers\Admin\PaymentController@submission')
->middleware('accountsuspend','auth');





Route::get('mobile-payment-confirmation', 'App\Http\Controllers\MobilePaymentController@paymentConfirmation');
Route::get('mobile-payment-validation', 'App\Http\Controllers\MobilePaymentController@paymentValidation');
Route::get('mobile-payment-register-urls', 'App\Http\Controllers\MobilePaymentController@registerUrls');



Route::get('fee-payment-mpesa/{id}', 'App\Http\Controllers\Admin\FeePaymentController@mpesa')
->middleware('accountsuspend','auth');




Route::resource('subject-clusters', 'App\Http\Controllers\Admin\SubjectClusterController')
->middleware('accountsuspend','auth');


Route::get('subject-clusters/create/{id}', 'App\Http\Controllers\Admin\SubjectClusterController@create')
->middleware('accountsuspend','auth');




Route::get('student-subject-clusters/{id}', 'App\Http\Controllers\Admin\StudentController@chooseCluster')
->middleware('accountsuspend','auth');



Route::post('chooseClusterProc', 'App\Http\Controllers\Admin\StudentController@chooseClusterProc')
->middleware('accountsuspend','auth');





Route::get('report-form', 'App\Http\Controllers\Admin\StudentPerformanceController@reportForm')->middleware('accountsuspend','auth');




Route::post('reportFormProc', 'App\Http\Controllers\Admin\StudentPerformanceController@reportFormProc')
->middleware('accountsuspend','auth');





Route::resource('exams-lock', 'App\Http\Controllers\Admin\ExamsLockController')
->middleware('accountsuspend','auth');




Route::post('studentsImportProc', 'App\Http\Controllers\Admin\StudentController@studentsImportProc')->middleware('accountsuspend','auth');



Route::get('students-import', 'App\Http\Controllers\Admin\StudentController@studentsImport')->middleware('accountsuspend','auth');








Route::post('teacherImportProc', 'App\Http\Controllers\Admin\TeacherController@teacherImportProc')->middleware('accountsuspend','auth');



Route::get('teachers-import', 'App\Http\Controllers\Admin\TeacherController@teachersImport')->middleware('accountsuspend','auth');





Route::resource('time-table', 'App\Http\Controllers\Admin\TimeTableController')
->middleware('accountsuspend','auth');


Route::get('time-table/subject/{grade}/{term}', 'App\Http\Controllers\Admin\TimeTableController@subjectSelection')
->middleware('accountsuspend','auth');

Route::get('time-table/create/{grade}/{term}', 'App\Http\Controllers\Admin\TimeTableController@create')
->middleware('accountsuspend','auth');