<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ActivityLog;
use App\Models\Auction;

class ActivityLogs extends Component
{
    use WithPagination;

    public $auction_id = '';
    public $action = '';
    public $from = '';
    public $to = '';

    public $selected = [];
    public $selectAll = false;

    protected $paginationTheme = 'bootstrap';

    public function updating($field)
    {
        $this->resetPage(); // تحديث فوري عند تغيير أي فلتر
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = ActivityLog::pluck('id')->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function deleteSelected()
    {
        ActivityLog::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;

        session()->flash('success', 'تم حذف السجلات المحددة بنجاح');
    }

    public function render()
    {
        $logs = ActivityLog::query()
            ->when($this->auction_id, fn($q) => $q->where('auction_id', $this->auction_id))
            ->when($this->action, fn($q) => $q->where('action', $this->action))
            ->when($this->from, fn($q) => $q->whereDate('created_at', '>=', $this->from))
            ->when($this->to, fn($q) => $q->whereDate('created_at', '<=', $this->to))
            ->latest()
            ->paginate(20);

        return view('livewire.admi  n.activity-logs', [
            'logs' => $logs,
            'auctions' => Auction::all(),
        ]);
    }
}
