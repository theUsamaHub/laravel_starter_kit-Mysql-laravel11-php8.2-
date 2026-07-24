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

                        <div class="mb-4">
                            <x-input-label :value="__('Permissions')" />
                            <small class="text-muted d-block mb-3">{{ __('Permissions are auto-discovered from admin modules. Add new modules and they appear here automatically.') }}</small>

                            @foreach ($permissions as $group => $perms)
                                @php
                                    $rolePerms = $role->permissions ?? [];
                                    $allChecked = count(array_intersect(array_keys($perms), $rolePerms)) === count($perms);
                                @endphp
                                <div class="card mb-2 border">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0 fw-semibold">{{ $group }}</h6>
                                            <div class="form-check">
                                                <input class="form-check-input group-toggle" type="checkbox" data-group="{{ $group }}" id="group_{{ Str::slug($group) }}" {{ $allChecked ? 'checked' : '' }}>
                                                <label class="form-check-label" style="font-size:0.8rem;">{{ __('Select All') }}</label>
                                            </div>
                                        </div>
                                        <div class="row g-1">
                                            @foreach ($perms as $key => $label)
                                                <div class="col-md-4 col-lg-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input perm-check" type="checkbox" name="permissions[]" value="{{ $key }}" id="perm_{{ md5($key) }}" data-group="{{ $group }}" {{ in_array($key, old('permissions', $rolePerms)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="perm_{{ md5($key) }}" style="font-size:0.8rem;">{{ $label }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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

    @push('scripts')
    <script>
        document.querySelectorAll('.group-toggle').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const group = this.dataset.group;
                document.querySelectorAll(`.perm-check[data-group="${group}"]`).forEach(cb => {
                    cb.checked = this.checked;
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
