<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'ip-restrict'])
    ->group(function () {

        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Categories
        Route::get('/categories/trashed', [\App\Http\Controllers\Admin\CategoryController::class, 'trashed'])->name('categories.trashed')->middleware('permission:category.view');
        Route::post('/categories/{id}/restore', [\App\Http\Controllers\Admin\CategoryController::class, 'restore'])->name('categories.restore')->withTrashed()->middleware('permission:category.edit');
        Route::delete('/categories/{id}/force-delete', [\App\Http\Controllers\Admin\CategoryController::class, 'forceDelete'])->name('categories.force-delete')->withTrashed()->middleware('permission:category.delete');
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->middleware([
            'index' => 'permission:category.view',
            'create' => 'permission:category.create',
            'store' => 'permission:category.create',
            'show' => 'permission:category.view',
            'edit' => 'permission:category.edit',
            'update' => 'permission:category.edit',
            'destroy' => 'permission:category.delete',
        ]);

        // Users
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'show', 'edit', 'update', 'destroy'])->middleware([
            'index' => 'permission:user.view',
            'show' => 'permission:user.view',
            'edit' => 'permission:user.edit',
            'update' => 'permission:user.edit',
            'destroy' => 'permission:user.delete',
        ]);

        // Contacts
        Route::resource('contacts', \App\Http\Controllers\Admin\ContactController::class)->only(['index', 'show', 'destroy'])->middleware([
            'index' => 'permission:contact.view',
            'show' => 'permission:contact.view',
            'destroy' => 'permission:contact.delete',
        ]);

        // Media
        Route::get('/media', [\App\Http\Controllers\Admin\MediaController::class, 'index'])->name('media.index')->middleware('permission:media.view');
        Route::post('/media', [\App\Http\Controllers\Admin\MediaController::class, 'store'])->name('media.store')->middleware('permission:media.create');
        Route::delete('/media/{media}', [\App\Http\Controllers\Admin\MediaController::class, 'destroy'])->name('media.destroy')->middleware('permission:media.delete');

        // Validation Rules
        Route::resource('validation-rules', \App\Http\Controllers\Admin\ValidationRuleController::class)->middleware([
            'index' => 'permission:validation_rule.view',
            'create' => 'permission:validation_rule.create',
            'store' => 'permission:validation_rule.create',
            'show' => 'permission:validation_rule.view',
            'edit' => 'permission:validation_rule.edit',
            'update' => 'permission:validation_rule.edit',
            'destroy' => 'permission:validation_rule.delete',
        ]);

        // Settings
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index')->middleware('permission:setting.view');
        Route::put('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update')->middleware('permission:setting.edit');
        Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'store'])->name('settings.store')->middleware('permission:setting.edit');
        Route::delete('/settings/{setting}', [\App\Http\Controllers\Admin\SettingController::class, 'destroy'])->name('settings.destroy')->middleware('permission:setting.delete');

        // Roles & Permissions
        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class)->except(['show'])->middleware([
            'index' => 'permission:role.view',
            'create' => 'permission:role.create',
            'store' => 'permission:role.create',
            'edit' => 'permission:role.edit',
            'update' => 'permission:role.edit',
            'destroy' => 'permission:role.delete',
        ]);

        // Tags
        Route::resource('tags', \App\Http\Controllers\Admin\TagController::class)->except(['show'])->middleware([
            'index' => 'permission:tag.view',
            'create' => 'permission:tag.create',
            'store' => 'permission:tag.create',
            'edit' => 'permission:tag.edit',
            'update' => 'permission:tag.edit',
            'destroy' => 'permission:tag.delete',
        ]);

        // Activity Log
        Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index')->middleware('permission:activity.view');
        Route::get('/activity-logs/export', [\App\Http\Controllers\Admin\ActivityLogController::class, 'export'])->name('activity-logs.export')->middleware('permission:activity.view');
        Route::delete('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'destroy'])->name('activity-logs.destroy')->middleware('permission:activity.clear');

        // IP Restrictions
        Route::get('/ip-restrictions', [\App\Http\Controllers\Admin\IpRestrictionController::class, 'index'])->name('ip-restrictions.index')->middleware('permission:ip_restriction.view');
        Route::put('/ip-restrictions', [\App\Http\Controllers\Admin\IpRestrictionController::class, 'update'])->name('ip-restrictions.update')->middleware('permission:ip_restriction.edit');

        // Notifications
        Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index')->middleware('permission:notification.view');
        Route::post('/notifications/read-all', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all')->middleware('permission:notification.view');
        Route::post('/notifications/{notification}/read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.read')->middleware('permission:notification.view');
        Route::delete('/notifications/{notification}', [\App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('notifications.destroy')->middleware('permission:notification.view');

        // Subscribers
        Route::get('/subscribers', [\App\Http\Controllers\Admin\SubscriberController::class, 'index'])->name('subscribers.index')->middleware('permission:subscriber.view');
        Route::get('/subscribers/export', [\App\Http\Controllers\Admin\SubscriberController::class, 'export'])->name('subscribers.export')->middleware('permission:subscriber.view');
        Route::delete('/subscribers/{subscriber}', [\App\Http\Controllers\Admin\SubscriberController::class, 'destroy'])->name('subscribers.destroy')->middleware('permission:subscriber.delete');

        // Sessions
        Route::get('/sessions', [\App\Http\Controllers\Admin\SessionController::class, 'index'])->name('sessions.index')->middleware('permission:sessions.view');
        Route::delete('/sessions/{id}', [\App\Http\Controllers\Admin\SessionController::class, 'destroy'])->name('sessions.destroy')->middleware('permission:sessions.revoke');

        // Maintenance Mode
        Route::get('/maintenance', [\App\Http\Controllers\Admin\MaintenanceController::class, 'index'])->name('maintenance.index')->middleware('permission:maintenance.view');
        Route::post('/maintenance/toggle', [\App\Http\Controllers\Admin\MaintenanceController::class, 'toggle'])->name('maintenance.toggle')->middleware('permission:maintenance.view');
        Route::put('/maintenance/message', [\App\Http\Controllers\Admin\MaintenanceController::class, 'updateMessage'])->name('maintenance.message')->middleware('permission:maintenance.view');
        Route::put('/maintenance/bypass-routes', [\App\Http\Controllers\Admin\MaintenanceController::class, 'updateBypassRoutes'])->name('maintenance.bypass-routes')->middleware('permission:maintenance.view');

        // Health Dashboard
        Route::get('/health', [\App\Http\Controllers\Admin\HealthController::class, 'index'])->name('health.index')->middleware('permission:health.view');

        // Log Viewer
        Route::get('/logs', [\App\Http\Controllers\Admin\LogViewerController::class, 'index'])->name('logs.index')->middleware('permission:logs.view');
        Route::delete('/logs', [\App\Http\Controllers\Admin\LogViewerController::class, 'clear'])->name('logs.clear')->middleware('permission:logs.clear');
        Route::get('/logs/download', [\App\Http\Controllers\Admin\LogViewerController::class, 'download'])->name('logs.download')->middleware('permission:logs.view');

        // Database Backup
        Route::get('/backup', [\App\Http\Controllers\Admin\BackupController::class, 'index'])->name('backup.index')->middleware('permission:backup.view');
        Route::post('/backup', [\App\Http\Controllers\Admin\BackupController::class, 'create'])->name('backup.create')->middleware('permission:backup.create');
        Route::get('/backup/{filename}', [\App\Http\Controllers\Admin\BackupController::class, 'download'])->name('backup.download')->middleware('permission:backup.view');
        Route::delete('/backup/{filename}', [\App\Http\Controllers\Admin\BackupController::class, 'destroy'])->name('backup.destroy')->middleware('permission:backup.view');
    });
