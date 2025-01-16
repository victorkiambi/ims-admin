<div class="p-4 bg-white rounded-lg shadow-sm">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">Sales Analytics</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Daily Sales Trend --}}
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <h4 class="text-md font-medium text-gray-600 mb-4">Daily Sales Trend</h4>
            <div class="h-64">
                <livewire:livewire-line-chart
                    :line-chart-model="$lineChartModel"
                />
            </div>
        </div>

        {{-- Orders by Day of Week --}}
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <h4 class="text-md font-medium text-gray-600 mb-4">Orders by Day of Week</h4>
            <div class="h-64">
                <livewire:livewire-column-chart
                    :column-chart-model="$barChartModel"
                />
            </div>
        </div>

        {{-- Payment Methods --}}
        <div class="bg-white p-4 rounded-lg shadow-sm md:col-span-2">
            <h4 class="text-md font-medium text-gray-600 mb-4">Payment Methods Distribution</h4>
            <div class="h-64">
                <livewire:livewire-pie-chart
                    :pie-chart-model="$pieChartModel"
                />
            </div>
        </div>
    </div>
</div>
