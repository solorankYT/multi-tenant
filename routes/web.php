<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\InitializeTenantByUser;
use App\Http\Controllers\TenantController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([InitializeTenantByUser::class, 'auth'])->group(function () {
    Route::get('/dashboard', function () {
        $tenantId = tenant('id');
        $tenantName = session('tenant_name');
        return Inertia::render('Dashboard', [
            'tenantId' => $tenantId,
            'tenantName' => $tenantName,
        ]);
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Management Routes
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create'); // Form to create a user
    Route::post('/users', [UserController::class, 'store'])->name('users.store'); // Submit user creation form
    Route::get('/users', [UserController::class, 'index'])->name('users.index'); // List users

    Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index'); // List tenants
    Route::get('/tenants/create', [TenantController::class, 'create'])->name('tenants.create'); // Form to create a tenant
    Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store'); // Submit tenant creation form
    Route::get('/tenants/{tenant}/edit', [TenantController::class, 'edit'])->name('tenants.edit'); // Edit tenant form
    Route::put('/tenants/{tenant}', [TenantController::class, 'update'])->name('tenants.update'); // Update tenant
    Route::delete('/tenants/{tenant}', [TenantController::class, 'destroy'])->name('tenants.destroy'); // Delete tenant

});


require __DIR__ . '/auth.php';
