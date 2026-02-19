
<div class="card mb-4 p-3">
    <h5>إضافة ماركة جديدة</h5>

    {{-- @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif --}}

    <form wire:submit.prevent="save" enctype="multipart/form-data">
        <div class="mb-3">
            <label>اسم الماركة</label>
            <input type="text" wire:model="name" class="form-control">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label>صورة الماركة</label>
            <input type="file" wire:model="image" class="form-control">
            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-success">إضافة الماركة</button>
    </form>
</div>
