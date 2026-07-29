@php
    $randomId = 'quill_' . str()->random(8);
    $height = $height ?? 300;
@endphp

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
@endpush

<div id="quill-container-{{ $randomId }}">
    <div id="{{ $randomId }}" style="height: {{ $height }}px;" class="form-control @error($name) is-invalid @enderror"></div>
    <textarea name="{{ $name }}" id="{{ $randomId }}_hidden" class="d-none">{{ $slot }}</textarea>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
(function() {
    const hidden = document.getElementById('{{ $randomId }}_hidden');
    const editor = new Quill('#{{ $randomId }}', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['blockquote', 'code-block'],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['link'],
                ['clean'],
            ],
        },
        placeholder: 'Write something...',
    });

    if (hidden.value) {
        editor.root.innerHTML = hidden.value;
    }

    editor.on('text-change', function() {
        hidden.value = editor.root.innerHTML;
    });

    const form = document.getElementById('quill-container-{{ $randomId }}').closest('form');
    if (form) {
        form.addEventListener('formdata', function() {
            hidden.value = editor.root.innerHTML;
        });
    }
})();
</script>
@endpush
