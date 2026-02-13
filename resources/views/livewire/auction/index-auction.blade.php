<div wire:poll.5s>

    {{-- صندوق الفلترة --}}
    <div class="card p-3 mb-4 shadow-sm">
        <h5 class="fw-bold mb-3">فلترة النتائج</h5>

        <div class="row g-3">

            {{-- الحالة --}}
            <div class="col-md-3">
                <label class="form-label">الحالة</label>
                <select class="form-select" wire:model.lazy="filterStatus">
                    <option value="">الكل</option>
                    <option value="pending">معلق</option>
                    <option value="active">نشط</option>
                    <option value="closed">مغلق</option>
                    <option value="rejected">مرفوض</option>
                    <option value="completed">مكتمل</option>
                </select>
            </div>

            {{-- المحافظة --}}
            <div class="col-md-3">
                <label class="form-label">المحافظة</label>
                <select class="form-select" wire:model.debounce.300ms="filterCity">
                    <option value="">الكل</option>
                    <option value="بغداد">بغداد</option>
                    <option value="البصرة">البصرة</option>
                    <option value="نينوى">نينوى</option>
                    <option value="أربيل">أربيل</option>
                    <option value="السليمانية">السليمانية</option>
                    <option value="دهوك">دهوك</option>
                    <option value="النجف">النجف</option>
                    <option value="كربلاء">كربلاء</option>
                    <option value="الأنبار">الأنبار</option>
                    <option value="ديالى">ديالى</option>
                    <option value="صلاح الدين">صلاح الدين</option>
                    <option value="واسط">واسط</option>
                    <option value="ميسان">ميسان</option>
                    <option value="ذي قار">ذي قار</option>
                    <option value="المثنى">المثنى</option>
                    <option value="بابل">بابل</option>
                    <option value="القادسية">القادسية</option>
                    <option value="كركوك">كركوك</option>
                </select>
            </div>

            {{-- الماركة --}}
            <div class="col-md-3">
                <label class="form-label">الماركة</label>
                <select class="form-select" wire:model.lazy="filterBrand">
                    <option value="">الكل</option>
                    @foreach(\App\Models\Brand::orderBy('name')->get() as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- الموديل --}}
            <div class="col-md-3">
                <label class="form-label">الموديل</label>
                <select class="form-select" wire:model.lazy="filterModel">
                    <option value="">الكل</option>
                    @if($models)
                        @foreach($models as $model)
                            <option value="{{ $model->id }}">{{ $model->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            {{-- المواصفات --}}
            <div class="col-md-3">
                <label class="form-label">المواصفات</label>
                <select class="form-select" wire:model.lazy="filterSpecs">
                    <option value="">الكل</option>
                    <option value="gcc">خليجية</option>
                    <option value="non_gcc">غير خليجية</option>
                    <option value="unknown">لا أعلم</option>
                </select>
            </div>

        </div>
    </div>

    {{-- العنوان --}}
    <div class="text-center mb-4">
        <h4 class="fw-bold">قائمة المزادات</h4>
        <hr class="mx-auto" style="width: 120px;">
    </div>

    {{-- عرض المزادات --}}
    @if($auctions->count())
        <div class="row row-cols-1 row-cols-md-2 g-4">

            @foreach($auctions as $auction)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">

                    @php
                        $media = $auction->car->getFirstMedia('cars');

                        $statusNames = [
                            'pending'   => 'معلق',
                            'active'    => 'نشط',
                            'closed'    => 'مغلق',
                            'rejected'  => 'مرفوض',
                            'completed' => 'مكتمل',
                        ];

                        $statusColors = [
                            'pending'   => 'warning text-dark',
                            'active'    => 'primary',
                            'closed'    => 'secondary',
                            'rejected'  => 'danger',
                            'completed' => 'success',
                        ];

                        $status = $auction->status ?? 'pending';
                        $statusText  = $statusNames[$status] ?? $status;
                        $statusColor = $statusColors[$status] ?? 'secondary';
                    @endphp

                    {{-- صورة السيارة --}}
                    <div class="position-relative">
                        @if($media)
                            <img src="{{ $media->getUrl() }}" class="card-img-top" style="height:220px; object-fit:cover;">
                        @endif

                        <span class="badge bg-{{ $statusColor }} position-absolute top-0 end-0 m-2 px-3 py-2">
                            {{ $statusText }}
                        </span>
                    </div>

                    {{-- تفاصيل --}}
                    <div class="card-body">

                        <h5 class="card-title fw-bold">
                            {{ $auction->car->brand->name }}
                            {{ $auction->car->model->name ?? '' }}
                            <span class="text-muted">({{ $auction->car->year }})</span>
                        </h5>

                        <ul class="list-unstyled small mt-3">
                            <li class="mb-1">
                                <i class="bi bi-geo-alt text-danger"></i>
                                <strong>المدينة:</strong> {{ $auction->car->city }}
                            </li>

                            <li class="mb-1">
                                <i class="bi bi-cash-coin text-success"></i>
                                <strong>السعر الابتدائي:</strong> {{ number_format($auction->starting_price) }} $
                            </li>
                        </ul>

                        {{-- زر التفاصيل --}}
                        <a href="{{ route('auction.show', $auction->id) }}" class="btn btn-outline-primary w-100 mt-3">
                            عرض التفاصيل
                        </a>

                        {{-- زر المزايدات --}}
                        @if($auction->status === 'active')
                            <a href="{{ route('auction.selles.details', $auction->id) }}"
                               class="btn btn-outline-success w-100 mt-2">
                                عرض المزايدات
                            </a>
                        @else
                            <button class="btn btn-secondary w-100 mt-2" disabled>
                                المزاد غير نشط
                            </button>
                        @endif

                    </div>
                </div>
            </div>
            @endforeach

        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $auctions->links('pagination::bootstrap-5') }}
        </div>

    @else
        <div class="d-flex justify-content-center align-items-center" style="min-height: 60vh;">
            <div class="text-center">
                <h5 class="text-muted mb-2">لا يوجد مزادات</h5>
                <p class="text-muted">لا يوجد أي مزادات حتى الآن.</p>
            </div>
        </div>
    @endif

</div>
