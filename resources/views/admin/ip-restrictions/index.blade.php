<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 fw-semibold">{{ __('IP Restrictions') }}</h2>
    </x-slot>

    <div class="alert alert-info">
        <i class="bi bi-info-circle me-1"></i>
        {{ __('When whitelist is empty, all admin IPs are allowed. Add one IP, CIDR range, or wildcard per line (e.g. 192.168.1.1, 10.0.0.0/8, 203.0.113.*).') }}
    </div>

    <form method="POST" action="{{ route('admin.ip-restrictions.update') }}">
        @csrf @method('PUT')

        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="ips" class="form-label">{{ __('Allowed IPs') }}</label>
                    <textarea class="form-control font-monospace" id="ips" name="ips" rows="8" placeholder="192.168.1.1&#10;10.0.0.0/8&#10;203.0.113.*">{{ implode("\n", $whitelist) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Your Current IP') }}</label>
                    <div><code>{{ request()->ip() }}</code></div>
                </div>
            </div>
            <div class="card-footer bg-white text-end">
                <button class="btn btn-primary"><i class="bi bi-save me-1"></i>{{ __('Save Whitelist') }}</button>
            </div>
        </div>
    </form>
</x-app-layout>
