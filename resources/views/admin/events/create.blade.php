@extends('admin-layout')

@section('page-content')
<div class="w-full max-w-6xl mx-auto p-4 md:p-6 space-y-8">
    <h1 class="text-2xl font-semibold mb-4">Create Event</h1>

    @include('admin.events._form', [
        'action' => route('admin.events.store'),
        'method' => 'POST',
        'event'  => $event,
        'forms'  => $forms,
    ])
    
</div>
@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    tinymce.init({
        selector: '#event-description',
        height: 320,
        menubar: false,

        plugins: 'lists link image table code',

        toolbar:
            'undo redo | blocks | fontfamily | ' +
            'bold italic underline | ' +
            'alignleft aligncenter alignright | ' +
            'bullist numlist | link image | removeformat',

        automatic_uploads: true,
        file_picker_types: 'image',
        images_upload_handler: (blobInfo) => new Promise((resolve, reject) => {
            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            fetch('{{ route('admin.events.editor-image') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(async (response) => {
                if (!response.ok) {
                    throw new Error('Image upload failed.');
                }

                const result = await response.json();
                if (!result.location) {
                    throw new Error('Image upload response is invalid.');
                }

                resolve(result.location);
            })
            .catch((error) => reject(error.message));
        }),

        /* Heading support: H1–H6 + Paragraph */
        block_formats:
            'Paragraph=p;' +
            'Heading 1=h1;' +
            'Heading 2=h2;' +
            'Heading 3=h3;' +
            'Heading 4=h4;' +
            'Heading 5=h5;' +
            'Heading 6=h6',

        /* Font family dropdown */
        font_family_formats:
            'Arial=arial,helvetica,sans-serif;' +
            'Georgia=georgia,palatino,serif;' +
            'Times New Roman=times new roman,times,serif;' +
            'Poppins=poppins,sans-serif;' +
            'Roboto=roboto,sans-serif;' +
            'Courier New=courier new,courier,monospace',

        branding: false
    });
});
</script>

@endpush

