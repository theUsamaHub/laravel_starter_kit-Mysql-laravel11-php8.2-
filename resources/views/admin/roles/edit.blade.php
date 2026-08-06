<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('Edit Role') }} — {{ $role->name }}</h2>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>{{ __('Back') }}</a>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <x-input-label for="name" :value="__('Role Name')" />
                            <x-text-input id="name" name="name" type="text" class="form-control" :value="old('name', $role->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>
                        <div class="mb-3">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="form-control" rows="2">{{ old('description', $role->description) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
                            <x-primary-button>{{ __('Update Role') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
