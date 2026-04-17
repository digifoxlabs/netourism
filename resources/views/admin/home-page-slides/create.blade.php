@extends('admin-layout')

@section('page-content')
<div class="mx-auto w-full max-w-6xl p-4 md:p-6">
    <h1 class="mb-4 text-2xl font-semibold text-slate-900">Create Home Page Slide</h1>

    @include('admin.home-page-slides._form', [
        'action' => route('admin.home-page-slides.store'),
        'method' => 'POST',
        'slide' => $slide,
    ])
</div>
@endsection
