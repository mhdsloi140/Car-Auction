<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Brand;
use App\Models\CarModel;

class CarModels extends Component
{
    use WithPagination;

    public $name, $brand_id, $model_id;
    public $modalVisible = false;
    public $isEdit = false;

    protected function rules()
    {
        return [
            'name' => 'required|string',
            'brand_id' => 'required|exists:brands,id',
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

        $model = CarModel::findOrFail($id);

        $this->model_id = $id;
        $this->name = $model->name;
        $this->brand_id = $model->brand_id;

        $this->modalVisible = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEdit) {
            CarModel::findOrFail($this->model_id)->update([
                'name' => $this->name,
                'brand_id' => $this->brand_id,
            ]);
        } else {
            CarModel::create([
                'name' => $this->name,
                'brand_id' => $this->brand_id,
            ]);
        }

        $this->modalVisible = false;
        $this->resetFields();
    }

    public function delete($id)
    {
        CarModel::findOrFail($id)->delete();
    }

    public function resetFields()
    {
        $this->name = '';
        $this->brand_id = '';
        $this->model_id = null;
    }

    public function render()
    {
        return view('livewire.admin.car-models', [
            'models' => CarModel::with('brand')->paginate(10),
            'brands' => Brand::all(),
        ]);
    }
}
