@extends('admin-layout')

@section('page-content')
    @include('admin.packages._form', [
        'title' => 'Create Package',
        'action' => route('admin.packages.update',$package),
        'method' => 'PUT',
        'package' => $package,
    ])
@endsection

@push('scripts')
<script>

function packageBuilder(packageData) {
    return {
        name: packageData?.name ?? '',
        subtitle: packageData?.subtitle ?? '',
        duration_days: packageData?.duration_days ?? '',
        is_active: !!packageData?.is_active,

        itinerary: packageData?.itinerary ?? [],

        itineraryJson: '',

        init() {
            // ensure itinerary is always an array
            if (!Array.isArray(this.itinerary)) {
                this.itinerary = [];
            }
        },

        addDay() {
            this.itinerary.push({ title: '', description: '' });
        },

        removeDay(index) {
            this.itinerary.splice(index, 1);
        },

        serializeItinerary() {
            this.itineraryJson = JSON.stringify(this.itinerary);
        }
    }
}


</script>


{{-- <script>
document.addEventListener('DOMContentLoaded', function () {
    tinymce.init({
        selector: '#package-description',
        height: 320,
        menubar: false,
        plugins: 'lists link table code',
        toolbar:
            'undo redo | formatselect | bold italic underline | ' +
            'alignleft aligncenter alignright | bullist numlist | ' +
            'link | removeformat',
        branding: false
    });
});
</script> --}}


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
