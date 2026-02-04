<div dir="rtl">

    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold">إدارة الموديلات</h4>
        <button class="btn btn-primary" wire:click="showCreateModal">إضافة موديل</button>
    </div>

    <table class="table table-striped text-center" dir="rtl">
        <thead>
            <tr>
                <th>الموديل</th>
                <th>الماركة</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($models as $model)
                <tr>
                    <td>{{ $model->name }}</td>
                    <td>{{ $model->brand->name }}</td>

                    <td>
                        <button class="btn btn-warning btn-sm" wire:click="showEditModal({{ $model->id }})">تعديل</button>
                        <button class="btn btn-danger btn-sm" wire:click="delete({{ $model->id }})">حذف</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-3">
        {{ $models->links('pagination::bootstrap-5') }}
    </div>


  @if($modalVisible)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5)">
        <div class="modal-dialog">
            <div class="modal-content">

                 <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $isEdit ? 'تعديل الموديل' : 'إضافة موديل' }}
                    </h5>
                    <button class="btn-close" wire:click="$set('modalVisible', false)"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>اسم الموديل</label>
                        <input type="text" class="form-control" wire:model.defer="name">
                    </div>

                    <div class="mb-3">
                        <label>الماركة</label>
                        <select class="form-select" wire:model="brand_id">
                            <option value="">اختر الماركة</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
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
