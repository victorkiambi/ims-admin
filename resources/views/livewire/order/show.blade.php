<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Order Header -->
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Order #{{ $order->id }}</h1>
            <p class="mt-1 text-sm text-gray-600">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</p>
        </div>
        <div class="flex gap-3">
            <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print Order
            </button>
            <a href="{{ url('order/'.$order->id.'/edit') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Order
            </a>
        </div>
    </div>

    <!-- Order Status -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <span class="text-sm font-medium text-gray-500">Status:</span>
                    <span @class([
                        'ml-2 px-2.5 py-0.5 rounded-full text-sm font-medium',
                        'bg-yellow-100 text-yellow-800' => $order->status === 'pending',
                        'bg-blue-100 text-blue-800' => $order->status === 'processing',
                        'bg-green-100 text-green-800' => $order->status === 'completed',
                        'bg-red-100 text-red-800' => $order->status === 'cancelled',
                    ])>
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Payment Status:</span>
                    <span @class([
                        'ml-2 px-2.5 py-0.5 rounded-full text-sm font-medium',
                        'bg-green-100 text-green-800' => $order->payment_status === 'paid',
                        'bg-red-100 text-red-800' => $order->payment_status === 'unpaid',
                        'bg-yellow-100 text-yellow-800' => $order->payment_status === 'partial',
                    ])>
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Customer Information -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h2>
                <div class="space-y-3">
                    <p class="text-sm">
                        <span class="font-medium text-gray-500">Name:</span>
                        <span class="ml-2 text-gray-900">{{ $order->customer->name }}</span>
                    </p>
                    <p class="text-sm">
                        <span class="font-medium text-gray-500">Email:</span>
                        <span class="ml-2 text-gray-900">{{ $order->customer->email }}</span>
                    </p>
                    <p class="text-sm">
                        <span class="font-medium text-gray-500">Phone:</span>
                        <span class="ml-2 text-gray-900">{{ $order->customer->phone }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Shipping Address</h2>
                <div class="space-y-3">
                    <p class="text-sm">{{ $order->shipping_address }}</p>
                    <p class="text-sm">
                        {{ $order->shipping_city }}, {{ $order->shipping_county }}
                    </p>
                    <p class="text-sm">{{ $order->shipping_country }}</p>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                <div class="space-y-3">
                    <p class="text-sm flex justify-between">
                        <span class="font-medium text-gray-500">Subtotal</span>
                        <span class="text-gray-900">${{ number_format($order->subtotal, 2) }}</span>
                    </p>
                    <p class="text-sm flex justify-between">
                        <span class="font-medium text-gray-500">Shipping</span>
                        <span class="text-gray-900">${{ number_format($order->shipping_cost, 2) }}</span>
                    </p>
                    <p class="text-sm flex justify-between">
                        <span class="font-medium text-gray-500">Tax</span>
                        <span class="text-gray-900">${{ number_format($order->tax, 2) }}</span>
                    </p>
                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-sm flex justify-between font-medium">
                            <span class="text-gray-900">Total</span>
                            <span class="text-gray-900">${{ number_format($order->total, 2) }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Order Items</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3">Product</th>
                        <th class="px-6 py-3">Price</th>
                        <th class="px-6 py-3">Quantity</th>
                        <th class="px-6 py-3 text-right">Total</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($order->orderitems as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="h-10 w-10 rounded-full">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                        <div class="text-sm text-gray-500">SKU: {{ $item->product->sku }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ${{ number_format($item->price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                ${{ number_format($item->price * $item->quantity, 2) }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
