<form method="POST" action="{{ route('public.subscribe') }}" class="row g-2">
    @csrf
    <div class="col-12">
        <label for="subscribe_email" class="form-label">{{ __('Email Address') }}</label>
        <input type="email" class="form-control @error('email', 'subscribe') is-invalid @enderror" id="subscribe_email" name="email" placeholder="you@example.com" required>
        @error('email', 'subscribe')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12">
        <label for="subscribe_name" class="form-label">{{ __('Name (optional)') }}</label>
        <input type="text" class="form-control" id="subscribe_name" name="name" placeholder="{{ __('Your name') }}">
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-envelope-paper me-1"></i>{{ __('Subscribe') }}</button>
    </div>
</form>
