<div>
    <button class="btn btn-success mb-3" wire:click="openModal">
        إضافة سيارة ومزاد جديد
    </button>

    @if($showModal)
    <div class="modal fade show d-block" style="background:rgba(0,0,0,.5)" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5>إضافة سيارة ومزاد</h5>
                    <button class="btn-close" wire:click="closeModal"></button>
                </div>

                <div class="modal-body">

                    {{-- STEP 1 --}}
                    @if($step === 1)
                    <h6>بيانات السيارة</h6>

                    <div class="mb-3">
                        <label>الماركة</label>
                        <select wire:model.live="brand_id" class="form-select">
                            <option value="">اختر الماركة</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>الموديل</label>
                        <select wire:model.live="model_id" wire:key="model-select-{{ $brand_id }}" class="form-select"
                            @disabled(!$brand_id)>
                            <option value="">اختر الموديل</option>

                            @forelse($models as $model)
                            <option value="{{ $model->id }}">{{ $model->name }}</option>
                            @empty
                            <option disabled>لا توجد نتائج</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>سنة الصنع</label>
                        <select wire:model.live="year" class="form-select">
                            <option value="">اختر السنة</option>
                            @foreach($years as $y)
                            <option value="{{ $y }}">{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for=""> المدينة</label>
                        <input class="form-control mb-2" placeholder="المدينة" wire:model.defer="city">
                    </div>
                    <div class="mb-3">
                        <label for="">عدد الكيلومترات</label>
                        <input class="form-control mb-2" placeholder="عدد الكيلومترات" type="number"
                            wire:model.defer="mileage">
                    </div>

                    <textarea class="form-control mb-2" placeholder="الوصف" wire:model.defer="description"></textarea>
                    <textarea class="form-control" placeholder="المعلومات القانونية"
                        wire:model.defer="inspection_report"></textarea>
                    @endif

                    {{-- STEP 2 --}}
                    @if($step === 2)
                    <div class="mb-3">
                        <label>رقم اللوحة</label>
                        <input class="form-control" wire:model.defer="plate_number" placeholder="رقم اللوحة">
                        @error('plate_number') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label>صور السيارة</label>
                        <input type="file" class="form-control" wire:model="photos" multiple>
                        @error('photos.*') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mt-2 d-flex flex-wrap">
                        @if($photos)
                        @foreach($photos as $photo)
                        <img src="{{ $photo->temporaryUrl() }}" class="img-thumbnail me-2 mb-2"
                            style="width:100px; height:80px; object-fit:cover;">
                        @endforeach
                        @endif
                    </div>
                    @endif


                    {{-- STEP 3 --}}
                    @if($step === 3)
                    <input class="form-control mb-2" placeholder="السعر الابتدائي" type="number"
                        wire:model.defer="starting_price">
                    <input class="form-control" placeholder="سعر الشراء الفوري" type="number"
                        wire:model.defer="buy_now_price">
                    @endif

                </div>

                <div class="modal-footer">
                    @if($step > 1)
                    <button class="btn btn-secondary" wire:click="previousStep">السابق</button>
                    @endif

                    @if($step < 3) <button class="btn btn-primary" wire:click="nextStep">التالي</button>
                        @else
                        <button class="btn btn-success" wire:click="save">حفظ</button>
                        @endif
                </div>

            </div>
        </div>
    </div>
    @endif
</div>
