<?php

namespace App\Livewire\Brand;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Brand;

class CreateBrand extends Component
{
    use WithFileUploads;

    public $name;
    public $image;

    public function save()
    {
        $this->validate([
            'name'  => 'required|string|max:255|unique:brands,name',
            'image' => 'nullable|image|max:2048',
        ], [
            'name.required' => 'اسم الماركة مطلوب',
            'name.unique'   => 'اسم الماركة موجود مسبقًا',
            'image.image'   => 'يجب رفع صورة صالحة',
        ]);

        $brand = Brand::create([
            'name' => $this->name,
        ]);

        if ($this->image) {
            $brand->addMedia($this->image)
                  ->toMediaCollection('brands');
        }

        $this->reset(['name', 'image']);

        session()->flash('success', 'تمت إضافة الماركة بنجاح');

        $this->dispatch('brand-added');
    }

    public function render()
    {
        return view('livewire.brand.create-brand');
    }
}
