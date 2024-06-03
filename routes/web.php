<?php

use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\VerifyAdmin;
use App\Http\Middleware\VerifyUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware(VerifyUser::class)->group(function () {
  Route::get('/home', [HomeController::class, 'index'])->name('home');
  Route::get('/', [HomeController::class, 'index']);
  Route::get('/edit-pseudo', [HomeController::class, 'changePseudo'])->name('edit-pseudo');
  Route::get('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
  Route::post('/change-password', [HomeController::class, 'updatePassword'])->name('save-password');
  Route::middleware(VerifyAdmin::class)->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
      Route::get('/', [AdminHomeController::class, 'index'])->name('index');
      Route::resource('user', UserAdminController::class);
    });
  });
});


