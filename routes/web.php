<?php

use App\Http\Controllers\AddAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddlistController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\Managelist;
use App\Http\Controllers\Addressbook;
use App\Http\Controllers\ViewScheduledMessages;
use App\Http\Controllers\SingleSmsController;
use App\Http\Controllers\BulkSmsController;
use App\Http\Controllers\SmsTemplateController;
use App\Http\Controllers\CreditsController;
use App\Http\Controllers\ScheduleMessageController;
use App\Http\Controllers\AssignCreditController;
use App\Http\Controllers\CreditHistoryController;
use App\Http\Controllers\SmsReportController;
use App\Http\Controllers\AuditlogsController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BulkDeliveryReportsController;
use App\Http\Controllers\KeywordsController;
use App\Http\Controllers\MoSmsController;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::middleware('auth')->group(function() {
//     //Route::get('/dashboard', 'dashboard')->name('dashboard');
//     Route::get('/', 'DashboardController@index')->name('auth.dasboard');
//     //Route::get('/', [DashboardController::class, 'index'])->name('auth.dashboard');
//     Route::get('logout', [AuthController::class, 'logout'])->name('logout');
// });

Route::post('/addlistsaction',[AddlistController::class,'storelist']);

Route::post('/assigncreditaction',[AssignCreditController::class,'addcredit']);

Route::post('/smstemplatesaction',[SmsTemplateController::class,'addtemplate']);

Route::post('/addaccountaction', [StaffController::class,'addacount']);

Route::post('/singlesmsaction', [SingleSmsController::class,'sendsinglesms']);

Route::post('/bulksmsaction', [BulkSmsController::class,'sendbulksms']);

Route::post('/keywordsaction', [KeywordsController::class,'storekeyword']);

Route::post('/schedulemessageaction', [ScheduleMessageController::class ,'schedulemessage']);

Route::post('/uploadnumbers', [Managelist::class,'import_with_queue']);

Route::post('/deletecontact', [Addressbook::class,'deleteaddressbookcontact']);

Route::post('/editlist', [Managelist::class,'editlist']);

//Route::post('/keywordupdate', [KeywordsController::class,'update']);

Route::get('/dlr',[DashboardController::class,'bulksmsdeliveryreports']);

Route::get('/user_charts',[DashboardController::class,'user_charts']);

//Route::get('/receive_sms',[MoSmsController::class,'receivesms']);

Route::get('/receive',[KeywordsController::class,'receivesms']);

Route::get('/keywords', [KeywordsController::class, 'index'])->name('broadcasts.keywords');

Route::get('/createkeyword',[KeywordsController::class, 'create'])->name('broadcasts.keyword.create');

Route::get('/keywordedit',[KeywordsController::class,'edit'])->name('edit.keyword');


Route::get('/keywordedit/{keyword}/edit',[KeywordsController::class,'edit'])->name('edit.keyword');

Route::post('/keywordupdate/{keyword}/update',[KeywordsController::class,'update'])->name('update.keyword');


Route::middleware('auth')->group(function() {

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('loggedin')->group(function() {
    Route::get('login', [AuthController::class, 'loginView'])->name('login-view');
    Route::post('login', [AuthController::class, 'login'])->name('login');


    //Route::get('register', [AuthController::class, 'registerView'])->name('register-view');
    //Route::post('register', [AuthController::class, 'register'])->name('register');
});

Route::resource('roles', RoleController::class);

Route::resource('permissions', PermissionsController::class);
// Route::resource('roles', RoleController::class);
// Route::resource('permissions', PermissionsController::class);

/**
 * User Routes
 */
Route::group(['prefix' => 'users'], function() {
    Route::get('/', [UserController::class ,'index'])->name('users.index');
    Route::get('/create', [UserController::class ,'create'])->name('users.create');
    Route::post('/create', [UserController::class ,'store'])->name('users.store');
    Route::get('/{user}/show', [UserController::class ,'show'])->name('users.show');
    Route::get('/{user}/edit', [UserController::class ,'edit'])->name('users.edit');
    Route::post('/{user}/update', [UserController::class ,'update'])->name('users.update');
    Route::get('/{user}/delete', [UserController::class ,'destroy'])->name('users.destroy');
    Route::get('/units', [UserController::class ,'units'])->name('users.units');

});
//Route::resource('roles', RoleController::class);


Route::get('/users', [UserController::class ,'index'])->name('users.index')->middleware('auth');

Route::get('register', [AuthController::class, 'registerView'])->name('register-view')->middleware('auth');

Route::post('register', [AuthController::class, 'register'])->name('register')->middleware('auth');

Route::get('/managelists', [Managelist::class,'index'])->name('lists.managelist')->middleware('auth');

Route::get('/addressbook', [Addressbook::class,'index'])->name('lists.addressbook')->middleware('auth');

Route::get('/currentaccounts', [StaffController::class,'index'])->name('accounts.index')->middleware('auth');

Route::get('/smscredits', [CreditsController::class,'index'])->name('credits.index')->middleware('auth');

Route::get('viewnums/{id}', [Managelist::class,'show'])->name('lists.viewnums')->middleware('auth');

Route::get('deletenum/{id}', [Managelist::class,'deleteContacts'])->name('delete.number')->middleware('auth');

Route::get('uploadlist/{id}', [Managelist::class,'showuploadform'])->name('lists.uploadlist')->middleware('auth');

Route::get('deletekeywd/{id}', [KeywordsController::class,'delete'])->name('delete.keyword')->middleware('auth');

Route::get('deletelist/{id}', [Managelist::class,'deletelist'])->name('delete.list')->middleware('auth');

Route::get('deletescheduledmessage/{id}', [ViewScheduledMessages::class,'deleteMessage'])->name('delete.message')->middleware('auth');

Route::get('/smscredithistory', [CreditHistoryController::class,'index'])->name('credits.credithistories')->middleware('auth');

Route::get('/audittrail', [AuditlogsController::class,'index'])->name('reports.audittrail')->middleware('auth');

Route::get('/mosms', [MoSmsController::class,'details'])->name('broadcasts.mosmsdetails')->middleware('auth');

Route::get('/bulkdeliveryreports', [BulkDeliveryReportsController::class,'index'])->name('reports.bulkdeliveryreports')->middleware('auth');

Route::get('/smsreports', [SmsReportController::class,'index'])->name('reports.smsreports')->middleware('auth');

Route::get('/smstemplates', [SmsTemplateController::class,'index'])->name('broadcasts.smstemplate')->middleware('auth');

Route::get('/bulksms', [BulkSmsController::class,'index'])->name('broadcasts.bulksms')->middleware('auth');

Route::get('/singlesms', [SingleSmsController::class,'index'])->name('broadcasts.singlesms')->middleware('auth');

Route::get('/inbox', [MoSmsController::class,'index'])->name('broadcasts.mosms')->middleware('auth');

Route::get('/schedulesms', [ScheduleMessageController::class,'index'])->name('broadcasts.schedulemessages')->middleware('auth');

Route::get('/newaccount', [AddAccountController::class,'index'])->name('accounts.newaccount')->middleware('auth');

Route::get('/assigncredit', [AssignCreditController::class,'index'])->name('credits.assigncredit')->middleware('auth');

Route::get('/viewscheduledmessages', [ViewScheduledMessages::class,'index'])->name('broadcasts.viewscheduledmessages')->middleware('auth');

Route::get('/addlist', [AddlistController::class, 'index'])->name('lists.addlist')->middleware('auth');

Route::get('/export-csv',[SmsReportController::class,'exportCSV'])->middleware('auth');

Route::get('/export-csv5',[MoSmsController::class,'exportCSV'])->middleware('auth');

Route::get('/export-csv3',[BulkDeliveryReportsController::class,'exportCSV'])->name('reports.bulkdlieveryreportexport')->middleware('auth');
