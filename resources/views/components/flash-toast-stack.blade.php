<div
    x-data="{
        toasts: [],
        nextId: 1,
        init() {
            const initial = [
                @if (session()->has('success'))
                    { type: 'success', message: @js(session('success')) },
                @endif
                @if (session()->has('error'))
                    { type: 'error', message: @js(session('error')) },
                @endif
                @if (session()->has('warning'))
                    { type: 'warning', message: @js(session('warning')) },
                @endif
                @if (session()->has('info'))
                    { type: 'info', message: @js(session('info')) },
                @endif
            ];

            initial.forEach((toast) => this.push(toast));
        },
        push(detail) {
            if (!detail || !detail.message) return;

            const toast = {
                id: this.nextId++,
                type: detail.type || 'success',
                message: detail.message,
                visible: true,
            };

            this.toasts.push(toast);
            window.setTimeout(() => this.hide(toast.id), detail.duration || 3500);
        },
        hide(id) {
            const toast = this.toasts.find((item) => item.id === id);
            if (!toast) return;

            toast.visible = false;

            window.setTimeout(() => {
                this.toasts = this.toasts.filter((item) => item.id !== id);
            }, 250);
        },
        classes(type) {
            return {
                'border-emerald-200 bg-emerald-50 text-emerald-800': type === 'success',
                'border-rose-200 bg-rose-50 text-rose-800': type === 'error',
                'border-amber-200 bg-amber-50 text-amber-800': type === 'warning',
                'border-sky-200 bg-sky-50 text-sky-800': type === 'info',
            };
        }
    }"
    x-on:toast.window="push($event.detail)"
>
    <style>
        button:not(:disabled),
        [type='button']:not(:disabled),
        [type='submit']:not(:disabled),
        [type='reset']:not(:disabled),
        select:not(:disabled),
        input[type='checkbox']:not(:disabled),
        input[type='radio']:not(:disabled),
        summary {
            cursor: pointer;
        }
    </style>

    <div class="pointer-events-none fixed right-4 top-4 z-[100] flex w-full max-w-sm flex-col gap-3 sm:right-6 sm:top-6">
        <template x-for="toast in toasts" :key="toast.id">
            <div
                x-show="toast.visible"
                x-transition:enter="transform transition ease-out duration-200"
                x-transition:enter-start="translate-y-2 opacity-0"
                x-transition:enter-end="translate-y-0 opacity-100"
                x-transition:leave="transform transition ease-in duration-200"
                x-transition:leave-start="translate-y-0 opacity-100"
                x-transition:leave-end="translate-y-2 opacity-0"
                class="pointer-events-auto rounded-2xl border px-4 py-3 shadow-lg backdrop-blur"
                :class="classes(toast.type)"
            >
                <div class="flex items-start gap-3">
                    <div class="min-w-0 flex-1 text-sm font-medium" x-text="toast.message"></div>
                    <button type="button" class="cursor-pointer shrink-0 rounded-lg px-2 py-1 text-xs font-semibold opacity-70 hover:opacity-100" @click="hide(toast.id)">
                        ✕
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>
