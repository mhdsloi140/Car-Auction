<div class="container-fluid" dir="rtl" style="padding-top:20px">

    {{-- رسائل التنبيه --}}
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close me-auto" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close me-auto" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if (session()->has('info'))
    <div class="alert alert-info alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bi bi-info-circle-fill me-2"></i>
        {{ session('info') }}
        <button type="button" class="btn-close me-auto" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- رأس الصفحة --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-people-fill text-primary ms-2"></i>
            إدارة المستخدمين
            <span class="badge bg-secondary ms-2">{{ $users->total() }}</span>
        </h3>
        <div class="d-flex gap-2">
            <select class="form-select" style="width: 180px" wire:model.live="filterRole">
                <option value="all">📋 عرض الجميع</option>
                <option value="user">👤 المستخدمين</option>
                <option value="seller">💼 البائعين</option>
                <option value="admin">👑 المديرين</option>
            </select>
            <button class="btn btn-primary" wire:click="showCreateModal">
                <i class="bi bi-plus-circle me-1"></i>
                إضافة مستخدم
            </button>
        </div>
    </div>

    {{-- جدول المستخدمين --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 pe-4">#</th>
                            <th class="py-3">الاسم</th>
                            <th class="py-3">رقم الهاتف</th>
                            <th class="py-3">الدور</th>
                            <th class="py-3">الحالة</th>
                            <th class="py-3">تاريخ التسجيل</th>
                            <th class="py-3">العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="pe-4">{{ $user->id }}</td>
                            <td>
                                <a href="#" wire:click.prevent="showAuctions({{ $user->id }})"
                                   class="text-primary fw-bold text-decoration-none hover-underline">
                                    <i class="bi bi-person-circle me-1"></i>
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td dir="ltr">
                                @if($user->phone)
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-telephone ms-1"></i>
                                        {{ $user->phone }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            @php
                            $roleNames = [
                                'seller' => 'بائع',
                                'user' => 'زبون',
                                'admin' => 'مدير',
                                'buyer'=>'مبيعات'
                            ];
                            $roleColors = [
                                'seller' => 'success',
                                'user' => 'info',
                                'admin' => 'warning',
                                'buyer'=>'primary'
                            ];
                            $roleIcons = [
                                'seller' => 'briefcase',
                                'user' => 'person',
                                'admin' => 'shield',
                                'buyer'=>'person'
                            ];
                            $role = $user->roles->first()?->name;
                            $roleLabel = $roleNames[$role] ?? 'غير معروف';
                            $roleColor = $roleColors[$role] ?? 'secondary';
                            $roleIcon = $roleIcons[$role] ?? 'person';
                            @endphp
                            <td>
                                <span class="badge bg-{{ $roleColor }}-subtle text-{{ $roleColor }} px-3 py-2 rounded-pill">
                                    <i class="bi bi-{{ $roleIcon }} me-1"></i>
                                    {{ $roleLabel }}
                                </span>
                            </td>
                            <td>
                                @if($user->status === 'active')
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        نشط
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill">
                                        <i class="bi bi-slash-circle-fill me-1"></i>
                                        محظور
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="text-muted small">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $user->created_at->format('Y-m-d') }}
                                </span>
                                <br>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $user->created_at->diffForHumans() }}
                                </small>
                            </td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    {{-- زر الحذف --}}
                                    <button class="btn btn-outline-danger btn-sm"
                                            wire:click="confirmDelete({{ $user->id }})"
                                            title="حذف المستخدم">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    {{-- زر تعديل --}}
                                    <button class="btn btn-outline-primary btn-sm"
                                            wire:click="showEditModal({{ $user->id }})"
                                            title="تعديل المستخدم">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    {{-- زر تغيير الحالة --}}
                                    @if($user->status === 'active')
                                    <button class="btn btn-outline-dark btn-sm"
                                            wire:click="confirmBlock({{ $user->id }})"
                                            title="حظر المستخدم">
                                        <i class="bi bi-ban"></i>
                                    </button>
                                    @else
                                    <button class="btn btn-outline-success btn-sm"
                                            wire:click="confirmUnblock({{ $user->id }})"
                                            title="إلغاء الحظر">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-people display-1 text-muted d-block mb-3"></i>
                                <h5 class="text-muted">لا يوجد مستخدمين</h5>
                                <p class="text-muted">لم يتم إضافة أي مستخدمين بعد</p>
                                @if($filterRole !== 'all')
                                <button class="btn btn-primary mt-3" wire:click="$set('filterRole', 'all')">
                                    <i class="bi bi-arrow-repeat me-1"></i>
                                    عرض جميع المستخدمين
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    @if($users->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
    @endif

    {{-- مودال إضافة/تعديل مستخدم --}}
    @if($modalFormVisible)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5); z-index: 1050;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white border-0 rounded-top-4">
                    <h5 class="modal-title">
                        <i class="bi {{ $isEdit ? 'bi-pencil-fill' : 'bi-person-plus-fill' }} me-2"></i>
                        {{ $isEdit ? 'تعديل المستخدم' : 'إضافة مستخدم جديد' }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="$set('modalFormVisible', false)"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-person ms-1"></i>
                            الاسم
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               wire:model="name" placeholder="أدخل الاسم الكامل">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-telephone ms-1"></i>
                            رقم الهاتف
                        </label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                               wire:model="phone" placeholder="أدخل رقم الهاتف" dir="ltr">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-shield-lock ms-1"></i>
                            الصلاحية
                        </label>
                        <select class="form-select @error('role') is-invalid @enderror" wire:model="role">
                            <option value="">اختر الصلاحية</option>
                            @foreach(['user' => 'زبون', 'seller' => 'بائع', 'admin' => 'مدير'] as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    @if(!$isEdit)
                    <div class="alert alert-info d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle-fill fs-4"></i>
                        <div>
                            <strong>ملاحظة:</strong>
                            <p class="mb-0">سيتم إنشاء كلمة مرور تلقائية وإرسالها إلى رقم الهاتف</p>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="modal-footer border-0">
                    <button class="btn btn-secondary px-4 rounded-pill" wire:click="$set('modalFormVisible', false)">
                        <i class="bi bi-x-lg me-1"></i>
                        إلغاء
                    </button>
                    <button class="btn btn-primary px-4 rounded-pill" wire:click="save" wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            <i class="bi {{ $isEdit ? 'bi-check-lg' : 'bi-person-plus' }} me-1"></i>
                            {{ $isEdit ? 'تحديث' : 'إضافة' }}
                        </span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2"></span>
                            جاري الحفظ...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- مودال حذف المستخدم --}}
    @if($deleteModalVisible)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5); z-index: 1050;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-danger text-white border-0 rounded-top-4">
                    <h5 class="modal-title">
                        <i class="bi bi-trash-fill me-2"></i>
                        تأكيد حذف المستخدم
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="$set('deleteModalVisible', false)"></button>
                </div>

                <div class="modal-body p-4 text-center">
                    <div class="mb-4">
                        <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex p-4">
                            <i class="bi bi-exclamation-triangle-fill text-danger fs-1"></i>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3">هل أنت متأكد من حذف هذا المستخدم؟</h5>

                    <div class="bg-light p-3 rounded-3 text-start mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <i class="bi bi-person-circle fs-4 text-primary"></i>
                            <div>
                                <small class="text-muted d-block">الاسم</small>
                                <span class="fw-bold">{{ $selectedUser->name ?? '' }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <i class="bi bi-telephone fs-4 text-success"></i>
                            <div>
                                <small class="text-muted d-block">رقم الهاتف</small>
                                <span class="fw-bold">{{ $selectedUser->phone ?? 'لا يوجد' }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-tag fs-4 text-info"></i>
                            <div>
                                <small class="text-muted d-block">الدور</small>
                                @php
                                $roleLabels = ['seller' => 'بائع', 'user' => 'زبون', 'admin' => 'مدير'];
                                $role = $selectedUser->roles->first()?->name ?? 'غير معروف';
                                @endphp
                                <span class="fw-bold">{{ $roleLabels[$role] ?? $role }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-circle-fill fs-4"></i>
                        <div class="text-start">
                            <strong class="d-block">تحذير!</strong>
                            <span>لا يمكن التراجع عن هذا الإجراء. سيتم حذف جميع بيانات المستخدم نهائياً.</span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button class="btn btn-secondary px-4 rounded-pill" wire:click="$set('deleteModalVisible', false)">
                        <i class="bi bi-x-lg me-1"></i>
                        إلغاء
                    </button>
                    <button class="btn btn-danger px-4 rounded-pill" wire:click="confirmDeleteAction" wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            <i class="bi bi-trash me-1"></i>
                            نعم، تأكيد الحذف
                        </span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2"></span>
                            جاري الحذف...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- مودال حظر المستخدم --}}
    @if($blockModalVisible)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5); z-index: 1050;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-dark text-white border-0 rounded-top-4">
                    <h5 class="modal-title">
                        <i class="bi bi-ban me-2"></i>
                        تأكيد حظر المستخدم
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="$set('blockModalVisible', false)"></button>
                </div>

                <div class="modal-body p-4 text-center">
                    <div class="mb-4">
                        <div class="bg-dark bg-opacity-10 rounded-circle d-inline-flex p-4">
                            <i class="bi bi-shield-lock-fill text-dark fs-1"></i>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3">هل أنت متأكد من حظر هذا المستخدم؟</h5>

                    <div class="bg-light p-3 rounded-3 text-start mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <i class="bi bi-person-circle fs-4 text-primary"></i>
                            <div>
                                <small class="text-muted d-block">الاسم</small>
                                <span class="fw-bold">{{ $selectedUser->name ?? '' }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <i class="bi bi-shield fs-4 text-warning"></i>
                            <div>
                                <small class="text-muted d-block">الحالة الحالية</small>
                                <span class="badge bg-success-subtle text-success px-3 py-2">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    نشط
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-circle-fill fs-4"></i>
                        <div class="text-start">
                            <strong class="d-block">تنبيه!</strong>
                            <span>المستخدم المحظور لن يتمكن من الدخول إلى النظام أو المشاركة في المزادات.</span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button class="btn btn-secondary px-4 rounded-pill" wire:click="$set('blockModalVisible', false)">
                        <i class="bi bi-x-lg me-1"></i>
                        إلغاء
                    </button>
                    <button class="btn btn-dark px-4 rounded-pill" wire:click="confirmBlockAction" wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            <i class="bi bi-ban me-1"></i>
                            نعم، تأكيد الحظر
                        </span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2"></span>
                            جاري الحظر...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- مودال إلغاء الحظر --}}
    @if($unblockModalVisible)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5); z-index: 1050;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-success text-white border-0 rounded-top-4">
                    <h5 class="modal-title">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        تأكيد إلغاء الحظر
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="$set('unblockModalVisible', false)"></button>
                </div>

                <div class="modal-body p-4 text-center">
                    <div class="mb-4">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-4">
                            <i class="bi bi-shield-check text-success fs-1"></i>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3">هل أنت متأكد من إلغاء حظر هذا المستخدم؟</h5>

                    <div class="bg-light p-3 rounded-3 text-start mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <i class="bi bi-person-circle fs-4 text-primary"></i>
                            <div>
                                <small class="text-muted d-block">الاسم</small>
                                <span class="fw-bold">{{ $selectedUser->name ?? '' }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-shield fs-4 text-warning"></i>
                            <div>
                                <small class="text-muted d-block">الحالة الحالية</small>
                                <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                    <i class="bi bi-slash-circle-fill me-1"></i>
                                    محظور
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle-fill fs-4"></i>
                        <div class="text-start">
                            <strong class="d-block">ملاحظة!</strong>
                            <span>بعد إلغاء الحظر، سيتمكن المستخدم من الدخول إلى النظام والمشاركة في المزادات.</span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button class="btn btn-secondary px-4 rounded-pill" wire:click="$set('unblockModalVisible', false)">
                        <i class="bi bi-x-lg me-1"></i>
                        إلغاء
                    </button>
                    <button class="btn btn-success px-4 rounded-pill" wire:click="confirmUnblockAction" wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            <i class="bi bi-check-circle me-1"></i>
                            نعم، إلغاء الحظر
                        </span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2"></span>
                            جاري التنفيذ...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- مودال المزادات --}}
    @if($auctionModalVisible)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5); z-index: 1050;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white border-0 rounded-top-4">
                    <h5 class="modal-title">
                        <i class="bi bi-graph-up me-2"></i>
                        مزادات {{ $selectedUser->name }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="$set('auctionModalVisible', false)"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="bg-success bg-opacity-10 p-4 rounded-4 text-center">
                                <i class="bi bi-check-circle-fill text-success fs-1 mb-2"></i>
                                <h6 class="text-muted mb-2">المقبولة</h6>
                                <span class="display-6 fw-bold text-success">{{ $acceptedAuctionsCount }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-danger bg-opacity-10 p-4 rounded-4 text-center">
                                <i class="bi bi-x-circle-fill text-danger fs-1 mb-2"></i>
                                <h6 class="text-muted mb-2">المرفوضة</h6>
                                <span class="display-6 fw-bold text-danger">{{ $rejectedAuctionsCount }}</span>
                            </div>
                        </div>
                    </div>

                    @if($acceptedAuctionsCount + $rejectedAuctionsCount > 0)
                    <div class="mt-4">
                        <div class="progress" style="height: 10px;">
                            @php
                            $total = $acceptedAuctionsCount + $rejectedAuctionsCount;
                            $acceptedPercent = ($acceptedAuctionsCount / $total) * 100;
                            $rejectedPercent = ($rejectedAuctionsCount / $total) * 100;
                            @endphp
                            <div class="progress-bar bg-success" style="width: {{ $acceptedPercent }}%"></div>
                            <div class="progress-bar bg-danger" style="width: {{ $rejectedPercent }}%"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2 small">
                            <span class="text-success">{{ round($acceptedPercent) }}% مقبولة</span>
                            <span class="text-danger">{{ round($rejectedPercent) }}% مرفوضة</span>
                        </div>
                    </div>
                    @else
                    <div class="text-center text-muted mt-4">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        <p>لا يوجد مزادات لهذا المستخدم</p>
                    </div>
                    @endif
                </div>

                <div class="modal-footer border-0">
                    <button class="btn btn-secondary px-4 rounded-pill" wire:click="$set('auctionModalVisible', false)">
                        <i class="bi bi-x-lg me-1"></i>
                        إغلاق
                    </button>
                </div>

            </div>
        </div>
    </div>
    @endif

</div>

@push('styles')
<style>
    .hover-underline:hover {
        text-decoration: underline !important;
    }
    .modal-backdrop {
        z-index: 1040 !important;
    }
    .modal {
        z-index: 1050 !important;
    }
    .btn-outline-danger, .btn-outline-dark, .btn-outline-success, .btn-outline-primary {
        transition: all 0.2s ease;
    }
    .btn-outline-danger:hover, .btn-outline-dark:hover, .btn-outline-success:hover, .btn-outline-primary:hover {
        transform: scale(1.05);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        // تنظيف backdrop عند إغلاق المودال
        Livewire.on('modal-closed', () => {
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            document.body.classList.remove('modal-open');
        });
    });
</script>
@endpush
