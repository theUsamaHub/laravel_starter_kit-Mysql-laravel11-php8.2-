<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('Site Settings') }}</h2>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSettingModal">
                <i class="bi bi-plus-circle me-1"></i>{{ __('Add Setting') }}
            </button>
        </div>
    </x-slot>

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        @forelse ($grouped as $group => $items)
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0 fw-semibold text-capitalize">{{ str_replace('_', ' ', $group) }} {{ __('Settings') }}</h6>
                </div>
                <div class="card-body">
                    @foreach ($items as $setting)
                        <div class="mb-3">
                            <label for="settings_{{ $setting->key }}" class="form-label fw-medium">{{ ucfirst(str_replace('_', ' ', $setting->key)) }}</label>

                            @if ($setting->type === 'textarea')
                                <textarea class="form-control" id="settings_{{ $setting->key }}" name="settings[{{ $setting->key }}]" rows="3">{{ $setting->value }}</textarea>
                            @elseif ($setting->type === 'boolean')
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="settings[{{ $setting->key }}]" value="1" id="settings_{{ $setting->key }}" {{ $setting->value ? 'checked' : '' }}>
                                    <label class="form-check-label" for="settings_{{ $setting->key }}">{{ __('Enabled') }}</label>
                                </div>
                            @elseif ($setting->type === 'number')
                                <input type="number" class="form-control" id="settings_{{ $setting->key }}" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}">
                            @elseif ($setting->type === 'json')
                                <textarea class="form-control font-monospace" id="settings_{{ $setting->key }}" name="settings[{{ $setting->key }}]" rows="3">{{ $setting->value }}</textarea>
                            @else
                                <input type="text" class="form-control" id="settings_{{ $setting->key }}" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}">
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="card">
                <div class="card-body">
                    <div class="empty-state">
                        <i class="bi bi-gear"></i>
                        <p>{{ __('No settings configured yet.') }}</p>
                    </div>
                </div>
            </div>
        @endforelse

        @if ($grouped->count() > 0)
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>{{ __('Save All Settings') }}
                </button>
            </div>
        @endif
    </form>

    <!-- Add Setting Modal -->
    <div class="modal fade" id="addSettingModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.settings.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-semibold">{{ __('Add New Setting') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="group" class="form-label fw-medium">{{ __('Group') }}</label>
                            <input type="text" class="form-control" name="group" id="group" placeholder="e.g., general, seo, mail" required>
                        </div>
                        <div class="mb-3">
                            <label for="key" class="form-label fw-medium">{{ __('Key') }}</label>
                            <input type="text" class="form-control" name="key" id="key" placeholder="e.g., site_name, site_description" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label fw-medium">{{ __('Type') }}</label>
                            <select class="form-select" name="type" id="type" required>
                                <option value="text">Text</option>
                                <option value="textarea">Textarea</option>
                                <option value="number">Number</option>
                                <option value="boolean">Boolean (Toggle)</option>
                                <option value="image">Image</option>
                                <option value="json">JSON</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="value" class="form-label fw-medium">{{ __('Default Value') }}</label>
                            <input type="text" class="form-control" name="value" id="value">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Add Setting') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
