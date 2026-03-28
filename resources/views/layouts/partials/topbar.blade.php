<header class="border-b border-slate-200 bg-white">
    <div class="flex items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        <div>
            <h1 class="text-xl font-semibold tracking-tight text-slate-900">
                {{ $pageTitle ?? trim($__env->yieldContent('title')) ?: 'Repair CRM' }}
            </h1>
            @hasSection('subtitle')
                <p class="mt-1 text-sm text-slate-500">@yield('subtitle')</p>
            @endif
        </div>

        <div class="flex items-center gap-3">
            <div class="hidden text-right sm:block">
                <div class="text-sm font-medium text-slate-900">{{ auth()->user()?->name }}</div>
                <div class="text-xs text-slate-500">{{ auth()->user()?->role?->value ?? auth()->user()?->role }}</div>
            </div>

            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit"
                    class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>
