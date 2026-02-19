<div style="direction: rtl; text-align: right;" class="p-3">

    <button class="btn btn-lg btn-success shadow-sm d-flex align-items-center gap-2 px-4 rounded-pill transition-all"
        wire:click="openModal"
        style="font-weight: 600; border: none; background: linear-gradient(45deg, #198754, #20c997);">
        <i class="bi bi-plus-circle-fill"></i>
        <span>إضافة سيارة </span>
    </button>

    @if($showModal)
    <div class="modal fade show d-block p-4" style="background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(6px);"
        wire:ignore.self>

        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.25rem; overflow: hidden;">

                {{-- HEADER --}}
                <div class="modal-header border-0 bg-light px-4 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                        <span class="badge bg-primary rounded-pill px-3 py-2">{{ $step }}/3</span>
                        <span>
                            @if($step === 1) بيانات السيارة الأساسية
                            @elseif($step === 2) الصور والمستندات
                            @else إعدادات المزاد
                            @endif
                        </span>
                    </h5>
                    <!-- زر الإغلاق على اليمين -->
                    <button type="button" class="btn-close" aria-label="Close" wire:click="closeModal"></button>
                </div>

                {{-- PROGRESS BAR --}}
                <div class="progress rounded-0" style="height: 4px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($step/3)*100 }}%;"></div>
                </div>

                {{-- BODY --}}
                <div class="modal-body px-4 py-4" style="max-height: 70vh; overflow-y: auto;">

                    {{-- STEP 1 --}}
                    @if($step === 1)
                    <div class="row g-3">
                        <!-- بيانات السيارة الأساسية هنا -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">الماركة</label>
                            <select wire:model.live="brand_id" class="form-select">
                                <option value="">اختر الماركة</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">الموديل</label>
                            <select wire:model.live="model_id" class="form-select" @disabled(!$brand_id)>
                                <option value="">اختر الموديل</option>
                                @foreach($models as $model)
                                <option value="{{ $model->id }}">{{ $model->name }}</option>
                                @endforeach
                            </select>
                            @error('model_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">سنة الصنع</label>
                            <select wire:model.live="year" class="form-select">
                                <option value="">اختر السنة</option>
                                @foreach($years as $y)
                                <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
                            </select>
                            @error('year') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">عدد الكيلومترات</label>
                            <select class="form-select" wire:model.defer="mileage">
                                <option value="">اختر عدد الكيلومترات</option>
                                @foreach([500,1000,1500,2000,3000,4000,5000,6000,8000,10000,12500,15000,20000,22500,25000]
                                as $km)
                                <option value="{{ $km }}">ما يصل إلى {{ $km }} كم</option>
                                @endforeach
                            </select>
                            @error('mileage') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">المدينة</label>
                            <select class="form-select" wire:model.defer="city">
                                <option value="">اختر المدينة</option>
                                @foreach(['بغداد','البصرة','نينوى','أربيل','السليمانية','دهوك','النجف','كربلاء','الأنبار','ديالى','صلاح
                                الدين','واسط','ميسان','ذي قار','المثنى','بابل','القادسية','كركوك'] as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                                @endforeach
                            </select>
                            @error('city') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small d-block mb-2">مواصفات</label>
                            <div class="d-flex gap-2">
                                @foreach(['gcc'=>'خليجية','non_gcc'=>'غير خليجية','unknown'=>'لا أعلم'] as $key=>$label)
                                <button type="button"
                                    class="btn flex-grow-1 py-2 {{ $specs === $key ? 'btn-success' : 'btn-outline-secondary' }}"
                                    wire:click="$set('specs','{{ $key }}')">{{ $label }}</button>
                                @endforeach
                            </div>
                            @error('specs') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small">مواصفات إضافية</label>
                            <textarea class="form-control" rows="3" wire:model.defer="description"></textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    @endif

                    {{-- STEP 2 --}}
                    @if($step === 2)
                    <div class="upload-zone text-center p-4 border border-dashed rounded-3 mb-3"
                        style="border-color: #d0d7de; background: #f8f9fa;">
                        <i class="bi bi-cloud-arrow-up text-primary display-5"></i>
                        <h6 class="mt-2 fw-bold">ارفع صور السيارة</h6>

                        <input type="file" class="form-control mt-3" wire:model.live="photos" multiple>

                        @error('photos')
                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror

                        @error('photos.*')
                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        @foreach($photos as $index => $photo)
                        {{-- {{ $photo->getMimeType() }} --}}

                        @php
                        $mime = $photo->getMimeType();
                        @endphp

                        @if(str_starts_with($mime, 'image/'))
                        <img src="{{ $photo->temporaryUrl() }}" class="img-thumbnail rounded-3 shadow-sm"
                            style="width:120px; height:90px; object-fit:cover;">
                        @else
                        <div class="img-thumbnail rounded-3 shadow-sm d-flex align-items-center justify-content-center"
                            style="width:120px; height:90px; background:#eee;">
                            <span class="text-muted small">غير قابل للمعاينة</span>
                        </div>
                        @endif


                        @endforeach
                    </div>


                    @endif

                    {{-- STEP 3 --}}
      <!-- STEP 3: رفع كشف السيارة -->
@if($step === 3)
<div class="row g-4 justify-content-center">
    <div class="col-md-8 text-center">
        <label class="fw-bold mb-2">ملف الكشف <span class="text-danger">*</span></label>
        <input type="file" class="form-control @error('report_pdf') is-invalid @enderror"
               wire:model="report_pdf"
               accept=".pdf,.jpg,.jpeg,.png,.webp">

        @if($report_pdf)
            <div class="mt-2 text-success">
                تم رفع الملف: {{ $report_pdf->getClientOriginalName() }}
            </div>
        @endif

        @error('report_pdf')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
@endif

<!-- زر الحفظ -->
@if($step === 3)
{{-- <button class="btn btn-success mt-3" wire:click="save" wire:loading.attr="disabled" wire:target="save">
    <span wire:loading.remove wire:target="save">نشر الآن</span>
    <span wire:loading wire:target="save">جارٍ النشر...</span>
</button> --}}
@endif


                </div>

                {{-- FOOTER --}}
                <div class="modal-footer border-0 px-4 pb-4">
                    <div class="d-flex w-100 gap-2">
                        @if($step > 1)
                        <button class="btn btn-outline-secondary px-4 py-2 flex-grow-1"
                            wire:click="previousStep">السابق</button>
                        @endif
                        @if($step < 3) <button class="btn btn-primary px-4 py-2 flex-grow-1 shadow"
                            wire:click="nextStep">استمرار</button>
                            @else
                            <button class="btn btn-success px-4 py-2 flex-grow-1 shadow" wire:click="save"
                                wire:loading.attr="disabled" wire:target="save">
                                <span wire:loading.remove wire:target="save">نشر الآن</span>
                                <span wire:loading wire:target="save">
                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                    جاري النشر...
                                </span>
                            </button>

                            @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
    Livewire.hook('element.updated', () => {

        const input = document.querySelector('input[type="file"][wire\\:model\\.live="photos"]');
        if (!input) return;

        const files = input.files;
        if (!files.length) return;

        document.querySelectorAll('[data-webp-preview]').forEach(box => {
            const index = box.getAttribute('data-webp-preview');
            const file = files[index];

            if (!file) return;
            if (file.type !== 'image/webp') return;

            const reader = new FileReader();
            reader.onload = e => {
                box.innerHTML = `
                    <img src="${e.target.result}"
                         class="img-thumbnail rounded-3 shadow-sm"
                         style="width:120px; height:90px; object-fit:cover;">
                `;
            };
            reader.readAsDataURL(file);
        });
    });
});
    </script>


    @endif


</div>
