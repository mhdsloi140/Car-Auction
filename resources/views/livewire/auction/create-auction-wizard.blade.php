<div style="direction: rtl; text-align: right;" class="p-3">

    {{-- زر فتح المودال --}}
    <button class="btn btn-lg btn-success shadow-sm d-flex align-items-center gap-2 px-4 rounded-pill transition-all"
        wire:click="openModal"
        style="font-weight: 600; border: none; background: linear-gradient(45deg, #198754, #20c997);">
        <i class="bi bi-plus-circle-fill"></i>
        <span>إضافة سيارة ومزاد جديد</span>
    </button>

    {{-- المودال --}}
    @if($showModal)
    <div class="modal fade show d-block p-4" style="background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(6px);"
        wire:ignore.self>

        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.25rem; overflow: hidden;">

                {{-- HEADER --}}
                <div class="modal-header border-0 bg-light px-4 py-3">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                        <span class="badge bg-primary rounded-pill px-3 py-2">{{ $step }}/3</span>
                        <span>
                            @if($step === 1) بيانات السيارة الأساسية
                            @elseif($step === 2) الصور والمستندات
                            @else إعدادات المزاد
                            @endif
                        </span>
                    </h5>

                    {{-- <button type="button" class="btn-close" wire:click="closeModal"></button> --}}
                    <button type="button" class="btn-close position-absolute start-0 ms-3 mt-2" wire:click="closeModal">
                    </button>
                </div>


                <div class="progress rounded-0" style="height: 4px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($step/3)*100 }}%;">
                    </div>
                </div>

                {{-- BODY --}}
                <div class="modal-body px-4 py-4" style="max-height: 70vh; overflow-y: auto;">

                    {{-- STEP 1 --}}
                    @if($step === 1)
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">الماركة</label>
                            <select wire:model.live="brand_id" class="form-select custom-input">
                                <option value="">اختر الماركة</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">الموديل</label>
                            <select wire:model.live="model_id" wire:key="model-{{ $brand_id }}"
                                class="form-select custom-input" @disabled(!$brand_id)>
                                <option value="">اختر الموديل</option>
                                @foreach($models as $model)
                                <option value="{{ $model->id }}">{{ $model->name }}</option>
                                @endforeach
                            </select>
                            @error('model_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">سنة الصنع</label>
                            <select wire:model.live="year" class="form-select custom-input">
                                <option value="">اختر السنة</option>
                                @foreach($years as $y)
                                <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
                            </select>
                            @error('year') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">عدد الكيلومترات</label>
                            <select class="form-select custom-input" wire:model.defer="mileage">
                                <option value="">اختر عدد الكيلومترات</option>
                                <option value="500">ما يصل إلى ٥٠٠ كم</option>
                                <option value="1000">ما يصل إلى ١٠٠٠ كم</option>
                                <option value="1500">ما يصل إلى ١٥٠٠ كم</option>
                                <option value="2000">ما يصل إلى ٢٠٠٠ كم</option>
                                <option value="3000">ما يصل إلى ٣٠٠٠ كم</option>
                                <option value="4000">ما يصل إلى ٤٠٠٠ كم</option>
                                <option value="5000">ما يصل إلى ٥٠٠٠ كم</option>
                                <option value="6000">ما يصل إلى ٦٠٠٠ كم</option>
                                <option value="8000">ما يصل إلى ٨٠٠٠ كم</option>
                                <option value="10000">ما يصل إلى ١٠٠٠٠ كم</option>
                                <option value="12500">ما يصل إلى ١٢٥٠٠ كم</option>
                                <option value="15000">ما يصل إلى ١٥٠٠٠ كم</option>
                                <option value="20000">ما يصل إلى ٢٠٠٠٠ كم</option>
                                <option value="22500">ما يصل إلى ٢٢٥٠٠ كم</option>
                                <option value="25000">ما يصل إلى ٢٥٠٠٠ كم</option>
                            </select>

                            @error('mileage')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        <div class="col-md-6">
                            <label class="form-label fw-bold small">المدينة</label>
                            <select class="form-select custom-input" wire:model.defer="city">
                                <option value="">اختر المدينة</option>

                                <option value="دمشق">دمشق</option>
                                <option value="ريف دمشق">ريف دمشق</option>
                                <option value="حلب">حلب</option>
                                <option value="حمص">حمص</option>
                                <option value="حماة">حماة</option>
                                <option value="اللاذقية">اللاذقية</option>
                                <option value="طرطوس">طرطوس</option>
                                <option value="درعا">درعا</option>
                                <option value="السويداء">السويداء</option>
                                <option value="القنيطرة">القنيطرة</option>
                                <option value="إدلب">إدلب</option>
                                <option value="الرقة">الرقة</option>
                                <option value="دير الزور">دير الزور</option>
                                <option value="الحسكة">الحسكة</option>

                            </select>

                            @error('city')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        <div class="col-12">
                            <label class="form-label fw-bold small d-block mb-2">مواصفات </label>

                            <div class="d-flex gap-2">

                                {{-- خيار 1 --}}
                                <button type="button" class="btn flex-grow-1 py-2
                {{ $specs === 'gcc' ? 'btn-success' : 'btn-outline-secondary' }}" wire:click="$set('specs', 'gcc')">
                                    مواصفات خليجية
                                </button>


                                <button type="button" class="btn flex-grow-1 py-2
                {{ $specs === 'non_gcc' ? 'btn-danger' : 'btn-outline-secondary' }}"
                                    wire:click="$set('specs', 'non_gcc')">
                                    مواصفات غير خليجية
                                </button>


                                <button type="button" class="btn flex-grow-1 py-2
                {{ $specs === 'unknown' ? 'btn-warning' : 'btn-outline-secondary' }}"
                                    wire:click="$set('specs', 'unknown')">
                                    لا أعلم
                                </button>

                            </div>

                            @error('specs')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small"> المواصفات</label>
                            <textarea class="form-control custom-input" rows="3"
                                wire:model.defer="description"></textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                    </div>
                    @endif


                    @if($step === 2)
                    <div class="upload-zone text-center p-4 border-2 border-dashed rounded-3 mb-3"
                        style="border-color: #d0d7de; background: #f8f9fa;">
                        <i class="bi bi-cloud-arrow-up text-primary display-5"></i>
                        <h6 class="mt-2 fw-bold">ارفع صور السيارة</h6>
                        <input type="file" class="form-control mt-3" wire:model="photos" multiple>
                        @error('photos.*') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        @if($photos)
                        @foreach($photos as $photo)
                        <img src="{{ $photo->temporaryUrl() }}" class="img-thumbnail rounded-3 shadow-sm"
                            style="width:120px; height:90px; object-fit:cover;">
                        @endforeach
                        @endif
                    </div>
                    @endif

                    {{-- STEP 3 --}}
                    @if($step === 3)
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-8 text-center">
                            <div class="card bg-light border-0 p-4 shadow-sm">
                                <label class="fw-bold mb-2">السعر الابتدائي</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white">ريال</span>
                                    <input type="number" class="form-control text-center fw-bold"
                                        wire:model.defer="starting_price">
                                </div>
                                @error('starting_price') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="card bg-light border-0 p-4 shadow-sm mt-3">
                                <label class="fw-bold mb-2">سعر الشراء الفوري (اختياري)</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white">ريال</span>
                                    <input type="number" class="form-control text-center fw-bold"
                                        wire:model.defer="buy_now_price">
                                </div>
                                @error('buy_now_price') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>
                    @endif

                </div>

                {{-- FOOTER --}}
                <div class="modal-footer border-0 px-4 pb-4">
                    <div class="d-flex w-100 gap-2">

                        @if($step > 1)
                        <button class="btn btn-outline-secondary px-4 py-2 flex-grow-1" wire:click="previousStep">
                            السابق
                        </button>
                        @endif

                        @if($step < 3)
                         <button class="btn btn-primary px-4 py-2 flex-grow-1 shadow"
                            wire:click="nextStep">
                            استمرار
                            </button>
                            @else
                            <button class="btn btn-success px-4 py-2 flex-grow-1 shadow" wire:click="save">
                                نشر المزاد الآن
                            </button>
                            @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
    @endif
</div>
