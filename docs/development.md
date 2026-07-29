# Development Guide

## Coding Standards

This project follows **PSR-12** coding standards with Laravel Pint for automatic formatting.

```bash
./vendor/bin/pint
```

## Available Artisan Commands

| Command | Description |
|---------|-------------|
| `app:process-scheduled-publishing` | Publish/unpublish categories based on schedule |
| `make:filament-user` | Create a Filament user (legacy, not used) |
| `queue:listen` | Process queued jobs |
| `schedule:work` | Run scheduler every minute (dev) |

## Key Models Reference

| Model | Table | Traits | Key Relationships |
|-------|-------|--------|-------------------|
| `User` | `users` | `HasApiTokens, HasFactory, Notifiable, HasRoles` | `roles()` BelongsToMany |
| `Role` | `roles` | `LogsActivity` | `users()` BelongsToMany |
| `Category` | `categories` | `HasFactory, SoftDeletes, HasMedia, HasTags, LogsActivity` | `createdBy()`, `updatedBy()` BelongsTo User |
| `Contact` | `contacts` | `HasFactory` | — |
| `Media` | `media` | — | `mediable()` MorphTo, `createdBy()` BelongsTo User |
| `Setting` | `settings` | — | — |
| `ActivityLog` | `activity_logs` | — | `user()` BelongsTo User, `auditable()` MorphTo |
| `Subscriber` | `subscribers` | — | — |
| `Tag` | `tags` | — | `categories()` MorphToMany |
| `Notification` | `notifications` | `Notifiable` | — |

## Available Services

### CategoryService
```php
$service = app(\App\Services\CategoryService::class);
$service->getPaginated($filters, $perPage);  // Paginated listing with filters
$service->getAll();                           // All active categories
$service->getById($id);                       // Single with relations
$service->create($data);                      // Create with auto future-date logic
$service->update($category, $data);           // Update with same logic
$service->delete($category);                  // Soft delete
$service->restore($id);                       // Restore soft-deleted
$service->forceDelete($id);                   // Permanently delete
$service->count();                            // Cached count
```

### FileUploadService
```php
$service = app(\App\Services\FileUploadService::class);
$service->upload($file, $model, $collection);       // Single file upload
$service->uploadMultiple($files, $model, $collection); // Multiple files
$service->delete($media);                             // Delete a media record + file
$service->getValidationRules($type);                  // Get validation rules per file type
```

### DynamicValidationService
```php
DynamicValidationService::getRules('form_name', $baseRules);      // Merge DB rules with base
DynamicValidationService::getMessages('form_name');               // Get custom messages
DynamicValidationService::getFormNames();                         // List all form names
DynamicValidationService::getFormFields('form_name');             // Get field definitions
```

### ModuleRegistry
```php
ModuleRegistry::discoverModules();              // Auto-discover admin controllers (cached)
ModuleRegistry::generatePermissions();          // Generate permission keys (cached)
ModuleRegistry::getGroupedPermissions();        // Grouped for UI display (cached)
ModuleRegistry::moduleExists('categories');     // Check if module exists
```

## Traits Reference

### HasRoles (User)
```php
$user->hasRole('admin');        // Check single role
$user->hasAnyRole(['admin', 'moderator']); // Check multiple
$user->assignRole('editor');    // Assign single role
$user->removeRole('editor');    // Remove single role
// For bulk assignment:
$user->roles()->sync($roleIds); // Sync multiple roles (2 queries)
```

### HasMedia (any model)
```php
$model->addMedia($file);                // Upload and attach
$model->addMediaFromRequest('image');   // Upload from request
$model->getFirstMedia($type = null);    // Get most recent media
$model->getImages();                    // Get only image-type media
$model->getFiles();                     // Get only non-image media
$model->media();                        // MorphMany relation
$model->clearMedia();                   // Delete all media
$model->removeMedia($media);            // Delete specific media
```

### HasTags (any model)
```php
$model->attachTags(['tag1', 'tag2']);   // Attach by name (auto-creates)
$model->detachTags(['tag1']);           // Detach by name
$model->syncTags(['tag1', 'tag3']);     // Sync by name (auto-creates)
$model->tags();                          // MorphToMany relation
```

### LogsActivity
```php
// Auto-logs on created, updated, deleted events.
// Logs store: user_id, event, old_values, new_values, ip_address, user_agent
```

### HasSlug
```php
// Auto-generates slug from 'name' field on creating and updating
```

## Helper Functions

```php
generate_slug(string $text): string                    // URL-safe slug
format_date($date, string $format = 'M d, Y'): string  // Carbon formatting
time_ago($date): string                                // Human-readable relative time
get_initials(string $name): string                     // First 2 uppercase initials
truncate_text(string $text, int $length = 100): string // Truncate with ellipsis
```

## Notifications

### Creating a notification
```php
php artisan make:notification InvoicePaid
```

### Channels
- `mail` — Email notification (use `ShouldQueue` for async)
- `database` — In-app notification (bell dropdown)

### Dispatching
```php
// Synchronous (immediate in-app delivery):
$user->notify(new ContactFormNotification(...));

// Queued (requires running queue worker):
$user->notify(new WelcomeNotification(...)); // Implements ShouldQueue
```

## Data Caching Strategy

| Cache Key | TTL | Invalidated When |
|-----------|-----|-----------------|
| `settings` | 3600s | Setting created/updated/deleted |
| `categories.count` | 3600s | Category created/updated/deleted/restored |
| `categories.active` | 3600s | Same as above |
| `module_registry.modules` | Forever | Never (controllers don't change at runtime) |
| `validation_rule.{form}` | 3600s | ValidationRule saved/deleted |
| `contacts.new_count` | 60s | Time-based |
| `notifications.unread.{id}` | 60s | Time-based |
| `notifications.recent.{id}` | 60s | Time-based |

## Performance Notes

- All admin pages use eager loading for relationships — N+1 is prevented everywhere
- Stats pages use aggregated SQL with `CASE WHEN` instead of multiple count() calls
- Exports use `chunk(200)` instead of loading all rows into memory
- The `Setting::get()` method requires zero DB queries after first cache fill
- 25+ database indexes cover all common query patterns (composite indexes for status+date, etc.)
