<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('Edit Category') }}</h2>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>{{ __('Back') }}
            </a>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <x-input-label for="name" :value="__('Category Name')" />
                            <x-text-input id="name" name="name" type="text" class="form-control" :value="old('name', $category->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>

                        <div class="mb-3">
                            <x-input-label for="slug" :value="__('Slug')" />
                            <x-text-input id="slug" name="slug" type="text" class="form-control" :value="old('slug', $category->slug)" />
                            <x-input-error :messages="$errors->get('slug')" class="mt-1" />
                        </div>

                        <div class="mb-3">
                            <x-input-label for="description" :value="__('Description')" />
                            <x-tinymce name="description" rows="8">{{ old('description', $category->description) }}</x-tinymce>
                            <x-input-error :messages="$errors->get('description')" class="mt-1" />
                        </div>

                        <div class="mb-3">
                            <x-input-label for="image" :value="__('Category Image')" />
                            @if ($category->image)
                                <div class="mb-2">
                                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="img-thumbnail" style="max-height: 100px;">
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox" name="remove_image" value="1" id="remove_image">
                                        <label class="form-check-label" for="remove_image" style="font-size: 0.875rem;">{{ __('Remove current image') }}</label>
                                    </div>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" accept=".jpg,.jpeg,.png,.gif,.webp">
                            <small class="text-muted">{{ __('Leave empty to keep current image.') }}</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="image-preview" class="mt-2" style="display: none;">
                                <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        </div>

                        <!-- Existing Media -->
                        @if ($category->media->count() > 0)
                            <div class="mb-3">
                                <x-input-label :value="__('Attached Files')" />
                                <div class="row g-2 mt-1">
                                    @foreach ($category->media as $item)
                                        <div class="col-auto">
                                            <div class="card border" style="width: 120px;">
                                                <div class="card-body p-2 text-center">
                                                    @if ($item->isImage())
                                                        <img src="{{ $item->url }}" alt="{{ $item->name }}" class="img-fluid rounded" style="max-height: 50px;">
                                                    @elseif ($item->isPdf())
                                                        <i class="bi bi-file-earmark-pdf text-danger fs-3"></i>
                                                    @elseif ($item->isExcel())
                                                        <i class="bi bi-file-earmark-excel text-success fs-3"></i>
                                                    @else
                                                        <i class="bi bi-file-earmark text-secondary fs-3"></i>
                                                    @endif
                                                    <div class="text-truncate mt-1" style="font-size: 0.65rem;">{{ $item->original_name }}</div>
                                                </div>
                                                <div class="card-footer bg-transparent p-1 text-center">
                                                    <a href="{{ $item->url }}" target="_blank" class="btn btn-outline-info btn-sm" style="font-size: 0.6rem;"><i class="bi bi-eye"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <x-input-label :value="__('Add More Attachments')" />
                            <input type="file" class="form-control" name="attachments[]" multiple accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx,.xls,.xlsx,.csv">
                            <small class="text-muted">{{ __('Upload additional files. Existing files are kept unless removed.') }}</small>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <x-input-label for="sort_order" :value="__('Sort Order')" />
                                <x-text-input id="sort_order" name="sort_order" type="number" class="form-control" :value="old('sort_order', $category->sort_order)" min="0" />
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
                            <x-primary-button>{{ __('Update Category') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 fw-semibold">{{ __('Category Info') }}</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">{{ __('Created') }}</small>
                        <div>{{ $category->created_at->format('M d, Y H:i') }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">{{ __('Last Updated') }}</small>
                        <div>{{ $category->updated_at->format('M d, Y H:i') }}</div>
                    </div>
                    <div>
                        <small class="text-muted">{{ __('Created By') }}</small>
                        <div>{{ $category->createdBy?->name ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const preview = document.getElementById('image-preview');
            const img = document.getElementById('preview-img');
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    img.src = ev.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(e.target.files[0]);
            } else {
                preview.style.display = 'none';
            }
        });
    </script>
    @endpush
</x-app-layout>
