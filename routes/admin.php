<?php

use Illuminate\Support\Facades\Route;

// User-accessible routes (admin + user roles can view categories)
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin,user', 'ip-restrict'])
    ->group(function () {
        Route::get('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'show'])->name('categories.show');
    });

// Admin-only routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin', 'ip-restrict'])
    ->group(function () {

        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/categories/trashed', [\App\Http\Controllers\Admin\CategoryController::class, 'trashed'])->name('categories.trashed');
        Route::post('/categories/{id}/restore', [\App\Http\Controllers\Admin\CategoryController::class, 'restore'])->name('categories.restore')->withTrashed();
        Route::delete('/categories/{id}/force-delete', [\App\Http\Controllers\Admin\CategoryController::class, 'forceDelete'])->name('categories.force-delete')->withTrashed();
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['index', 'show']);

        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);

        Route::resource('contacts', \App\Http\Controllers\Admin\ContactController::class)->only(['index', 'show', 'destroy']);

        Route::get('/media', [\App\Http\Controllers\Admin\MediaController::class, 'index'])->name('media.index');
        Route::post('/media', [\App\Http\Controllers\Admin\MediaController::class, 'store'])->name('media.store');
        Route::delete('/media/{media}', [\App\Http\Controllers\Admin\MediaController::class, 'destroy'])->name('media.destroy');

        Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
        Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'store'])->name('settings.store');
        Route::delete('/settings/{setting}', [\App\Http\Controllers\Admin\SettingController::class, 'destroy'])->name('settings.destroy');

        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class)->except(['show']);

        Route::resource('tags', \App\Http\Controllers\Admin\TagController::class)->except(['show']);

        Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
        Route::get('/activity-logs/export', [\App\Http\Controllers\Admin\ActivityLogController::class, 'export'])->name('activity-logs.export');
        Route::delete('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'destroy'])->name('activity-logs.destroy');

        Route::get('/ip-restrictions', [\App\Http\Controllers\Admin\IpRestrictionController::class, 'index'])->name('ip-restrictions.index');
        Route::put('/ip-restrictions', [\App\Http\Controllers\Admin\IpRestrictionController::class, 'update'])->name('ip-restrictions.update');

        Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/read-all', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
        Route::post('/notifications/{notification}/read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::delete('/notifications/{notification}', [\App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');

        Route::get('/subscribers', [\App\Http\Controllers\Admin\SubscriberController::class, 'index'])->name('subscribers.index');
        Route::get('/subscribers/export', [\App\Http\Controllers\Admin\SubscriberController::class, 'export'])->name('subscribers.export');
        Route::delete('/subscribers/{subscriber}', [\App\Http\Controllers\Admin\SubscriberController::class, 'destroy'])->name('subscribers.destroy');

        Route::get('/sessions', [\App\Http\Controllers\Admin\SessionController::class, 'index'])->name('sessions.index');
        Route::delete('/sessions/{id}', [\App\Http\Controllers\Admin\SessionController::class, 'destroy'])->name('sessions.destroy');

        Route::get('/maintenance', [\App\Http\Controllers\Admin\MaintenanceController::class, 'index'])->name('maintenance.index');
        Route::post('/maintenance/toggle', [\App\Http\Controllers\Admin\MaintenanceController::class, 'toggle'])->name('maintenance.toggle');
        Route::put('/maintenance/message', [\App\Http\Controllers\Admin\MaintenanceController::class, 'updateMessage'])->name('maintenance.message');
        Route::put('/maintenance/bypass-routes', [\App\Http\Controllers\Admin\MaintenanceController::class, 'updateBypassRoutes'])->name('maintenance.bypass-routes');

        Route::get('/health', [\App\Http\Controllers\Admin\HealthController::class, 'index'])->name('health.index');

        Route::get('/logs', [\App\Http\Controllers\Admin\LogViewerController::class, 'index'])->name('logs.index');
        Route::delete('/logs', [\App\Http\Controllers\Admin\LogViewerController::class, 'clear'])->name('logs.clear');
        Route::get('/logs/download', [\App\Http\Controllers\Admin\LogViewerController::class, 'download'])->name('logs.download');

        Route::get('/backup', [\App\Http\Controllers\Admin\BackupController::class, 'index'])->name('backup.index');
        Route::post('/backup', [\App\Http\Controllers\Admin\BackupController::class, 'create'])->name('backup.create');
        Route::get('/backup/{filename}', [\App\Http\Controllers\Admin\BackupController::class, 'download'])->name('backup.download');
        Route::delete('/backup/{filename}', [\App\Http\Controllers\Admin\BackupController::class, 'destroy'])->name('backup.destroy');
    });
