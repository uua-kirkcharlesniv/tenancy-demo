<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Tenant\CompanyController;
use App\Http\Controllers\Tenant\EmployeeController;
use App\Http\Controllers\Tenant\GroupController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::group([
    'as' => 'tenant.',
    'middleware' => [
        'web',
        InitializeTenancyByDomain::class,
        PreventAccessFromCentralDomains::class,
    ]
], function () {
    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('login');

        Route::post('login', [AuthenticatedSessionController::class, 'store']);

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
            ->name('password.request');

        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
            ->name('password.email');

        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
            ->name('password.reset');

        Route::post('reset-password', [NewPasswordController::class, 'store'])
            ->name('password.store');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
            ->name('verification.notice');

        Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');

        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('verification.send');

        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->name('password.confirm');

        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    });

    Route::middleware('can:manage-company')->group(function () {
        Route::get('company', [CompanyController::class, 'edit'])->name('company.edit');
        Route::patch('company/update-company', [CompanyController::class, 'updateCompany'])->name('company.update');
        Route::delete('company/delete', [CompanyController::class, 'destroy'])->name('company.destroy');
        Route::post('company/manager/create', [CompanyController::class, 'createManager'])->name('company.addManager');
        Route::delete('company/manager/{id}/delete', [CompanyController::class, 'deleteManager'])->name('company.deleteManager');
        Route::patch('company/manager/{id}/demote', [CompanyController::class, 'demoteManager'])->name('company.demoteManager');
    });

    Route::middleware('can:manage-employees')->group(function () {
        Route::get('employees', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::post('employees/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::delete('employees/{id}/delete', [EmployeeController::class, 'delete'])->name('employees.delete');
        Route::middleware('can:manage-company')->patch('employees/{id}/promote', [EmployeeController::class, 'promote'])->name('employees.promote');
        Route::post('employees/import', [EmployeeController::class, 'import'])->name('employees.import');
    });

    Route::name('groups.')->prefix('groups')->group(function () {
        Route::get('', [GroupController::class, 'index'])->name('list');
        Route::post('create', [GroupController::class, 'create'])->name('create');
        Route::get('/{id}', [GroupController::class, 'view'])->name('view');
        Route::delete('/{id}/delete', [GroupController::class, 'delete'])->name('delete');
        Route::patch('/{id}/edit', [GroupController::class, 'edit'])->name('edit');
    });
});
