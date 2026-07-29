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
                            @php
                                $label = ucfirst(str_replace('_', ' ', $setting->key));
                                $key = $setting->key;
                            @endphp
                            <label for="settings_{{ $key }}" class="form-label fw-medium">{{ $label }}</label>

                            @if ($key === 'mail_driver')
                                <select class="form-select" id="settings_{{ $key }}" name="settings[{{ $key }}]">
                                    <option value="log" {{ $setting->value === 'log' ? 'selected' : '' }}>Log (development)</option>
                                    <option value="smtp" {{ $setting->value === 'smtp' ? 'selected' : '' }}>SMTP</option>
                                    <option value="sendmail" {{ $setting->value === 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                    <option value="ses" {{ $setting->value === 'ses' ? 'selected' : '' }}>Amazon SES</option>
                                    <option value="postmark" {{ $setting->value === 'postmark' ? 'selected' : '' }}>Postmark</option>
                                    <option value="mailgun" {{ $setting->value === 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                </select>
                            @elseif ($key === 'mail_encryption')
                                <select class="form-select" id="settings_{{ $key }}" name="settings[{{ $key }}]">
                                    <option value="">{{ __('None') }}</option>
                                    <option value="tls" {{ $setting->value === 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="ssl" {{ $setting->value === 'ssl' ? 'selected' : '' }}>SSL</option>
                                </select>
                            @elseif ($key === 'mail_password')
                                <input type="password" class="form-control" id="settings_{{ $key }}" name="settings[{{ $key }}]" value="{{ $setting->value }}" autocomplete="off">
                            @elseif ($key === 'mail_additional_emails')
                                <div id="additional-emails-container">
                                    @php $additionalEmails = json_decode($setting->value ?: '[]', true); @endphp
                                    @forelse ($additionalEmails as $i => $entry)
                                        <div class="row g-2 mb-2 additional-email-row">
                                            <div class="col-5">
                                                <input type="text" class="form-control" name="settings[mail_additional_emails][{{ $i }}][name]" value="{{ $entry['name'] ?? '' }}" placeholder="{{ __('Name') }}">
                                            </div>
                                            <div class="col-5">
                                                <input type="email" class="form-control" name="settings[mail_additional_emails][{{ $i }}][address]" value="{{ $entry['address'] ?? '' }}" placeholder="{{ __('Email') }}">
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="btn btn-outline-danger w-100 remove-email-row"><i class="bi bi-x"></i></button>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-muted" style="font-size:0.875rem;" id="no-additional-emails">{{ __('No additional from addresses configured.') }}</p>
                                    @endforelse
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-email-row">
                                    <i class="bi bi-plus-circle me-1"></i>{{ __('Add Email Address') }}
                                </button>
                                <template id="email-row-template">
                                    <div class="row g-2 mb-2 additional-email-row">
                                        <div class="col-5">
                                            <input type="text" class="form-control" name="settings[mail_additional_emails][__INDEX__][name]" placeholder="{{ __('Name') }}">
                                        </div>
                                        <div class="col-5">
                                            <input type="email" class="form-control" name="settings[mail_additional_emails][__INDEX__][address]" placeholder="{{ __('Email') }}">
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger w-100 remove-email-row"><i class="bi bi-x"></i></button>
                                        </div>
                                    </div>
                                </template>
                            @elseif ($setting->type === 'textarea')
                                <textarea class="form-control" id="settings_{{ $key }}" name="settings[{{ $key }}]" rows="3">{{ $setting->value }}</textarea>
                            @elseif ($setting->type === 'boolean')
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="settings[{{ $key }}]" value="1" id="settings_{{ $key }}" {{ $setting->value ? 'checked' : '' }}>
                                    <label class="form-check-label" for="settings_{{ $key }}">{{ __('Enabled') }}</label>
                                </div>
                            @elseif ($setting->type === 'number')
                                <input type="number" class="form-control" id="settings_{{ $key }}" name="settings[{{ $key }}]" value="{{ $setting->value }}">
                            @elseif ($setting->type === 'json')
                                <textarea class="form-control font-monospace" id="settings_{{ $key }}" name="settings[{{ $key }}]" rows="3">{{ $setting->value }}</textarea>
                            @else
                                <input type="text" class="form-control" id="settings_{{ $key }}" name="settings[{{ $key }}]" value="{{ $setting->value }}">
                            @endif

                            @if ($key === 'mail_driver')
                                <small class="text-muted">{{ __('Select "Log" for development (emails written to log file), SMTP for production.') }}</small>
                            @elseif ($key === 'mail_password')
                                <small class="text-muted">{{ __('Leave empty to keep the current password.') }}</small>
                            @elseif ($key === 'mail_additional_emails')
                                <small class="text-muted">{{ __('Additional from addresses available when sending emails.') }}</small>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('additional-emails-container');
        const addBtn = document.getElementById('add-email-row');
        const template = document.getElementById('email-row-template');

        if (addBtn && template) {
            let index = container?.querySelectorAll('.additional-email-row').length || 0;

            addBtn.addEventListener('click', function() {
                const noEmails = document.getElementById('no-additional-emails');
                if (noEmails) noEmails.remove();

                const html = template.innerHTML.replace(/__INDEX__/g, index++);
                const div = document.createElement('div');
                div.innerHTML = html;
                container?.appendChild(div.firstElementChild);
            });
        }

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-email-row')) {
                const row = e.target.closest('.additional-email-row');
                if (row) row.remove();
            }
        });
    });
</script>
@endpush
</x-app-layout>
