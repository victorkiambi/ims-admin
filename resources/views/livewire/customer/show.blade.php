<div>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">{{ $customer->name }}</h1>
                <p class="mt-1 text-sm text-gray-500">Customer since {{ $customer->created_at->format('F Y') }}</p>
            </div>
            <div class="flex gap-3">
                <button class="inline-flex items-center gap-x-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                    <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Export Data
                </button>
                <a href="{{ url('customers/edit', $customer) }}" class="inline-flex items-center gap-x-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Customer
                </a>
            </div>
        </div>

        <!-- Customer Information Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 w-full">
            <!-- Basic Info -->
            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h2>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $customer->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Phone</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $customer->phone }}</p>
                    </div>
                    <div class="text-sm">
                        <label class="text-sm font-medium text-gray-500">Address</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $customer->address }}</p>
                    </div>
                </div>
            </div>

        </div>
            <!-- Orders List -->
            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 rounded-lg w-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="sm:flex sm:items-center sm:justify-between">
                        <!-- Left side -->
                        <div class="mb-4 sm:mb-0">
                            <h2 class="text-lg font-medium text-gray-900">Order History</h2>
                        </div>

                        <!-- Right side with search -->
                        <div class="relative sm:w-96">
                            <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <input
                                type="text"
                                wire:model.live.debounce.300ms="orderSearch"
                                class="block w-full rounded-lg border border-gray-300 bg-white py-2 ps-10 pe-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Search orders...">
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th scope="col" class="relative px-3 py-2">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="whitespace-nowrap px-3 py-2 text-sm font-medium text-gray-900">
                                    #{{ $order->id }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-2">
                            <span @class([
                                'inline-flex rounded-full px-2 py-0.5 text-xs font-medium',
                                'bg-yellow-100 text-yellow-800' => $order->status === 'pending',
                                'bg-blue-100 text-blue-800' => $order->status === 'processing',
                                'bg-green-100 text-green-800' => $order->status === 'completed',
                                'bg-red-100 text-red-800' => $order->status === 'cancelled',
                            ])>
                                {{ ucfirst($order->status) }}
                            </span>
                                </td>
                                <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">
                                    {{ $order->orderItems->count() }} items
                                </td>
                                <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-900">
                                    ${{ number_format($order->total, 2) }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-2 text-right text-sm">
                                    <a href="{{ url('order', $order) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-3 py-2 text-center text-sm text-gray-500">
                                    No orders found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
    </div>
</div>
</div>
