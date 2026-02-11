
<div wire:poll.30s>
    <a href="{{ route('seller.dashboard') }}" class="nav-link position-relative">
        <i class="bi bi-bell fs-5"></i>

        @if($count > 0)
            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                {{ $count }}
            </span>
        @endif
    </a>
</div>
