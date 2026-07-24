<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('Validation Rules') }}</h2>
            <a href="{{ route('admin.validation-rules.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>{{ __('Add Rule') }}
            </a>
        </div>
    </x-slot>

    <!-- Rules Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('Form Name') }}</th>
                            <th>{{ __('Fields') }}</th>
                            <th>{{ __('Rules') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rules as $rule)
                            <tr>
                                <td class="fw-medium"><code>{{ $rule->form_name }}</code></td>
                                <td>{{ count($rule->rules) }} {{ __('fields') }}</td>
                                <td>
                                    @foreach ($rule->rules as $field => $fieldRules)
                                        <div class="mb-1">
                                            <strong>{{ $field }}:</strong>
                                            <code style="font-size: 0.75rem;">{{ implode(' | ', $fieldRules) }}</code>
                                        </div>
                                    @endforeach
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.validation-rules.edit', $rule) }}" class="btn btn-outline-primary" title="{{ __('Edit') }}">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.validation-rules.destroy', $rule) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Delete this rule?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="{{ __('Delete') }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="bi bi-shield-check"></i>
                                        <p>{{ __('No validation rules configured.') }}</p>
                                        <a href="{{ route('admin.validation-rules.create') }}" class="btn btn-primary btn-sm mt-2">
                                            {{ __('Add your first rule') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
