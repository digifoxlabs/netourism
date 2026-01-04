@extends('admin-layout')

@section('page-content')


<div @class(['mx-auto', 'max-w-6xl', 'px-4', 'py-8', 'lg:py-10'])>

    {{-- Heading + Search --}}
    <div @class(['flex', 'flex-col', 'gap-4', 'sm:flex-row', 'sm:items-center', 'sm:justify-between', 'mb-6'])>
        <div>
            <h1 @class(['text-2xl', 'font-semibold', 'text-slate-900'])>
                Event Registrations
            </h1>
            <p @class(['mt-1', 'text-sm', 'text-slate-500'])>
                View, edit, and manage all event registration forms.
            </p>
        </div>

        <form method="GET" @class(['w-full', 'sm:w-auto'])>
            <div @class(['flex', 'gap-2'])>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search name, email, mobile..."
                    class="w-full sm:w-64 rounded-lg border border-gray-300 px-3 py-2 text-sm
                           focus:border-brand-500 focus:ring-brand-500"
                >
                <button
                    type="submit"
                    @class(['inline-flex', 'items-center', 'rounded-lg', 'bg-brand-600', 'px-3', 'py-2', 'text-sm', 'font-semibold', 'text-white', 'hover:bg-brand-500'])
                >
                    Search
                </button>
            </div>
        </form>
    </div>

    {{-- Flash message --}}
    @if(session('success'))
        <div @class(['mb-4', 'rounded-lg', 'bg-emerald-50', 'border', 'border-emerald-200', 'px-4', 'py-3', 'text-sm', 'text-emerald-700'])>
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div @class(['overflow-x-auto', 'rounded-xl', 'border', 'border-slate-200', 'bg-white', 'shadow-sm'])>
        <table @class(['min-w-full', 'text-sm'])>
            <thead @class(['bg-slate-50', 'text-left', 'text-xs', 'font-semibold', 'uppercase', 'tracking-wide', 'text-slate-500'])>
                <tr class="text-center">
                    <th @class(['px-4', 'py-3'])>ID</th>
                    <th @class(['px-4', 'py-3'])>Name</th>
                    <th @class(['px-4', 'py-3'])>Mobile</th>
                    <th @class(['px-4', 'py-3'])>City / State</th>
                    <th @class(['px-4', 'py-3'])>Mode</th>
                    <th @class(['px-4', 'py-3'])>Payment</th>
                    <th @class(['px-4', 'py-3'])>Payment Date</th>
                    <th @class(['px-4', 'py-3'])>Registered At</th>
                    <th class="px-4 py-3">Status</th>
                    <th @class(['px-4', 'py-3'])>Actions</th>
                </tr>
            </thead>
            <tbody @class(['divide-y', 'divide-slate-100'])>
                @forelse ($registrations as $registration)
                    <tr @class(['hover:bg-slate-50'])>
                        <td @class(['px-4', 'py-3', 'text-xs', 'text-slate-500'])>
                            #{{ $registration->id }}
                        </td>
                        <td @class(['px-4', 'py-3', 'font-medium', 'text-slate-900'])>
                            {{ $registration->full_name }}
                        </td>
                        <td @class(['px-4', 'py-3', 'text-slate-700'])>
                            {{ $registration->mobile }}
                        </td>
                        <td @class(['px-4', 'py-3', 'text-slate-700'])>
                            {{ $registration->city_state }}
                        </td>
                        <td @class(['px-4', 'py-3', 'text-slate-700', 'capitalize'])>
                            {{ str_replace('_', ' ', $registration->mode_of_transport) }}
                        </td>
                        <td @class(['px-4', 'py-3', 'text-slate-700', 'uppercase'])>
                            {{ $registration->payment_method }}
                        </td>
                        <td @class(['px-4', 'py-3', 'text-slate-700'])>
                            {{ \Carbon\Carbon::parse($registration->payment_date)->format('d M Y') }}
                        </td>
                        <td @class(['px-4', 'py-3', 'text-slate-500', 'text-xs'])>
                            {{ $registration->created_at->format('d M Y, H:i') }}
                        </td>

                        <td class="px-4 py-3 text-xs">
                            @php
                                $status = $registration->status;
                                $badge = match ($status) {
                                    'confirmed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'pending'   => 'bg-amber-50 text-amber-700 border-amber-200',
                                    default     => 'bg-slate-50 text-slate-700 border-slate-200',
                                };
                            @endphp
                            <span class="inline-flex items-center rounded-full border px-2 py-0.5 {{ $badge }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>


                        <td @class(['px-4', 'py-3', 'text-right', 'whitespace-nowrap'])>
                            <a href="{{ route('admin.event-registrations.show', $registration) }}"
                               @class(['inline-flex', 'items-center', 'text-xs', 'px-2', 'py-1', 'rounded-lg', 'border', 'border-slate-300', 'text-slate-700', 'hover:bg-slate-100', 'mr-1'])>
                                View
                            </a>
                            <a href="{{ route('admin.event-registrations.edit', $registration) }}"
                               @class(['inline-flex', 'items-center', 'text-xs', 'px-2', 'py-1', 'rounded-lg', 'border', 'border-blue-300', 'text-blue-700', 'hover:bg-blue-50', 'mr-1'])>
                                Edit
                            </a>
                            <button
                                type="button"
                                @class(['inline-flex', 'items-center', 'text-xs', 'px-2', 'py-1', 'rounded-lg', 'border', 'border-red-300', 'text-red-700', 'hover:bg-red-50'])
                                onclick="if(confirm('Delete this registration?')) { document.getElementById('delete-registration-{{ $registration->id }}').submit(); }"
                            >
                                Delete
                            </button>
                            <form
                                id="delete-registration-{{ $registration->id }}"
                                method="POST"
                                action="{{ route('admin.event-registrations.destroy', $registration) }}"
                                @class(['hidden'])
                            >
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>




                    </tr>
                @empty
                    <tr>
                        <td colspan="9" @class(['px-4', 'py-6', 'text-center', 'text-sm', 'text-slate-500'])>
                            No event registrations found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div @class(['mt-4'])>
        {{ $registrations->links() }}
    </div>
</div>


@endsection

