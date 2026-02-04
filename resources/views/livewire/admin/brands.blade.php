<div>

    <div class="d-flex justify-content-between mb-3" style="padding-top:20px ">
         <button class="btn btn-primary" wire:click="showCreateModal">إضافة ماركة</button>
        <h4 class="fw-bold">إدارة الماركات</h4>

    </div>

    <table class="table table-striped text-center"dir="rtl">
        <thead>
            <tr>
                <th>الشعار</th>
                <th>الاسم</th>
                <th>عدد الموديلات</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($brands as $brand)
            <tr>
                <td>
                    @if($brand->getFirstMediaUrl('logo'))
                    <img src="{{ $brand->getFirstMediaUrl('logo') }}" width="50">
                    @else
                    <span class="text-muted">لا يوجد</span>
                    @endif
                </td>

                <td>{{ $brand->name }}</td>

                <td>{{ $brand->models()->count() }}</td>

                <td>
                    <button class="btn btn-warning btn-sm" wire:click="showEditModal({{ $brand->id }})">تعديل</button>
                    <button class="btn btn-danger btn-sm" wire:click="delete({{ $brand->id }})">حذف</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $brands->links('pagination::bootstrap-5') }}
    </div>

    {{-- المودال --}}
    @if($modalVisible)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5)">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $isEdit ? 'تعديل ماركة' : 'إضافة ماركة' }}
                    </h5>
                    <button class="btn-close" wire:click="$set('modalVisible', false)"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>اسم الماركة</label>
                        <input type="text" class="form-control" wire:model.defer="name">
                    </div>

                    <div class="mb-3">
                        <label>الشعار (اختياري)</label>
                        <input type="file" class="form-control" wire:model="logo">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" wire:click="$set('modalVisible', false)">إلغاء</button>
                    <button class="btn btn-primary" wire:click="save">حفظ</button>
                </div>

            </div>
        </div>
    </div>
    @endif

</div>
