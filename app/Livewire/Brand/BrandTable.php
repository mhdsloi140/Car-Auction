<?php

namespace App\Livewire\Brand;

use Livewire\Component;
use App\Models\Brand;
use Livewire\WithPagination;

class BrandTable extends Component
{
    use WithPagination;

    public $brandIdToDelete;

    protected $listeners = [
        'brandAdded' => '$refresh',   
    ];


    public function confirmDelete($id)
    {
        $this->brandIdToDelete = $id;
        $this->dispatch('confirm-delete');
    }



    public function delete()
    {
        if (!$this->brandIdToDelete) return;

        $brand = Brand::findOrFail($this->brandIdToDelete);

        if ($brand->hasMedia('brands')) {
            $brand->clearMediaCollection('brands');
        }

        $brand->delete();

        session()->flash('success', 'تم حذف الماركة بنجاح');

        $this->brandIdToDelete = null;

        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.brand.brand-table', [
            'brands' => Brand::orderBy('id', 'desc')->paginate(2),
        ]);
    }
}
