<div>
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold">Orders</h2>
        <div class="flex gap-4">

            <!-- Filters Section -->
            <div class="flex items-center gap-3">
                <!-- Date Range Filters -->
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <input
                            type="date"
                            wire:model.live="startDate"
                            class="w-40 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5"
                            placeholder="Start date">
                    </div>

                    <span class="text-gray-500">-</span>

                    <div class="relative">
                        <input
                            type="date"
                            wire:model.live="endDate"
                            class="w-40 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5"
                            placeholder="End date">
                    </div>
                </div>

                <!-- Search Input -->
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                        <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        class="block w-full rounded-lg border border-gray-300 bg-white py-2.5 ps-10 pe-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Search orders...">
                </div>

                <!-- Status Filter -->
                <select
                    wire:model.live="status"
                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5"
                >
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        <!-- Active Filters -->
        @if($search || $status || $startDate || $endDate)
            <div class="mb-4 flex flex-wrap gap-2 items-center">
                <span class="text-sm text-gray-500">Filters:</span>
                @if($search)
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm bg-blue-50 text-blue-700">
                    <span>{{ $search }}</span>
                    <button wire:click="$set('search', '')" class="hover:text-blue-900">
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/>
                        </svg>
                    </button>
                </span>
                @endif
                @if($status)
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm bg-blue-50 text-blue-700">
                    <span>{{ ucfirst($status) }}</span>
                    <button wire:click="$set('status', '')" class="hover:text-blue-900">
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/>
                        </svg>
                    </button>
                </span>
                @endif
                @if($startDate || $endDate)
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm bg-blue-50 text-blue-700">
                    <span>{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</span>
                    <button wire:click="$set('startDate', ''); $set('endDate', '');" class="hover:text-blue-900">
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/>
                        </svg>
                    </button>
                </span>
                @endif
            </div>
        @endif
    </div>

    <!-- Table -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">Order #</th>
                <th scope="col" class="px-6 py-3">Customer</th>
                <th scope="col" class="px-6 py-3">Date</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Total</th>
                <th scope="col" class="px-6 py-3">Payment Status</th>
                <th scope="col" class="px-6 py-3">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($orders as $order)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">
                        #{{ $order->id }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $order->customer->name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $order->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4">
                            <span @class([
                                'px-2 py-1 rounded-full text-xs',
                                'bg-yellow-100 text-yellow-800' => $order->status === 'pending',
                                'bg-blue-100 text-blue-800' => $order->status === 'processing',
                                'bg-green-100 text-green-800' => $order->status === 'completed',
                                'bg-red-100 text-red-800' => $order->status === 'cancelled',
                            ])>
                                {{ ucfirst($order->status) }}
                            </span>
                    </td>
                    <td class="px-6 py-4">
                        ${{ number_format($order->total, 2) }}
                    </td>
                    <td class="px-6 py-4">
                            <span @class([
                                'px-2 py-1 rounded-full text-xs',
                                'bg-green-100 text-green-800' => $order->payment_status === 'paid',
                                'bg-red-100 text-red-800' => $order->payment_status === 'unpaid',
                                'bg-yellow-100 text-yellow-800' => $order->payment_status === 'partial',
                            ])>
                                {{ ucfirst($order->payment_status) }}
                            </span>
                    </td>
                    <td class="px-6 py-4 flex items-center gap-4">
                        <a href="{{ url('order/'.$order->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View
                        </a>
                        <a href="{{ url('order/'.$order->id.'/edit') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        No orders found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="p-4">
            {{ $orders->links() }}
        </div>
    </div>

    <!-- Loading States -->
    <div wire:loading.delay wire:target="search, status" class="absolute inset-0 bg-gray-50 bg-opacity-50 flex items-center justify-center">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
    </div>
</div>
