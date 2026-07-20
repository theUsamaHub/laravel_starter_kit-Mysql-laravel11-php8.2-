<section>
    <header>
        <h5 class="fw-semibold text-danger">{{ __('Delete Account') }}</h5>
        <p class="text-muted mb-0" style="font-size: 0.875rem;">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="mt-3"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div class="modal-header">
            <h5 class="modal-title fw-semibold">{{ __('Are you sure you want to delete your account?') }}</h5>
        </div>
        <div class="modal-body">
            <p class="text-muted" style="font-size: 0.875rem;">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-3">
                <x-input-label for="password" value="{{ __('Password') }}" class="visually-hidden" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control"
                    placeholder="{{ __('Password') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1" />
            </div>
        </div>
        <div class="modal-footer">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>
            <x-danger-button class="ms-2">
                {{ __('Delete Account') }}
            </x-danger-button>
        </div>
    </x-modal>
</section>
