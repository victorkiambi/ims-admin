<?php

namespace App\Livewire\Charts;

use App\Models\Order;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Livewire\Component;

class SalesChart extends Component
{
    public function render()
    {
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

        return view('livewire.charts.sales-chart', [
            'lineChartModel' => $lineChartModel,
        ]);
    }
}
