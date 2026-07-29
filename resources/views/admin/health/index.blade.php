<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 fw-semibold">{{ __('Health Dashboard') }}</h2>
    </x-slot>

    <div class="row g-3">
        <!-- PHP & Laravel -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header"><h6 class="mb-0 fw-semibold"><i class="bi bi-info-circle me-1"></i>{{ __('Application') }}</h6></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">{{ __('PHP Version') }}</dt>
                        <dd class="col-sm-7"><code>{{ $health['php_version'] }}</code></dd>
                        <dt class="col-sm-5">{{ __('Laravel Version') }}</dt>
                        <dd class="col-sm-7"><code>{{ $health['laravel_version'] }}</code></dd>
                        <dt class="col-sm-5">{{ __('Environment') }}</dt>
                        <dd class="col-sm-7"><span class="badge bg-{{ $health['environment'] === 'production' ? 'warning' : 'info' }}">{{ $health['environment'] }}</span></dd>
                        <dt class="col-sm-5">{{ __('Debug Mode') }}</dt>
                        <dd class="col-sm-7">
                            @if ($health['debug_enabled'])
                                <span class="badge bg-danger">{{ __('Enabled') }}</span>
                            @else
                                <span class="badge bg-success">{{ __('Disabled') }}</span>
                            @endif
                        </dd>
                        <dt class="col-sm-5">{{ __('App URL') }}</dt>
                        <dd class="col-sm-7"><code>{{ $health['url'] }}</code></dd>
                        <dt class="col-sm-5">{{ __('Timezone') }}</dt>
                        <dd class="col-sm-7">{{ $health['timezone'] }}</dd>
                        <dt class="col-sm-5">{{ __('Locale') }}</dt>
                        <dd class="col-sm-7">{{ $health['locale'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Database & Cache -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header"><h6 class="mb-0 fw-semibold"><i class="bi bi-database me-1"></i>{{ __('Services') }}</h6></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">{{ __('Database') }}</dt>
                        <dd class="col-sm-7">
                            @if ($health['database'] === 'connected')
                                <span class="badge bg-success">{{ __('Connected') }}</span>
                            @else
                                <span class="badge bg-danger">{{ $health['database'] }}</span>
                            @endif
                        </dd>
                        <dt class="col-sm-5">{{ __('Cache Driver') }}</dt>
                        <dd class="col-sm-7"><code>{{ $health['cache_driver'] }}</code></dd>
                        <dt class="col-sm-5">{{ __('Cache Reachable') }}</dt>
                        <dd class="col-sm-7">
                            @if ($health['cache_reachable'])
                                <span class="badge bg-success">{{ __('Yes') }}</span>
                            @else
                                <span class="badge bg-danger">{{ __('No') }}</span>
                            @endif
                        </dd>
                        <dt class="col-sm-5">{{ __('Queue') }}</dt>
                        <dd class="col-sm-7"><code>{{ $health['queue_connection'] }}</code></dd>
                        <dt class="col-sm-5">{{ __('Session Driver') }}</dt>
                        <dd class="col-sm-7"><code>{{ $health['session_driver'] }}</code></dd>
                        <dt class="col-sm-5">{{ __('Filesystem Disk') }}</dt>
                        <dd class="col-sm-7"><code>{{ $health['filesystem_disk'] }}</code></dd>
                        <dt class="col-sm-5">{{ __('Storage Link') }}</dt>
                        <dd class="col-sm-7">
                            @if ($health['public_storage_link'])
                                <span class="badge bg-success">{{ __('Exists') }}</span>
                            @else
                                <span class="badge bg-danger">{{ __('Missing') }}</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Storage -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header"><h6 class="mb-0 fw-semibold"><i class="bi bi-hdd me-1"></i>{{ __('Storage') }}</h6></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">{{ __('Total Space') }}</dt>
                        <dd class="col-sm-7">{{ $health['storage_total'] }}</dd>
                        <dt class="col-sm-5">{{ __('Free Space') }}</dt>
                        <dd class="col-sm-7">{{ $health['storage_free'] }}</dd>
                        <dt class="col-sm-5">{{ __('Usage') }}</dt>
                        <dd class="col-sm-7">
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height:6px;">
                                    <div class="progress-bar bg-{{ $health['storage_usage_pct'] > 80 ? 'danger' : ($health['storage_usage_pct'] > 60 ? 'warning' : 'success') }}" style="width:{{ $health['storage_usage_pct'] }};"></div>
                                </div>
                                <small>{{ $health['storage_usage_pct'] }}</small>
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Jobs & Queue -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header"><h6 class="mb-0 fw-semibold"><i class="bi bi-gear me-1"></i>{{ __('Jobs & Queue') }}</h6></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">{{ __('Failed Jobs') }}</dt>
                        <dd class="col-sm-7">
                            @if ($health['failed_jobs_count'] > 0)
                                <span class="badge bg-danger">{{ $health['failed_jobs_count'] }}</span>
                            @else
                                <span class="badge bg-success">{{ __('None') }}</span>
                            @endif
                        </dd>
                        <dt class="col-sm-5">{{ __('Jobs Table') }}</dt>
                        <dd class="col-sm-7">
                            @if ($health['jobs_table_exists'])
                                <span class="badge bg-success">{{ __('Exists') }}</span>
                            @else
                                <span class="badge bg-secondary">{{ __('Not Used') }}</span>
                            @endif
                        </dd>
                        <dt class="col-sm-5">{{ __('Queue Connection') }}</dt>
                        <dd class="col-sm-7"><code>{{ $health['queue_connection'] }}</code></dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- System -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header"><h6 class="mb-0 fw-semibold"><i class="bi bi-cpu me-1"></i>{{ __('System') }}</h6></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">{{ __('Server') }}</dt>
                        <dd class="col-sm-7"><code>{{ $health['server_software'] }}</code></dd>
                        <dt class="col-sm-5">{{ __('Uptime') }}</dt>
                        <dd class="col-sm-7">{{ $health['uptime'] }}</dd>
                        <dt class="col-sm-5">{{ __('Memory Usage') }}</dt>
                        <dd class="col-sm-7">{{ $health['memory_usage'] }}</dd>
                        <dt class="col-sm-5">{{ __('Peak Memory') }}</dt>
                        <dd class="col-sm-7">{{ $health['peak_memory'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
