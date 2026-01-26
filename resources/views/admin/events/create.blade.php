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
    tinymce.init({
        selector: '#event-description',
        height: 320,
        menubar: false,

        plugins: 'lists link table code',

        toolbar:
            'undo redo | blocks | fontfamily | ' +
            'bold italic underline | ' +
            'alignleft aligncenter alignright | ' +
            'bullist numlist | link | removeformat',

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

