<div class="container-fluid" dir="rtl" style="padding-top:20px ">

    @if (session()->has('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
    @endif

    <div class="d-flex justify-content-between mb-3">

        <h3 class="fw-bold">إدارة المستخدمين</h3>

        <div class="d-flex gap-2">

            <select class="form-select" style="width: 180px" wire:model.lazy="filterRole">
                <option value="all">عرض الجميع</option>
                <option value="user">المستخدمين</option>
                <option value="seller">البائعين</option>
            </select>

            <button class="btn btn-primary" wire:click="showCreateModal">إضافة مستخدم</button>
        </div>

    </div>

    <div class="card">
        <div class="card-body">


            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>رقم الهاتف</th>

                        <th>الدور</th>
                        <th>العمليات</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone }}</td>

                        @php
                        $roleNames = [
                        'seller' => 'بائع',
                        'user' => 'زبون',
                        'admin' => 'مدير',
                        ];

                        $role = $user->roles->first()?->name;
                        @endphp

                        <td>{{ $roleNames[$role] ?? 'غير معروف' }}</td>

                        <td>

                            <button class="btn btn-danger btn-sm" wire:click="delete({{ $user->id }})">حذف</button>

                            @if($user->status === 'active')
                            <button class="btn btn-dark btn-sm" wire:click="toggleStatus({{ $user->id }})">حظر</button>
                            @else
                            <button class="btn btn-success btn-sm" wire:click="toggleStatus({{ $user->id }})">إلغاء
                                الحظر</button>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>


        </div>
    </div>


    @if($modalFormVisible)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5)">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $isEdit ? 'تعديل مستخدم' : 'إضافة مستخدم' }}
                    </h5>
                    <button type="button" class="btn-close position-absolute start-0 ms-3 mt-2"
                        wire:click="$set('modalFormVisible', false)"></button>

                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>الاسم</label>
                        <input type="text" class="form-control" wire:model="name">
                    </div>


                    <div class="mb-3">
                        <label>رقم الهاتف</label>
                        <input type="text" class="form-control" wire:model.defer="phone">
                        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label>الدور</label>
                        <select class="form-control" wire:model="role">
                            <option value="">اختر الدور</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" wire:click="$set('modalFormVisible', false)">إلغاء</button>
                    <button class="btn btn-primary" wire:click="save">حفظ</button>
                </div>

            </div>
        </div>
    </div>
    @endif

</div>
