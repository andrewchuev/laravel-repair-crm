<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <h3 class="text-lg font-semibold tracking-tight text-slate-900">{{ __('service_orders.sections.comments') }}</h3>

    @if ($comments->isEmpty())
        <div class="mt-4">
            <x-empty-state :title="__('service_orders.empty.comments_title')" :description="__('service_orders.empty.comments_description')" />
        </div>
    @else
        <div class="mt-4 space-y-3">
            @foreach ($comments as $comment)
                @php
                    $visibility = $comment->visibility->value ?? $comment->visibility;
                @endphp
                <div class="rounded-2xl border border-slate-200 px-4 py-3">
                    <div class="flex items-center justify-between gap-3">
                        <div class="text-sm font-medium text-slate-900">
                            {{ $comment->user?->name ?? __('service_orders.messages.system') }}
                        </div>
                        <div class="text-xs text-slate-500">
                            {{ __('service_orders.comment_visibility.' . $visibility) }} · {{ optional($comment->created_at)->format('d.m.Y H:i') }}
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-slate-700">{{ $comment->body }}</div>
                </div>
            @endforeach
        </div>
    @endif
</div>
