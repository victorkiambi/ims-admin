<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Livewire\Component;
use Carbon\Carbon;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class DashboardComponent extends Component
{
    public $dateFilter = 'today';

    public function getMetrics()
    {
        $orderQuery = Order::query();
        
        switch ($this->dateFilter) {
            case 'today':
                $orderQuery->whereDate('created_at', Carbon::today());
                break;
            case 'week':
                $orderQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'month':
                $orderQuery->whereMonth('created_at', Carbon::now()->month);
                break;
            case 'year':
                $orderQuery->whereYear('created_at', Carbon::now()->year);
                break;
        }

        return [
            'total_revenue' => $orderQuery->sum('total'),
            'total_orders' => $orderQuery->count(),
            'total_products' => Product::count(),
            'total_customers' => Customer::count(),
        ];
    }

    private function generateSalesChart()
    {
        $data = Order::selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->limit(7)
            ->get();

        $lineChart = new LineChartModel();
        
        foreach ($data as $record) {
            $lineChart->addPoint(
                Carbon::parse($record->date)->format('M d'), 
                $record->total,
                '#0694a2'
            );
        }

        return $lineChart
            ->setTitle('Daily Sales')
            ->setAnimated(true)
            ->withDataLabels();
    }

    private function generateOrdersByDayChart()
    {
        $data = Order::selectRaw('DAYNAME(created_at) as day, COUNT(*) as count')
            ->groupBy('day')
            ->orderBy(\DB::raw('FIELD(day, "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday")'))
            ->get();

        $columnChart = new ColumnChartModel();
        
        foreach ($data as $record) {
            $columnChart->addColumn($record->day, $record->count, '#6875f5');
        }

        return $columnChart
            ->setTitle('Orders by Day of Week')
            ->setAnimated(true)
            ->withDataLabels();
    }

    private function generatePaymentMethodsChart()
    {
        $data = Order::selectRaw('payment_method, COUNT(*) as count')
            ->groupBy('payment_method')
            ->get();

        $pieChart = new PieChartModel();
        $pieChart->setTitle('Payment Methods')
            ->setAnimated(true)
            ->withDataLabels();

        $colors = ['#f56565', '#48bb78', '#4299e1', '#9f7aea'];
        foreach ($data as $index => $item) {
            $pieChart->addSlice($item->payment_method, $item->count, $colors[$index % count($colors)]);
        }

        return $pieChart;
    }

    public function render()
    {
        return view('livewire.dashboard-component', [
            'metrics' => $this->getMetrics(),
            'salesChart' => $this->generateSalesChart(),
            'ordersByDayChart' => $this->generateOrdersByDayChart(),
            'paymentMethodsChart' => $this->generatePaymentMethodsChart(),
        ]);
    }
}
