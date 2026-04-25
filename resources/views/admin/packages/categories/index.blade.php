@extends('admin-layout')

@section('page-content')
<div class="w-full max-w-6xl mx-auto p-4 space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold">Package Categories</h1>
            <p class="text-sm text-slate-600">Create and manage package categories used across the website.</p>
        </div>

        <a href="{{ route('admin.packages.index') }}"
           class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
            Back To Packages
        </a>
    </div>

    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
            <p class="font-semibold mb-2">Please fix the errors below:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-[360px_minmax(0,1fr)]">
        <section class="rounded-2xl border bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Add Category</h2>
            <p class="mt-1 text-sm text-slate-600">New packages default to India Trip unless you choose another category.</p>

            <form method="POST" action="{{ route('admin.package-categories.store') }}" class="mt-5 space-y-4">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Category Name</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="India Trip"
                        class="h-11 w-full rounded-lg border border-slate-300 px-4 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200"
                        required
                    >
                </div>

                <button type="submit" class="rounded-lg bg-emerald-600 px-5 py-2 text-sm font-semibold text-white">
                    Create Category
                </button>
            </form>
        </section>

        <section class="rounded-2xl border bg-white shadow-sm overflow-hidden">
            <div class="border-b px-6 py-4">
                <h2 class="text-lg font-semibold text-slate-900">Existing Categories</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-slate-600">
                        <tr>
                            <th class="px-6 py-3 font-medium">Name</th>
                            <th class="px-6 py-3 font-medium">Slug</th>
                            <th class="px-6 py-3 font-medium">Packages</th>
                            <th class="px-6 py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($categories as $item)
                            <tr>
                                <td class="px-6 py-4 font-medium text-slate-900">{{ $item->name }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $item->slug }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $item->packages_count }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.package-categories.edit', $item) }}"
                                           class="rounded bg-slate-900 px-3 py-1.5 text-xs font-medium text-white">
                                            Edit
                                        </a>

                                        <form method="POST"
                                              action="{{ route('admin.package-categories.destroy', $item) }}"
                                              onsubmit="return confirm('Delete this category? Packages in it will be moved to another available category.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded bg-red-600 px-3 py-1.5 text-xs font-medium text-white">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-500">No categories available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
@endsection
