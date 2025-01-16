<div class="p-6">
    {{-- Dashboard Metrics --}}
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Dashboard Overview</h2>
            <select wire:model.live="dateFilter" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
                <option value="year">This Year</option>
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Total Revenue --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 bg-opacity-75">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="mb-2 text-sm font-medium text-gray-600">Total Revenue</p>
                        <p class="text-lg font-semibold text-gray-700">
                            ${{ number_format($metrics['total_revenue'], 2) }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Total Orders --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 bg-opacity-75">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="mb-2 text-sm font-medium text-gray-600">Total Orders</p>
                        <p class="text-lg font-semibold text-gray-700">
                            {{ $metrics['total_orders'] }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Total Products --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 bg-opacity-75">
                        <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="mb-2 text-sm font-medium text-gray-600">Total Products</p>
                        <p class="text-lg font-semibold text-gray-700">
                            {{ $metrics['total_products'] }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Total Customers --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 bg-opacity-75">
                        <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="mb-2 text-sm font-medium text-gray-600">Total Customers</p>
                        <p class="text-lg font-semibold text-gray-700">
                            {{ $metrics['total_customers'] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Sales Trend Chart --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Sales Trend</h3>
            <div class="h-80">
                <livewire:livewire-line-chart
                    :line-chart-model="$salesChart"
                />
            </div>
        </div>

        {{-- Orders by Day Chart --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Orders by Day</h3>
            <div class="h-80">
                <livewire:livewire-column-chart
                    :column-chart-model="$ordersByDayChart"
                />
            </div>
        </div>

        {{-- Payment Methods Chart --}}
        <div class="bg-white rounded-lg shadow p-6 md:col-span-2">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Methods Distribution</h3>
            <div class="h-80">
                <livewire:livewire-pie-chart
                    :pie-chart-model="$paymentMethodsChart"
                />
            </div>
        </div>
    </div>
</div>
