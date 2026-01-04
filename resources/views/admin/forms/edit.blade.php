@extends('admin-layout')

@section('page-content')
    @include('admin.forms._form', [
        'title' => 'Edit Form',
        'method' => 'PUT',
        'action' => route('admin.forms.update', $form),
    ])
@endsection
