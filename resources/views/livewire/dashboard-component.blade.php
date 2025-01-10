<div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 shadow-lg rounded-lg p-6 text-white">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <h3 class="text-2xl font-semibold mb-2">Total Sales</h3>
                <p class="text-4xl font-bold">{{ $totalSales }}</p>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-green-500 to-green-600 shadow-lg rounded-lg p-6 text-white">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <div>
                <h3 class="text-2xl font-semibold mb-2">Total Orders</h3>
                <p class="text-4xl font-bold">{{ $totalOrders }}</p>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-purple-500 to-purple-600 shadow-lg rounded-lg p-6 text-white">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <div>
                <h3 class="text-2xl font-semibold mb-2">Total Customers</h3>
                <p class="text-4xl font-bold">{{ $totalCustomers }}</p>
            </div>
        </div>
    </div>
</div>
    <div>
        <div class="mt-8">
            <h2 class="text-2xl font-semibold mb-4">Sales Chart</h2>
            <div class="bg-white shadow-md rounded-lg p-6">
                <!-- Sales Chart Component -->
                <livewire:charts.sales-chart />
            </div>
        </div>
    </div>
</div>
