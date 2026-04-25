@extends('admin-layout')

@section('page-content')
<div class="w-full max-w-3xl mx-auto p-4">
    <div class="rounded-2xl border bg-white p-6 shadow-sm">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Edit Package Category</h1>
            <p class="mt-1 text-sm text-slate-600">Update the category name used for package grouping.</p>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                <p class="font-semibold mb-2">Please fix the errors below:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.package-categories.update', $category) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Category Name</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $category->name) }}"
                    class="h-11 w-full rounded-lg border border-slate-300 px-4 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                    required
                >
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.package-categories.index') }}"
                   class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
                    Cancel
                </a>
                <button type="submit" class="rounded-lg bg-emerald-600 px-5 py-2 text-sm font-semibold text-white">
                    Save Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
