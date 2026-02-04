<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Brand;
use Livewire\WithFileUploads;

class Brands extends Component
{
    use WithPagination, WithFileUploads;

    public $name, $brand_id, $logo;
    public $modalVisible = false;
    public $isEdit = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|unique:brands,name,' . $this->brand_id,
            'logo' => 'nullable|image|max:2048',
        ];
    }

    public function showCreateModal()
    {
        $this->resetFields();
        $this->isEdit = false;
        $this->modalVisible = true;
    }

    public function showEditModal($id)
    {
        $this->resetFields();
        $this->isEdit = true;

        $brand = Brand::findOrFail($id);

        $this->brand_id = $id;
        $this->name = $brand->name;

        $this->modalVisible = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEdit) {
            $brand = Brand::findOrFail($this->brand_id);
            $brand->update(['name' => $this->name]);

            if ($this->logo) {
                $brand->clearMediaCollection('logo');
                $brand->addMedia($this->logo->getRealPath())->toMediaCollection('logo');
            }

        } else {
            $brand = Brand::create(['name' => $this->name]);

            if ($this->logo) {
                $brand->addMedia($this->logo->getRealPath())->toMediaCollection('logo');
            }
        }

        $this->modalVisible = false;
        $this->resetFields();
    }

    public function delete($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
    }

    public function resetFields()
    {
        $this->name = '';
        $this->logo = null;
        $this->brand_id = null;
    }

    public function render()
    {
        return view('livewire.admin.brands', [
            'brands' => Brand::paginate(10),
        ]);
    }
}
