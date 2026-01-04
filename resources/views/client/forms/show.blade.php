@extends('client-layout')

@section('page-content')
<div class="w-full max-w-4xl mx-auto p-4">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold">{{ $form->name }}</h1>
        @if($form->description)
            <p class="text-sm text-slate-600">{{ $form->description }}</p>
        @endif
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 p-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @include('client.forms._render', [
        'form' => $form,
        'sections' => $sections,
        'action' => route('forms.submit', $form->slug),
    ])
</div>
@endsection
