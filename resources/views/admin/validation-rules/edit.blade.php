<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('Edit Validation Rules') }} — <code>{{ $rule->form_name }}</code></h2>
            <a href="{{ route('admin.validation-rules.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>{{ __('Back') }}
            </a>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('admin.validation-rules.update', $rule) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <x-input-label :value="__('Form Name')" />
                            <div class="form-control bg-light">{{ $rule->form_name }}</div>
                            <small class="text-muted">{{ __('Form name cannot be changed.') }}</small>
                        </div>

                        <div class="mb-3">
                            <x-input-label for="rules" :value="__('Validation Rules (JSON)')" />
                            <textarea id="rules" name="rules" class="form-control font-monospace" rows="8" required>{{ json_encode($rule->rules, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</textarea>
                            <small class="text-muted">{{ __('JSON object where keys are field names and values are arrays of rule strings.') }}</small>
                            <x-input-error :messages="$errors->get('rules')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="custom_messages" :value="__('Custom Error Messages (JSON, optional)')" />
                            <textarea id="custom_messages" name="custom_messages" class="form-control font-monospace" rows="4">{{ $rule->custom_messages ? json_encode($rule->custom_messages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '' }}</textarea>
                            <x-input-error :messages="$errors->get('custom_messages')" class="mt-1" />
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.validation-rules.index') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
                            <x-primary-button>{{ __('Update Rules') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 fw-semibold">{{ __('Current Rules') }}</h6>
                </div>
                <div class="card-body">
                    @foreach ($rule->rules as $field => $fieldRules)
                        <div class="mb-2">
                            <strong style="font-size: 0.875rem;">{{ $field }}</strong>
                            <div><code style="font-size: 0.75rem;">{{ implode(' | ', $fieldRules) }}</code></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
