<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Order;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Livewire\Component;

class DashboardComponent extends Component
{
    public function render()
    {
        $totalSales = Order::sum('total');
        $totalOrders = Order::count();
        $totalCustomers = Customer::count();
        $recentOrders = Order::latest()->take(10)->get();

        $salesData = Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $lineChartModel = (new LineChartModel())
            ->setTitle('Sales')
            ->setAnimated(true)
            ->setSmoothCurve()
            ->withOnPointClickEvent('onPointClick');

        foreach ($salesData as $data) {
            $lineChartModel->addPoint($data->month, $data->total, $data->month);
        }

        return view('livewire.dashboard-component', [
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
            'totalCustomers' => $totalCustomers,
            'recentOrders' => $recentOrders,
            'lineChartModel' => $lineChartModel,
        ]);
    }
}
