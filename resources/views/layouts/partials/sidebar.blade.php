<aside class="hidden border-r border-slate-200 bg-white lg:block">
    <div class="sticky top-0 flex h-screen flex-col">
        <div class="border-b border-slate-200 px-6 py-5">
            <div class="text-lg font-semibold tracking-tight">Repair CRM</div>
            <div class="mt-1 text-sm text-slate-500">{{ __('navigation.workshop_internal_system') }}</div>
        </div>

        <nav class="flex-1 space-y-1 px-3 py-4 text-sm">
            <a href="{{ route('app.dashboard') }}"
               class="{{ request()->routeIs('app.dashboard') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }} block rounded-xl px-3 py-2 font-medium">
                {{ __('navigation.dashboard') }}
            </a>

            <a href="{{ route('app.profile') }}"
               class="{{ request()->routeIs('app.profile') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }} block rounded-xl px-3 py-2 font-medium">
                {{ __('navigation.profile') }}
            </a>

            <a href="{{ route('app.clients.index') }}"
               class="{{ request()->routeIs('app.clients.*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }} block rounded-xl px-3 py-2 font-medium">
                {{ __('navigation.clients') }}
            </a>

            <a href="{{ route('app.service-orders.index') }}"
               class="{{ request()->routeIs('app.service-orders.*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }} block rounded-xl px-3 py-2 font-medium">
                {{ __('navigation.service_orders') }}
            </a>

            @php
                $settingsOpen = request()->routeIs('app.settings.*');
            @endphp

            <div class="rounded-2xl {{ $settingsOpen ? 'bg-slate-50' : '' }}">
                <div class="{{ $settingsOpen ? 'text-slate-900' : 'text-slate-700' }} px-3 py-2 font-medium">
                    {{ __('navigation.settings') }}
                </div>

                <div class="space-y-1 px-2 pb-2">
                    <a href="{{ route('app.settings.business') }}"
                       class="{{ request()->routeIs('app.settings.business') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100' }} block rounded-xl px-3 py-2 text-sm">
                        {{ __('navigation.business_profile') }}
                    </a>

                    <a href="{{ route('app.settings.bank-accounts') }}"
                       class="{{ request()->routeIs('app.settings.bank-accounts') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100' }} block rounded-xl px-3 py-2 text-sm">
                        {{ __('navigation.bank_accounts') }}
                    </a>

                    <a href="{{ route('app.settings.documents') }}"
                       class="{{ request()->routeIs('app.settings.documents') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100' }} block rounded-xl px-3 py-2 text-sm">
                        {{ __('navigation.document_preferences') }}
                    </a>
                </div>
            </div>
        </nav>

        <div class="border-t border-slate-200 px-6 py-4 text-xs text-slate-500">
            {{ __('navigation.signed_in_as') }}<br>
            <span class="font-medium text-slate-700">{{ auth()->user()?->email }}</span>
        </div>
    </div>
</aside>
