<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


//  shared routes
Route::middleware(['auth', 'role:admin,company-owner'])->group(function () {
    

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    //  job applications routes
    Route::resource('job-applications', JobApplicationController::class);
    Route::put('job-applications/{id}/restore', [JobApplicationController::class, 'restore'])->name('job-applications.restore');


    //  job vacancies routes
    Route::resource('job-vacancies', JobVacancyController::class);
    Route::put('job-vacancies/{id}/restore', [JobVacancyController::class, 'restore'])->name('job-vacancies.restore');

  
});

// company routes
Route::middleware(['auth', 'role:admin,company-owner'])->group(function () {

    //  company profile routes
    Route::get('my-company/', [CompanyController::class, 'show'])->name('my-company.show');
    Route::get('my-company/edit', [CompanyController::class, 'edit'])->name('my-company.edit');
    Route::put('my-company/update', [CompanyController::class, 'update'])->name('my-company.update');
});


// admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    //  users routes
    Route::resource('users', UserController::class);
    Route::put('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');

    //  companies routes
    Route::resource('companies', CompanyController::class);
    Route::put('companies/{id}/restore', [CompanyController::class, 'restore'])->name('companies.restore');
 
    //  job categories routes
    Route::resource('job-categories', JobCategoryController::class);
    Route::put('job-categories/{id}/restore', [JobCategoryController::class, 'restore'])->name('job-categories.restore');

});

require __DIR__.'/auth.php';
