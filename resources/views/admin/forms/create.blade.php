@extends('admin-layout')

@section('page-content')
    @include('admin.forms._form', [
        'title' => 'Create Form',
        'method' => 'POST',
        'action' => route('admin.forms.store'),
    ])
@endsection
