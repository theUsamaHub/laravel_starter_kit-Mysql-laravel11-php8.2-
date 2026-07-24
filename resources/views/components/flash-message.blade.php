@if (session('success'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        x-init="setTimeout(() => show = false, 5000)"
        class="alert alert-success alert-dismissible fade show"
        role="alert"
    >
        {{ session('success') }}
        <button type="button" class="btn-close" @click="show = false"></button>
    </div>
@endif

@if (session('error'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        x-init="setTimeout(() => show = false, 5000)"
        class="alert alert-danger alert-dismissible fade show"
        role="alert"
    >
        {{ session('error') }}
        <button type="button" class="btn-close" @click="show = false"></button>
    </div>
@endif

@if (session('warning'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        x-init="setTimeout(() => show = false, 5000)"
        class="alert alert-warning alert-dismissible fade show"
        role="alert"
    >
        {{ session('warning') }}
        <button type="button" class="btn-close" @click="show = false"></button>
    </div>
@endif

@if (session('info'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        x-init="setTimeout(() => show = false, 5000)"
        class="alert alert-info alert-dismissible fade show"
        role="alert"
    >
        {{ session('info') }}
        <button type="button" class="btn-close" @click="show = false"></button>
    </div>
@endif

@if ($errors->any())
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        class="alert alert-danger alert-dismissible fade show"
        role="alert"
    >
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" @click="show = false"></button>
    </div>
@endif
