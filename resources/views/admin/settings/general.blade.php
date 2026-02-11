<div class="container page-rtl mt-4">
    

    <h3 class="mb-4 fw-bold">إعدادات الموقع</h3>

    <form wire:submit.prevent="save">


        <div class="mb-3">
            <label class="form-label">اسم الموقع</label>
            <input type="text" class="form-control" wire:model="site_name">
        </div>


        <div class="mb-3">
            <label class="form-label">الشعار</label>
            <input type="file" class="form-control" wire:model="site_logo">

            @if ($current_logo)
            <img src="{{ asset($current_logo) }}" class="mt-3" width="120">
            @endif
        </div>





        <button class="btn btn-success px-4">حفظ الإعدادات</button>

    </form>

</div>
