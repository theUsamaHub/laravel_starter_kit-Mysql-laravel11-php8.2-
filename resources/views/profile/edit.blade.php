<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 fw-semibold">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body p-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body p-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card border-danger">
                <div class="card-body p-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body p-4">
                    <h6 class="card-title fw-semibold">{{ __('Profile Summary') }}</h6>
                    <hr>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                            <span class="text-white fw-bold fs-4">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div class="ms-3">
                            <div class="fw-semibold">{{ Auth::user()->name }}</div>
                            <div class="text-muted" style="font-size: 0.875rem;">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <hr>
                    <small class="text-muted">
                        {{ __('Member since') }} {{ Auth::user()->created_at->format('M Y') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
