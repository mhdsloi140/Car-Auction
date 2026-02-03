<div>
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped text-center">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>الصورة</th>
                <th>اسم الماركة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($brands as $index => $brand)
                <tr>
                    <td>{{ $brands->firstItem() + $index }}</td>
                    <td>
                        <img src="{{ $brand->getFirstMediaUrl('brands') ?: 'https://via.placeholder.com/60' }}" width="60" height="60">
                    </td>
                    <td>{{ $brand->name }}</td>
                    <td>
                         {{-- <button class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $brand->id }})">
                            حذف
                        </button> --}}


                    <form action="{{ route('brand.destroy',$brand->id) }}"  method="POST">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm btn-danger">حذف</button>
                    </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">لا توجد ماركات</td>
                </tr>
            @endforelse
        </tbody>
    </table>

  <div class="d-flex justify-content-center mt-3">
    {{ $brands->links('pagination::bootstrap-5') }}
</div>
 <script>
        document.addEventListener('livewire:load', () => {
            Livewire.on('confirm-delete', () => {
                if(confirm('هل أنت متأكد من حذف هذه الماركة؟')) {
                    Livewire.dispatch('delete');
                }
            });
        });
    </script>
</div>
