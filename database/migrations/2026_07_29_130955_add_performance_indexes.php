<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Categories
        Schema::table('categories', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order', 'name']);
            $table->index(['is_active', 'published_at']);
            $table->index(['is_active', 'unpublish_at']);
            $table->index(['deleted_at', 'is_active']);
            $table->index('sort_order');
            $table->index('published_at');
            $table->index('unpublish_at');
        });

        // Contacts
        Schema::table('contacts', function (Blueprint $table) {
            $table->index('status');
            $table->index('created_at');
            $table->index(['status', 'created_at']);
            $table->index('email');
        });

        // Media
        Schema::table('media', function (Blueprint $table) {
            $table->index('mime_type');
            $table->index('name');
            $table->index('original_name');
            $table->index(['mime_type', 'created_at']);
        });

        // Activity Logs
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->index('created_at');
            $table->index(['event', 'created_at']);
            $table->index(['user_id', 'created_at']);
        });

        // Subscribers
        Schema::table('subscribers', function (Blueprint $table) {
            $table->index('subscribed_at');
            $table->index('unsubscribed_at');
            $table->index(['subscribed_at', 'unsubscribed_at']);
        });

        // Notifications
        Schema::table('notifications', function (Blueprint $table) {
            $table->index('read_at');
            $table->index(['notifiable_type', 'notifiable_id', 'read_at'], 'notif_type_id_read_index');
        });

        // Settings
        Schema::table('settings', function (Blueprint $table) {
            $table->index('group');
        });

        // Sessions
        Schema::table('sessions', function (Blueprint $table) {
            $table->index('ip_address');
        });

        // Tags
        Schema::table('tags', function (Blueprint $table) {
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'sort_order', 'name']);
            $table->dropIndex(['is_active', 'published_at']);
            $table->dropIndex(['is_active', 'unpublish_at']);
            $table->dropIndex(['deleted_at', 'is_active']);
            $table->dropIndex(['sort_order']);
            $table->dropIndex(['published_at']);
            $table->dropIndex(['unpublish_at']);
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['email']);
        });

        Schema::table('media', function (Blueprint $table) {
            $table->dropIndex(['mime_type']);
            $table->dropIndex(['name']);
            $table->dropIndex(['original_name']);
            $table->dropIndex(['mime_type', 'created_at']);
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['event', 'created_at']);
            $table->dropIndex(['user_id', 'created_at']);
        });

        Schema::table('subscribers', function (Blueprint $table) {
            $table->dropIndex(['subscribed_at']);
            $table->dropIndex(['unsubscribed_at']);
            $table->dropIndex(['subscribed_at', 'unsubscribed_at']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['read_at']);
            $table->dropIndex('notif_type_id_read_index');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropIndex(['group']);
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->dropIndex(['ip_address']);
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->dropIndex(['name']);
        });
    }
};
