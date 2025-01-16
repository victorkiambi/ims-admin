<?php

namespace App\Livewire\Charts;

use App\Models\Order;
use Livewire\Component;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Carbon\Carbon;

class SalesChart extends Component
{
    private function generateLineChartData()
    {
        $data = Order::selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->orderBy('date')
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

    private function generateBarChartData()
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

    private function generatePieChartData()
    {
        $data = Order::selectRaw('payment_method, COUNT(*) as count')
            ->groupBy('payment_method')
            ->get();

        $pieChart = new PieChartModel();
        $pieChart->setTitle('Payment Methods Distribution')
            ->setAnimated(true)
            ->withDataLabels();

        foreach ($data as $item) {
            $pieChart->addSlice($item->payment_method, $item->count, $this->getRandomColor());
        }

        return $pieChart;
    }

    private function getRandomColor()
    {
        $colors = ['#f56565', '#48bb78', '#4299e1', '#9f7aea', '#ed64a6', '#38b2ac', '#ecc94b'];
        return $colors[array_rand($colors)];
    }

    public function render()
    {
        return view('livewire.charts.sales-chart', [
            'lineChartModel' => $this->generateLineChartData(),
            'barChartModel' => $this->generateBarChartData(),
            'pieChartModel' => $this->generatePieChartData(),
        ]);
    }
}
