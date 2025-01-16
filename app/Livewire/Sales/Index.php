<?php

namespace App\Livewire\Sales;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $dateFilter = 'today';
    public $searchTerm = '';

    public function getMetrics()
    {
        $query = Order::query();

        switch ($this->dateFilter) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'week':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('created_at', Carbon::now()->month);
                break;
            case 'year':
                $query->whereYear('created_at', Carbon::now()->year);
                break;
        }

        $orders = $query->get();

        return [
            'total_sales' => $orders->sum('total'),
            'total_orders' => $orders->count(),
            'average_order' => $orders->avg('total') ?? 0,
            'successful_orders' => $orders->where('status', 'completed')->count(),
        ];
    }

    public function getRecentOrders()
    {
        return Order::with('customer')
            ->when($this->searchTerm, function ($query) {
                $query->whereHas('customer', function ($q) {
                    $q->where('name', 'like', '%' . $this->searchTerm . '%');
                })->orWhere('id', 'like', '%' . $this->searchTerm . '%');
            })
            ->latest()
            ->paginate(10);
    }

    public function render()
    {
        $metrics = $this->getMetrics();
        $recentOrders = $this->getRecentOrders();

        return view('livewire.sales.index', [
            'metrics' => $metrics,
            'recentOrders' => $recentOrders,
        ]);
    }
}