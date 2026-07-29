<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ModuleRegistry
{
    /**
     * Scan admin controllers and auto-discover modules with their capabilities.
     */
    public static function discoverModules(): array
    {
        $modules = [];
        $controllerPath = app_path('Http/Controllers/Admin');

        if (!File::isDirectory($controllerPath)) {
            return $modules;
        }

        foreach (File::files($controllerPath) as $file) {
            if ($file->getExtension() !== 'php') continue;

            $className = 'App\\Http\\Controllers\\Admin\\' . $file->getFilenameWithoutExtension();

            if (!class_exists($className)) continue;

            // Skip non-CRUD controllers
            $skipControllers = [
                'LogViewerController',
                'BackupController',
                'ActivityLogController',
                'HealthController',
                'SessionController',
                'MaintenanceController',
            ];

            if (in_array($file->getFilenameWithoutExtension(), $skipControllers)) {
                // Still register these but with custom permissions
                $module = self::registerSpecialController($file->getFilenameWithoutExtension());
                if ($module) $modules[$module['slug']] = $module;
                continue;
            }

            $reflection = new \ReflectionClass($className);
            if ($reflection->isAbstract()) continue;

            $moduleName = $file->getFilenameWithoutExtension();
            $moduleSlug = Str::snake(Str::beforeLast($moduleName, 'Controller'));

            // Detect capabilities by checking method existence
            $capabilities = [];
            $reflectionMethods = array_map(fn($m) => $m->getName(), $reflection->getMethods(\ReflectionMethod::IS_PUBLIC));

            if (in_array('index', $reflectionMethods)) $capabilities[] = 'view';
            if (in_array('create', $reflectionMethods) || in_array('store', $reflectionMethods)) $capabilities[] = 'create';
            if (in_array('edit', $reflectionMethods) || in_array('update', $reflectionMethods)) $capabilities[] = 'edit';
            if (in_array('destroy', $reflectionMethods)) $capabilities[] = 'delete';

            if (empty($capabilities)) continue;

            $modules[$moduleSlug] = [
                'slug' => $moduleSlug,
                'name' => Str::headline(Str::beforeLast($moduleName, 'Controller')),
                'controller' => $className,
                'capabilities' => $capabilities,
                'route_prefix' => 'admin.' . $moduleSlug,
            ];
        }

        return $modules;
    }

    /**
     * Register special controllers (non-CRUD) with custom permissions.
     */
    private static function registerSpecialController(string $controllerName): ?array
    {
        return match ($controllerName) {
            'LogViewerController' => [
                'slug' => 'logs',
                'name' => 'Logs',
                'controller' => "App\\Http\\Controllers\\Admin\\{$controllerName}",
                'capabilities' => ['view', 'clear'],
                'route_prefix' => 'admin.logs',
            ],
            'BackupController' => [
                'slug' => 'backup',
                'name' => 'Backup',
                'controller' => "App\\Http\\Controllers\\Admin\\{$controllerName}",
                'capabilities' => ['view', 'create'],
                'route_prefix' => 'admin.backup',
            ],
            'ActivityLogController' => [
                'slug' => 'activity',
                'name' => 'Activity Log',
                'controller' => "App\\Http\\Controllers\\Admin\\{$controllerName}",
                'capabilities' => ['view', 'clear'],
                'route_prefix' => 'admin.activity-logs',
            ],
            'HealthController' => [
                'slug' => 'health',
                'name' => 'Health Dashboard',
                'controller' => "App\\Http\\Controllers\\Admin\\{$controllerName}",
                'capabilities' => ['view'],
                'route_prefix' => 'admin.health',
            ],
            'IpRestrictionController' => [
                'slug' => 'ip-restrictions',
                'name' => 'IP Restrictions',
                'controller' => "App\\Http\\Controllers\\Admin\\{$controllerName}",
                'capabilities' => ['view', 'edit'],
                'route_prefix' => 'admin.ip-restrictions',
            ],
            'SessionController' => [
                'slug' => 'sessions',
                'name' => 'Sessions',
                'controller' => "App\\Http\\Controllers\\Admin\\{$controllerName}",
                'capabilities' => ['view', 'revoke'],
                'route_prefix' => 'admin.sessions',
            ],
            'MaintenanceController' => [
                'slug' => 'maintenance',
                'name' => 'Maintenance',
                'controller' => "App\\Http\\Controllers\\Admin\\{$controllerName}",
                'capabilities' => ['view'],
                'route_prefix' => 'admin.maintenance',
            ],
            default => null,
        };
    }

    /**
     * Generate permission keys from discovered modules.
     * Returns ['module.action' => 'Label', ...]
     */
    public static function generatePermissions(): array
    {
        $modules = self::discoverModules();
        $permissions = [];

        foreach ($modules as $module) {
            $moduleName = Str::headline(Str::beforeLast(class_basename($module['controller']), 'Controller'));

            foreach ($module['capabilities'] as $capability) {
                $key = $module['slug'] . '.' . $capability;
                $label = ucfirst($capability) . ' ' . $moduleName;
                $permissions[$key] = $label;
            }
        }

        // Always include system-level permissions
        $permissions['settings.view'] = 'View Settings';
        $permissions['settings.edit'] = 'Edit Settings';
        $permissions['roles.view'] = 'View Roles';
        $permissions['roles.edit'] = 'Edit Roles';

        return $permissions;
    }

    /**
     * Get modules grouped by category for the admin panel.
     */
    public static function getGroupedPermissions(): array
    {
        $modules = self::discoverModules();
        $grouped = [];

        foreach ($modules as $module) {
            $groupName = $module['name'];
            $grouped[$groupName] = [];

            foreach ($module['capabilities'] as $capability) {
                $grouped[$groupName][$module['slug'] . '.' . $capability] = ucfirst($capability);
            }
        }

        // System settings
        $grouped['System']['settings.view'] = 'View Settings';
        $grouped['System']['settings.edit'] = 'Edit Settings';
        $grouped['System']['roles.view'] = 'View Roles';
        $grouped['System']['roles.edit'] = 'Edit Roles';

        return $grouped;
    }

    /**
     * Check if a module exists.
     */
    public static function moduleExists(string $slug): bool
    {
        return isset(self::discoverModules()[$slug]);
    }
}
