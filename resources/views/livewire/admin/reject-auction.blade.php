<div>

    
    <button class="btn btn-danger px-4" wire:click="confirmReject">
        رفض المزاد
    </button>


    @if($showConfirm)
        <div class="modal fade show d-block" tabindex="-1"
             style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">تأكيد الرفض</h5>
                        <button type="button" class="btn-close"
                                wire:click="$set('showConfirm', false)"></button>
                    </div>

                    <div class="modal-body">
                        هل أنت متأكد من رفض هذا المزاد؟
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary"
                                wire:click="$set('showConfirm', false)">
                            إلغاء
                        </button>

                        <button class="btn btn-danger"
                                wire:click="reject"
                                wire:loading.attr="disabled">
                            تأكيد الرفض
                        </button>
                    </div>

                </div>
            </div>
        </div>
    @endif

</div>
