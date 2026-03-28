<div
    x-data="{ lightboxOpen: false, lightboxSrc: '', lightboxName: '' }"
    @keydown.escape.window="lightboxOpen = false"
    class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm"
>
    <div class="mb-4 flex items-center justify-between gap-3">
        <h3 class="text-lg font-semibold tracking-tight text-slate-900">{{ __('attachments.title') }}</h3>
        <div class="text-xs text-slate-500">{{ __('attachments.count_label', ['count' => $attachments->count()]) }}</div>
    </div>

    @if ($attachments->isEmpty())
        <x-empty-state :title="__('attachments.empty.title')" :description="__('attachments.empty.description')" />
    @else
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-1 2xl:grid-cols-2">
            @foreach ($attachments as $attachment)
                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white">
                    @if ($attachment['is_image'] && $attachment['url'])
                        <button type="button"
                                class="block w-full bg-slate-100 text-left cursor-pointer"
                                @click="lightboxSrc = '{{ $attachment['url'] }}'; lightboxName = @js($attachment['original_name']); lightboxOpen = true">
                            <img src="{{ $attachment['url'] }}" alt="{{ $attachment['original_name'] }}" class="h-48 w-full object-cover">
                        </button>
                    @else
                        <div class="flex h-48 items-center justify-center bg-slate-100 px-6 text-center">
                            <div>
                                <div class="text-sm font-semibold text-slate-700">
                                    {{ __('attachments.types.' . $attachment['type']) }}
                                </div>
                                <div class="mt-2 text-xs text-slate-500">{{ $attachment['mime_type'] ?: __('attachments.file_fallback') }}</div>
                            </div>
                        </div>
                    @endif

                    <div class="space-y-3 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="truncate text-sm font-medium text-slate-900">{{ $attachment['original_name'] }}</div>
                                <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-slate-500">
                                    <span>{{ __('attachments.types.' . $attachment['type']) }}</span>
                                    <span>•</span>
                                    <span>{{ $attachment['created_at'] ?: '—' }}</span>
                                    @if ($attachment['size_bytes'] > 0)
                                        <span>•</span>
                                        <span>{{ number_format($attachment['size_bytes'] / 1024, 1) }} KB</span>
                                    @endif
                                </div>
                            </div>

                            @if ($attachment['is_primary'])
                                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                    {{ __('attachments.actions.primary') }}
                                </span>
                            @endif
                        </div>

                        @if ($attachment['description'])
                            <div class="text-sm text-slate-600">{{ $attachment['description'] }}</div>
                        @endif

                        <div class="flex flex-wrap gap-2">
                            @if ($attachment['url'])
                                <a href="{{ $attachment['url'] }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                    {{ __('attachments.actions.open') }}
                                </a>
                            @endif

                            @if ($attachment['is_image'] && $attachment['url'])
                                <button type="button"
                                        @click="lightboxSrc = '{{ $attachment['url'] }}'; lightboxName = @js($attachment['original_name']); lightboxOpen = true"
                                        class="cursor-pointer rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                    {{ __('attachments.actions.preview') }}
                                </button>
                            @endif

                            @unless ($attachment['is_primary'])
                                <button type="button"
                                        wire:click="markPrimary({{ $attachment['id'] }})"
                                        class="cursor-pointer rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                    {{ __('attachments.actions.mark_primary') }}
                                </button>
                            @endunless

                            <button type="button"
                                    wire:click="deleteAttachment({{ $attachment['id'] }})"
                                    wire:confirm="{{ __('attachments.confirm_delete') }}"
                                    class="cursor-pointer rounded-xl border border-rose-300 bg-white px-3 py-2 text-xs font-medium text-rose-700 hover:bg-rose-50">
                                {{ __('common.actions.delete') }}
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div x-cloak x-show="lightboxOpen" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 p-6">
        <div class="relative w-full max-w-5xl">
            <button type="button" @click="lightboxOpen = false"
                    class="absolute right-0 top-0 z-10 cursor-pointer rounded-xl bg-white/10 px-3 py-2 text-sm font-medium text-white backdrop-blur hover:bg-white/20">
                {{ __('common.actions.close') }}
            </button>

            <div class="overflow-hidden rounded-3xl border border-white/10 bg-slate-900 p-3 shadow-2xl">
                <img :src="lightboxSrc" :alt="lightboxName" class="max-h-[80vh] w-full rounded-2xl object-contain bg-slate-950">
                <div class="px-2 pb-1 pt-3 text-sm text-slate-200" x-text="lightboxName"></div>
            </div>
        </div>
    </div>
</div>
