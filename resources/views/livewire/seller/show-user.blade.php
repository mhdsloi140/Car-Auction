<div>
    @if($showModal && $user)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{-- Avatar --}}
                            @php
                                $nameParts = explode(' ', trim($user->name));
                                $firstLetter = mb_substr($nameParts[0] ?? '', 0, 1);
                                $secondLetter = mb_substr($nameParts[1] ?? '', 0, 1);
                                $avatarText = strtoupper($firstLetter . $secondLetter);

                                $colors = ['#FFB74D','#4DB6AC','#9575CD','#F06292','#64B5F6','#81C784','#BA68C8','#FFD54F'];
                                $color = $colors[$user->id % count($colors)];
                            @endphp
                            <span style="background-color: {{ $color }}; color: #fff; width: 35px; height: 35px; display:inline-flex; justify-content:center; align-items:center; border-radius:50%; margin-right:5px;">
                                {{ $avatarText }}
                            </span>
                            {{ $user->id }}
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>البريد الإلكتروني:</strong> {{ $user->email }}</p>
                        <p><strong>الهاتف:</strong> {{ $user->phone ?? '—' }}</p>
                        <p><strong>الدور:</strong> {{ $user->roles->pluck('name')->join(', ') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">إغلاق</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
