<div wire:poll.5s>
    @forelse($notifications as $note)
        <div class="alert alert-{{ $note['type'] }} d-flex justify-content-between align-items-center mb-2">
            <div>
                <i class="{{ $note['icon'] }} me-1"></i>
                {{ $note['message'] }}
            </div>

            <button type="button" class="btn-close" wire:click="dismiss({{ $note['id'] }})"></button>
        </div>
    @empty
        <div class="text-muted text-center">لا توجد إشعارات</div>
    @endforelse
</div>
