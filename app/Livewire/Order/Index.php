<?php

namespace App\Livewire\Order;

use App\Models\Order;
use Carbon\Carbon;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';
    #[Url]
    public $status = '';
    #[Url]
    public $startDate = '';
    #[Url]
    public $endDate = '';

    public function mount()
    {
        // Default to last 30 days if no dates set
        if (!$this->startDate) {
            $this->startDate = Carbon::now()->subDays(30)->format('Y-m-d');
        }
        if (!$this->endDate) {
            $this->endDate = Carbon::now()->format('Y-m-d');
        }
    }
    public function render()
    {
        return view('livewire.order.index', [
            'orders' => Order::query()
                ->when($this->search, function($query) {
                    $query->where('id', 'like', "%{$this->search}%")
                        ->orWhereHas('customer', function($query) {
                            $query->where('name', 'like', "%{$this->search}%");
                        });
                })
                ->when($this->status, function($query) {
                    $query->where('status', $this->status);
                })
                ->latest()
                ->paginate(10)
        ]);
    }
    public function updatedStartDate()
    {
        $this->resetPage();
    }

    public function updatedEndDate()
    {
        $this->resetPage();
    }
}
