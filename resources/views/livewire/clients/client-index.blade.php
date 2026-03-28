<div class="space-y-6">
    <x-page-header title="Clients" description="Search and manage workshop customers.">
        <x-slot:actions>
            <a href="{{ route('app.clients.create') }}"
               class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-800">
                Create client
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="grid gap-3 md:grid-cols-[1fr_180px_auto]">
            <input type="text"
                   wire:model.live.debounce.300ms="search"
                   placeholder="Search by name, phone, company or email"
                   class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">

            <select wire:model.live="type" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                <option value="">All types</option>
                <option value="person">Person</option>
                <option value="company">Company</option>
            </select>

            <button type="button"
                    wire:click="resetFilters"
                    class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Reset
            </button>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
        @if ($clients->isEmpty())
            <div class="p-5">
                <x-empty-state title="No clients found." description="Try changing the filters or create a new client." />
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-5 py-3 font-medium">Client</th>
                            <th class="px-5 py-3 font-medium">Type</th>
                            <th class="px-5 py-3 font-medium">Phone</th>
                            <th class="px-5 py-3 font-medium">Email</th>
                            <th class="px-5 py-3 font-medium">Created</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr class="border-t border-slate-200">
                                <td class="px-5 py-3 font-medium text-slate-900">{{ $client->display_name }}</td>
                                <td class="px-5 py-3 text-slate-700">{{ $client->type->value ?? $client->type }}</td>
                                <td class="px-5 py-3 text-slate-700">{{ $client->phone }}</td>
                                <td class="px-5 py-3 text-slate-700">{{ $client->email ?: '—' }}</td>
                                <td class="px-5 py-3 text-slate-500">{{ optional($client->created_at)->format('d.m.Y') }}</td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('app.clients.edit', $client->id) }}"
                                       class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-5 py-4">
                {{ $clients->links() }}
            </div>
        @endif
    </div>
</div>
