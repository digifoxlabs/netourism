@extends('admin-layout')

@section('page-content')
    @include('admin.packages._form', [
        'title' => 'Create Package',
        'action' => route('admin.packages.store'),
        'method' => 'POST',
        'package' => null,
    ])
@endsection

@push('scripts')

<script>
function packageBuilder(pkg) {
    return {
        name: pkg?.name ?? '',
        subtitle: pkg?.subtitle ?? '',
        duration_days: pkg?.duration_days ?? '',
        is_active: pkg?.is_active ?? true,

        itinerary: pkg?.itineraries ?? [],
        itineraryJson: '',

        addDay() {
            this.itinerary.push({ title: '', description: '' });
        },

        removeDay(i) {
            this.itinerary.splice(i, 1);
        },

        serializeItinerary() {
            this.itineraryJson = JSON.stringify(this.itinerary);
        }
    }
}
</script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    tinymce.init({
        selector: '#package-description',
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
