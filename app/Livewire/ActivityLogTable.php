<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\ActivityLog;

class ActivityLogTable extends Component
{
    public $selectedLogs = [];

    protected $listeners = ['deleteConfirmed' => 'deleteSelected'];

    public function confirmDelete()
    {
        if (count($this->selectedLogs) === 0) {
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => 'لم يتم اختيار أي سجل للحذف'
            ]);
            return;
        }

        $this->dispatchBrowserEvent('confirm-delete');
    }

    public function deleteSelected()
    {
        ActivityLog::whereIn('id', $this->selectedLogs)->delete();

        $this->selectedLogs = [];

        $this->dispatchBrowserEvent('alert', [
            'type' => 'success',
            'message' => 'تم حذف السجلات المحددة بنجاح'
        ]);
    }

    public function render()
    {
        return view('livewire.activity-log-table', [
            'logs' => ActivityLog::with('user')->orderBy('id', 'desc')->paginate(20)
        ]);
    }
}
