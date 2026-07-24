<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('Tags') }}</h2>
            <a href="{{ route('admin.tags.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i>{{ __('Add Tag') }}</a>
        </div>
    </x-slot>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-10"><input type="text" class="form-control" name="search" placeholder="{{ __('Search tags...') }}" value="{{ request('search') }}"></div>
                <div class="col-md-2"><button type="submit" class="btn btn-outline-secondary w-100"><i class="bi bi-search me-1"></i>{{ __('Filter') }}</button></div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>{{ __('Name') }}</th><th>{{ __('Slug') }}</th><th>{{ __('Color') }}</th><th>{{ __('Categories') }}</th><th class="text-end">{{ __('Actions') }}</th></tr></thead>
                    <tbody>
                        @forelse ($tags as $tag)
                            <tr>
                                <td class="fw-medium"><span class="badge" style="background-color: {{ $tag->color }}; color: #fff;">{{ $tag->name }}</span></td>
                                <td><code>{{ $tag->slug }}</code></td>
                                <td><span class="d-inline-block rounded" style="width:24px;height:24px;background:{{ $tag->color }};"></span> {{ $tag->color }}</td>
                                <td>{{ $tag->categories_count }}</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                        <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="d-inline" onsubmit="return confirm()">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">{{ __('No tags found.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($tags->hasPages())<div class="card-footer bg-white">{{ $tags->links() }}</div>@endif
    </div>
</x-app-layout>
