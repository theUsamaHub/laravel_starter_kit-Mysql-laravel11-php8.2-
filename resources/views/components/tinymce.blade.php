@php
    $randomId = 'tinymce_' . str()->random(8);
@endphp

<textarea
    id="{{ $randomId }}"
    name="{{ $name }}"
    {{ $attributes->merge(['class' => 'form-control tinymce-editor', 'rows' => $rows ?? 12]) }}
>{{ $slot }}</textarea>

@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editor = document.querySelector('#{{ $randomId }}');
    if (editor && !editor.dataset.tinymceInit) {
        editor.dataset.tinymceInit = '1';
        tinymce.init({
            selector: '#{{ $randomId }}',
            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table wordcount',
            toolbar: 'undo redo | blocks | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code fullscreen',
            menubar: false,
            branding: false,
            promotion: false,
            height: {{ $height ?? 400 }},
            relative_urls: false,
            remove_script_host: false,
        });
    }
});
</script>
@endpush
