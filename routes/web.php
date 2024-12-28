<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogsController;

Route::patch('/fcm-token', [AdminController::class, 'updateToken'])->name('fcmToken');
Route::get('test-socket', function(){
    return view('test_socket');
});
Route::get('/', function () {
    return redirect('login');
});
Route::match(['get', 'post'], 'delete-account-request', [AdminController::class, 'deleteAccountRequest'])->name('admin.userLogin');
Route::get('logout', function (){
    auth()->logout();
    return redirect('login');
})->name('admin.logout');
Route::get('privacy-policy', function() {
    return view('privacy');
});
Route::match(['get', 'post'], 'login', [AdminController::class, 'login'])->name('admin.login');
Route::get('/dashboard', [AdminController::class, 'account_request'])->name('admin.userDashboard');
Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {

    Route::resource('blogs', BlogsController::class);

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::match(['get', 'post'], '/setting', [AdminController::class, 'setting'])->name('setting');
    Route::get('/change-password', [AdminController::class, 'changePassword'])->name('changePassword');
    Route::post('/update-admin-password', [AdminController::class, 'updateAdminPassword'])->name('updateAdminPassword'); 
});
Route::get('test-notification', [AdminController::class, 'testNotification']);