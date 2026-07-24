<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('Media Library') }}</h2>
        </div>
    </x-slot>

    <!-- Upload Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0 fw-semibold">{{ __('Upload Files') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <input type="file" class="form-control" name="files[]" multiple accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx,.xls,.xlsx,.csv,.txt" required>
                    <small class="text-muted">{{ __('Supported: JPG, PNG, GIF, WebP, PDF, DOC, DOCX, XLS, XLSX, CSV, TXT (max 10MB each, up to 10 files)') }}</small>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-upload me-1"></i>{{ __('Upload') }}
                </button>
            </form>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.media.index') }}" class="row g-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="search" placeholder="{{ __('Search files...') }}" value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="type">
                        <option value="">{{ __('All Types') }}</option>
                        <option value="image" {{ request('type') === 'image' ? 'selected' : '' }}>{{ __('Images') }}</option>
                        <option value="application/pdf" {{ request('type') === 'application/pdf' ? 'selected' : '' }}>{{ __('PDF') }}</option>
                        <option value="application/vnd" {{ request('type') === 'application/vnd' ? 'selected' : '' }}>{{ __('Office Documents') }}</option>
                        <option value="text/csv" {{ request('type') === 'text/csv' ? 'selected' : '' }}>{{ __('CSV') }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-search me-1"></i>{{ __('Filter') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Files Grid -->
    <div class="card">
        <div class="card-body">
            @forelse ($media as $item)
                @if ($loop->first || ($loop->index % 6 === 0))
                    <div class="row g-3 mb-3">
                @endif

                <div class="col-md-2">
                    <div class="card h-100 border">
                        <div class="card-body p-2 text-center">
                            @if ($item->isImage())
                                <img src="{{ $item->url }}" alt="{{ $item->name }}" class="img-fluid rounded mb-2" style="max-height: 80px; object-fit: cover;">
                            @elseif ($item->isPdf())
                                <i class="bi bi-file-earmark-pdf text-danger fs-1"></i>
                            @elseif ($item->isExcel())
                                <i class="bi bi-file-earmark-excel text-success fs-1"></i>
                            @else
                                <i class="bi bi-file-earmark text-secondary fs-1"></i>
                            @endif
                            <div class="text-truncate" style="font-size: 0.75rem;" title="{{ $item->original_name }}">{{ $item->original_name }}</div>
                            <div class="text-muted" style="font-size: 0.65rem;">{{ $item->size_formatted }}</div>
                        </div>
                        <div class="card-footer bg-transparent p-1 text-center">
                            <a href="{{ $item->url }}" target="_blank" class="btn btn-outline-info btn-sm" style="font-size: 0.7rem;"><i class="bi bi-eye"></i></a>
                            <form action="{{ route('admin.media.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Delete this file?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" style="font-size: 0.7rem;"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>

                @if ($loop->last || ($loop->index % 6 === 5))
                    </div>
                @endif
            @empty
                <div class="empty-state">
                    <i class="bi bi-folder"></i>
                    <p>{{ __('No files uploaded yet.') }}</p>
                </div>
            @endforelse
        </div>

        @if ($media->hasPages())
            <div class="card-footer bg-white">
                {{ $media->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
