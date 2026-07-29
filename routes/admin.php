<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {

        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::get('/categories/trashed', [\App\Http\Controllers\Admin\CategoryController::class, 'trashed'])->name('categories.trashed');
        Route::post('/categories/{id}/restore', [\App\Http\Controllers\Admin\CategoryController::class, 'restore'])->name('categories.restore')->withTrashed();
        Route::delete('/categories/{id}/force-delete', [\App\Http\Controllers\Admin\CategoryController::class, 'forceDelete'])->name('categories.force-delete')->withTrashed();
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
        Route::resource('contacts', \App\Http\Controllers\Admin\ContactController::class)->only(['index', 'show', 'destroy']);

        // Media
        Route::get('/media', [\App\Http\Controllers\Admin\MediaController::class, 'index'])->name('media.index');
        Route::post('/media', [\App\Http\Controllers\Admin\MediaController::class, 'store'])->name('media.store');
        Route::delete('/media/{media}', [\App\Http\Controllers\Admin\MediaController::class, 'destroy'])->name('media.destroy');

        // Validation Rules
        Route::resource('validation-rules', \App\Http\Controllers\Admin\ValidationRuleController::class);

        // Settings
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
        Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'store'])->name('settings.store');
        Route::delete('/settings/{setting}', [\App\Http\Controllers\Admin\SettingController::class, 'destroy'])->name('settings.destroy');

        // Roles & Permissions
        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class)->except(['show']);

        // Tags
        Route::resource('tags', \App\Http\Controllers\Admin\TagController::class)->except(['show']);

        // Activity Log
        Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
        Route::delete('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'destroy'])->name('activity-logs.destroy');

        // Maintenance Mode
        Route::get('/maintenance', [\App\Http\Controllers\Admin\MaintenanceController::class, 'index'])->name('maintenance.index');
        Route::post('/maintenance/toggle', [\App\Http\Controllers\Admin\MaintenanceController::class, 'toggle'])->name('maintenance.toggle');
        Route::put('/maintenance/message', [\App\Http\Controllers\Admin\MaintenanceController::class, 'updateMessage'])->name('maintenance.message');
        Route::put('/maintenance/bypass-routes', [\App\Http\Controllers\Admin\MaintenanceController::class, 'updateBypassRoutes'])->name('maintenance.bypass-routes');

        // Health Dashboard
        Route::get('/health', [\App\Http\Controllers\Admin\HealthController::class, 'index'])->name('health.index');

        // Log Viewer
        Route::get('/logs', [\App\Http\Controllers\Admin\LogViewerController::class, 'index'])->name('logs.index');
        Route::delete('/logs', [\App\Http\Controllers\Admin\LogViewerController::class, 'clear'])->name('logs.clear');
        Route::get('/logs/download', [\App\Http\Controllers\Admin\LogViewerController::class, 'download'])->name('logs.download');

        // Database Backup
        Route::get('/backup', [\App\Http\Controllers\Admin\BackupController::class, 'index'])->name('backup.index');
        Route::post('/backup', [\App\Http\Controllers\Admin\BackupController::class, 'create'])->name('backup.create');
        Route::get('/backup/{filename}', [\App\Http\Controllers\Admin\BackupController::class, 'download'])->name('backup.download');
        Route::delete('/backup/{filename}', [\App\Http\Controllers\Admin\BackupController::class, 'destroy'])->name('backup.destroy');
    });
