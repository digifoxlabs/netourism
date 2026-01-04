@extends('admin-layout')

@section('page-content')
<div class="max-w-3xl mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Create Event</h1>

    @include('admin.events._form', [
        'action' => route('admin.events.store'),
        'method' => 'POST',
        'event'  => $event,
        'forms'  => $forms,
    ])
    
</div>
@endsection
