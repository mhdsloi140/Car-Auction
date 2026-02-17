<div>



    {{-- أزرار التحكم --}}
    <div class="text-center mb-4">

        <button class="btn btn-primary px-4 me-2"
                wire:click="openEditPrice">
            تعديل سعر المزاد
        </button>

        <button class="btn btn-danger px-4"
                wire:click="confirmReject">
            رفض المزاد
        </button>

    </div>


    {{-- مودال تعديل السعر --}}
    @if($showEditPriceModal)
        <div class="modal fade show d-block"
             style="background: rgba(0,0,0,0.5);">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">تعديل سعر المزاد</h5>
                        <button type="button"
                                class="btn-close"
                                wire:click="$set('showEditPriceModal', false)">
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">السعر الجديد</label>

                            <input type="number"
                                   class="form-control"
                                   wire:model.defer="price">

                            @error('price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary"
                                wire:click="$set('showEditPriceModal', false)">
                            إلغاء
                        </button>

                        <button class="btn btn-success"
                                wire:click="updatePrice"
                                wire:loading.attr="disabled">
                            حفظ
                        </button>
                    </div>

                </div>
            </div>
        </div>
    @endif



    {{-- مودال تأكيد الرفض --}}
    @if($showRejectConfirm)
        <div class="modal fade show d-block"
             style="background: rgba(0,0,0,0.5);">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">تأكيد الرفض</h5>
                        <button type="button"
                                class="btn-close"
                                wire:click="$set('showRejectConfirm', false)">
                        </button>
                    </div>

                    <div class="modal-body">
                        هل أنت متأكد من رفض هذا المزاد؟
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary"
                                wire:click="$set('showRejectConfirm', false)">
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
