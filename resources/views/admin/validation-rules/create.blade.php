<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('Add Validation Rule') }}</h2>
            <a href="{{ route('admin.validation-rules.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>{{ __('Back') }}
            </a>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('admin.validation-rules.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <x-input-label for="form_name" :value="__('Form Name')" />
                            <x-text-input id="form_name" name="form_name" type="text" class="form-control" :value="old('form_name')" placeholder="e.g., category_create, contact_form, user_register" required />
                            <small class="text-muted">{{ __('Unique identifier for this form. If it exists, new fields will be added to it.') }}</small>
                            <x-input-error :messages="$errors->get('form_name')" class="mt-1" />
                        </div>

                        <div class="mb-3">
                            <x-input-label for="field_name" :value="__('Field Name')" />
                            <x-text-input id="field_name" name="field_name" type="text" class="form-control" :value="old('field_name')" placeholder="e.g., email, name, phone" required />
                            <x-input-error :messages="$errors->get('field_name')" class="mt-1" />
                        </div>

                        <div class="mb-3">
                            <x-input-label for="rules" :value="__('Validation Rules')" />
                            <x-text-input id="rules" name="rules" type="text" class="form-control" :value="old('rules')" placeholder="e.g., required|string|max:255|email" required />
                            <small class="text-muted">{{ __('Separate rules with pipe (|) character.') }}</small>
                            <x-input-error :messages="$errors->get('rules')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="custom_messages" :value="__('Custom Error Messages (optional)')" />
                            <textarea id="custom_messages" name="custom_messages" class="form-control" rows="4" placeholder="{{ __('One per line, format: field.rule:Message text') }}{{ chr(10) }}e.g.{{ chr(10) }}email.required:Email is required{{ chr(10) }}email.email:Please enter a valid email address">{{ old('custom_messages') }}</textarea>
                            <x-input-error :messages="$errors->get('custom_messages')" class="mt-1" />
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.validation-rules.index') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
                            <x-primary-button>{{ __('Save Rule') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 fw-semibold">{{ __('Available Rules') }}</h6>
                </div>
                <div class="card-body">
                    <div style="font-size: 0.875rem;">
                        <div class="mb-2"><code>required</code> — {{ __('Field is required') }}</div>
                        <div class="mb-2"><code>string</code> — {{ __('Must be a string') }}</div>
                        <div class="mb-2"><code>email</code> — {{ __('Must be a valid email') }}</div>
                        <div class="mb-2"><code>max:255</code> — {{ __('Maximum length') }}</div>
                        <div class="mb-2"><code>min:3</code> — {{ __('Minimum length') }}</div>
                        <div class="mb-2"><code>numeric</code> — {{ __('Must be a number') }}</div>
                        <div class="mb-2"><code>boolean</code> — {{ __('Must be true/false') }}</div>
                        <div class="mb-2"><code>date</code> — {{ __('Must be a valid date') }}</div>
                        <div class="mb-2"><code>url</code> — {{ __('Must be a valid URL') }}</div>
                        <div class="mb-2"><code>alpha</code> — {{ __('Letters only') }}</div>
                        <div class="mb-2"><code>alpha_dash</code> — {{ __('Letters, numbers, dashes') }}</div>
                        <div class="mb-2"><code>mimes:jpg,png</code> — {{ __('File type restriction') }}</div>
                        <div class="mb-0"><code>unique:table,column</code> — {{ __('Must be unique in database') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
