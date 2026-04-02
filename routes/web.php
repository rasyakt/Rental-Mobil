<?php

use App\Http\Controllers\Admin\{
    DashboardController as AdminDashboardController,
    BranchController,
    VehicleController,
    DriverController,
    BookingController as AdminBookingController,
    PaymentController as AdminPaymentController,
    ReportController,
    MaintenanceController,
    UserController,
};
use App\Http\Controllers\Customer\{
    DashboardController as CustomerDashboardController,
    BookingController as CustomerBookingController,
    VehicleController as CustomerVehicleController,
    PaymentController as CustomerPaymentController,
    ProfileController as CustomerProfileController,
};
use App\Http\Controllers\Public\{
    LandingController,
    SearchController,
};
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::controller(LandingController::class)->group(function () {
    Route::get('/', 'index')->name('landing.index');
    Route::get('/vehicles', 'vehicles')->name('landing.vehicles');
    Route::get('/vehicle/{id}', 'vehicleDetail')->name('landing.vehicle.detail');
    Route::get('/about', 'about')->name('landing.about');
    Route::get('/branches', 'branches')->name('landing.branches');
    Route::get('/faq', 'faq')->name('landing.faq');
    Route::get('/contact', 'contact')->name('landing.contact');
    Route::post('/contact', 'submitContact')->name('landing.contact.submit');
});

Route::controller(SearchController::class)->group(function () {
    Route::get('/search', 'index')->name('search');
    Route::get('/search/vehicles', 'vehicles')->name('search.vehicles');
});

// Authentication Routes
Route::controller(AuthController::class)->middleware('guest')->group(function () {
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register')->name('register.submit');
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login')->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Authenticated Routes
Route::middleware(['auth', 'active'])->group(function () {
    
    // Customer Routes
    Route::middleware(['customer'])->prefix('dashboard')->name('customer.')->group(function () {
        Route::controller(CustomerDashboardController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard');
        });

        Route::controller(CustomerVehicleController::class)->prefix('vehicles')->name('vehicles.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{id}', 'show')->name('show');
        });

        Route::controller(CustomerBookingController::class)->prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}', 'show')->name('show');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
            Route::post('/{id}/cancel', 'cancel')->name('cancel');
        });

        Route::controller(CustomerPaymentController::class)->prefix('payments')->name('payments.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{id}', 'show')->name('show');
            Route::post('/process', 'process')->name('process');
            Route::post('/midtrans-callback', 'midtransCallback')->name('midtrans.callback');
            Route::post('/xendit-callback', 'xenditCallback')->name('xendit.callback');
        });

        Route::controller(CustomerProfileController::class)->prefix('profile')->name('profile.')->group(function () {
            Route::get('/', 'edit')->name('edit');
            Route::put('/', 'update')->name('update');
            Route::put('/password', 'updatePassword')->name('password.update');
        });
    });

    // Admin & Staff Routes
    Route::middleware(['admin-staff'])->prefix('admin')->name('admin.')->group(function () {
        
        Route::controller(AdminDashboardController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard');
            Route::get('/statistics', 'statistics')->name('statistics');
        });

        // Branch Management
        Route::resource('branches', BranchController::class)->except(['show']);
        Route::post('branches/{id}/activate', [BranchController::class, 'activate'])->name('branches.activate');
        Route::post('branches/{id}/deactivate', [BranchController::class, 'deactivate'])->name('branches.deactivate');

        // Vehicle Management
        Route::resource('vehicles', VehicleController::class);
        Route::post('vehicles/{id}/upload-images', [VehicleController::class, 'uploadImages'])->name('vehicles.upload-images');
        Route::delete('vehicles/{id}/images/{imageId}', [VehicleController::class, 'deleteImage'])->name('vehicles.delete-image');
        Route::post('vehicles/{id}/change-status', [VehicleController::class, 'changeStatus'])->name('vehicles.change-status');
        Route::get('vehicles/{id}/tracking', [VehicleController::class, 'trackingHistory'])->name('vehicles.tracking');

        // Driver Management
        Route::resource('drivers', DriverController::class);
        Route::post('drivers/{id}/upload-photo', [DriverController::class, 'uploadPhoto'])->name('drivers.upload-photo');
        Route::post('drivers/{id}/change-status', [DriverController::class, 'changeStatus'])->name('drivers.change-status');
        Route::get('drivers/{id}/schedule', [DriverController::class, 'schedule'])->name('drivers.schedule');
        Route::post('drivers/{id}/schedule', [DriverController::class, 'updateSchedule'])->name('drivers.schedule.update');

        // Booking Management
        Route::resource('bookings', AdminBookingController::class)->only(['index', 'show', 'edit', 'update']);
        Route::post('bookings/{id}/confirm', [AdminBookingController::class, 'confirm'])->name('bookings.confirm');
        Route::post('bookings/{id}/reject', [AdminBookingController::class, 'reject'])->name('bookings.reject');
        Route::post('bookings/{id}/assign-driver', [AdminBookingController::class, 'assignDriver'])->name('bookings.assign-driver');
        Route::post('bookings/{id}/complete', [AdminBookingController::class, 'complete'])->name('bookings.complete');
        Route::get('bookings/{id}/invoice', [AdminBookingController::class, 'invoice'])->name('bookings.invoice');
        Route::post('bookings/{id}/report-damage', [AdminBookingController::class, 'reportDamage'])->name('bookings.report-damage');

        // Payment Management
        Route::resource('payments', AdminPaymentController::class)->only(['index', 'show']);
        Route::post('payments/{id}/verify', [AdminPaymentController::class, 'verify'])->name('payments.verify');
        Route::post('payments/{id}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');
        Route::post('payments/{id}/refund', [AdminPaymentController::class, 'refund'])->name('payments.refund');

        // Maintenance & Damage
        Route::resource('maintenance', MaintenanceController::class);
        Route::post('maintenance/{id}/complete', [MaintenanceController::class, 'complete'])->name('maintenance.complete');
        Route::get('damages', [MaintenanceController::class, 'damagesIndex'])->name('damages.index');
        Route::post('damages/{id}/update-status', [MaintenanceController::class, 'updateDamageStatus'])->name('damages.update-status');

        // Users Management
        Route::middleware(['super-admin'])->group(function () {
            Route::resource('users', UserController::class);
            Route::post('users/{id}/assign-role', [UserController::class, 'assignRole'])->name('users.assign-role');
            Route::post('users/{id}/change-branch', [UserController::class, 'changeBranch'])->name('users.change-branch');
            Route::post('users/{id}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
        });

        // Reports
        Route::controller(ReportController::class)->prefix('reports')->name('reports.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/revenue', 'revenue')->name('revenue');
            Route::get('/bookings', 'bookings')->name('bookings');
            Route::get('/vehicles', 'vehicles')->name('vehicles');
            Route::get('/drivers', 'drivers')->name('drivers');
            Route::post('/export', 'export')->name('export');
        });
    });
});

// Error Routes
Route::fallback(function () {
    return view('errors.404');
});

