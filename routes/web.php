<?php

use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Mahasiswa;
use App\Http\Controllers\Umkm;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ─── Public ───────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');

Route::get('/design-system', function () {
    return view('design_system');
})->name('design-system');

// ─── Dashboard Redirect (role-based) ─────
Route::get('/dashboard', [DashboardRedirectController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ─── Breeze Profile Routes ───────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/profiles/{user}', [App\Http\Controllers\PublicProfileController::class, 'show'])->name('profiles.show');

    // Progress Messages (Shared between UMKM and Mahasiswa)
    Route::post('/progress/{progress}/messages', [\App\Http\Controllers\ProgressMessageController::class, 'store'])
        ->middleware('throttle:60,1')
        ->name('progress.messages.store');
    Route::get('/progress/{progress}/messages', [\App\Http\Controllers\ProgressMessageController::class, 'index'])->name('progress.messages.index');

    // Notifications
    Route::get('/notifications/unread', [\App\Http\Controllers\NotificationController::class, 'getUnread'])->name('notifications.unread');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.read-all');
});


// ═══════════════════════════════════════════
// ADMIN ROUTES
// ═══════════════════════════════════════════
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // User Management
        Route::get('/users', [Admin\UserManagementController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [Admin\UserManagementController::class, 'show'])->name('users.show');
        Route::post('/users/{user}/suspend', [Admin\UserManagementController::class, 'suspend'])->name('users.suspend');

        // Mission Moderation
        Route::get('/missions', [Admin\MissionModerationController::class, 'index'])->name('missions.index');
        Route::get('/missions/{mission}', [Admin\MissionModerationController::class, 'show'])->name('missions.show');
        Route::post('/missions/{mission}/approve', [Admin\MissionModerationController::class, 'approve'])->name('missions.approve');
        Route::post('/missions/{mission}/reject', [Admin\MissionModerationController::class, 'reject'])->name('missions.reject');
        Route::delete('/missions/{mission}', [Admin\MissionModerationController::class, 'destroy'])->name('missions.destroy');
    });

// ═══════════════════════════════════════════
// MAHASISWA ROUTES
// ═══════════════════════════════════════════
Route::middleware(['auth', 'verified', 'role:mahasiswa'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {
        Route::get('/dashboard', [Mahasiswa\DashboardController::class, 'index'])->name('dashboard');

        // Mission Browse
        Route::get('/missions', [Mahasiswa\MissionBrowseController::class, 'index'])->name('missions.browse');
        Route::get('/missions/{mission}', [Mahasiswa\MissionBrowseController::class, 'show'])->name('missions.show');

        // Applications
        Route::get('/applications', [Mahasiswa\ApplicationController::class, 'index'])->name('applications.index');
        Route::post('/applications', [Mahasiswa\ApplicationController::class, 'store'])->name('applications.store');

        // Progress
        Route::get('/progress/{progress}', [Mahasiswa\ProgressController::class, 'show'])->name('progress.show');
        Route::put('/progress/{progress}', [Mahasiswa\ProgressController::class, 'update'])->name('progress.update');
        Route::post('/progress/{progress}/submit-final', [Mahasiswa\ProgressController::class, 'submitFinal'])->name('progress.submit-final');

        // Portfolio
        Route::get('/portfolio', [Mahasiswa\PortfolioController::class, 'index'])->name('portfolio.index');
        Route::get('/portfolio/{portfolio}', [Mahasiswa\PortfolioController::class, 'show'])->name('portfolio.show');

        // Profile
        Route::get('/profile', [Mahasiswa\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [Mahasiswa\ProfileController::class, 'update'])->name('profile.update');
    });

// ═══════════════════════════════════════════
// UMKM ROUTES
// ═══════════════════════════════════════════
Route::middleware(['auth', 'verified', 'role:umkm'])
    ->prefix('umkm')
    ->name('umkm.')
    ->group(function () {
        Route::get('/dashboard', [Umkm\DashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('/profile', [Umkm\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [Umkm\ProfileController::class, 'update'])->name('profile.update');

        // Mission CRUD
        Route::resource('missions', Umkm\MissionController::class);

        // Applicant Management
        Route::get('/missions/{mission}/applicants', [Umkm\ApplicantController::class, 'index'])->name('missions.applicants');
        Route::post('/missions/{mission}/applicants/{application}/accept', [Umkm\ApplicantController::class, 'accept'])->name('applicants.accept');
        Route::post('/missions/{mission}/applicants/{application}/reject', [Umkm\ApplicantController::class, 'reject'])->name('applicants.reject');

        // Review & Approve
        Route::post('/progress/{progress}/request-revision', [Umkm\ReviewController::class, 'requestRevision'])->name('progress.revision');
        Route::post('/progress/{progress}/approve', [Umkm\ReviewController::class, 'approve'])->name('progress.approve');
        Route::post('/missions/{mission}/review', [Umkm\ReviewController::class, 'store'])->name('review.store');
    });

require __DIR__.'/auth.php';
