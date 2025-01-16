<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">Edit Order #{{ $order->id }}</h2>
                    <p class="mt-1 text-sm text-gray-600">Update order information and items.</p>
                </div>

                <form wire:submit="update" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Customer --}}
                        <div>
                            <label for="customer" class="block text-sm font-medium text-gray-700">Customer</label>
                            <select wire:model="customer_id" id="customer"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Select a customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            @error('customer_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Status --}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select wire:model="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            @error('status') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Payment Method --}}
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                            <select wire:model="payment_method" id="payment_method"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="cash">Cash</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="bank_transfer">Bank Transfer</option>
                            </select>
                            @error('payment_method') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Order Items --}}
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-medium text-gray-900">Order Items</h3>
                            <button type="button" wire:click="addItem"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Add Item
                            </button>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            @foreach($items as $index => $item)
                                <div class="grid grid-cols-12 gap-4 mb-4">
                                    {{-- Product --}}
                                    <div class="col-span-4">
                                        <select wire:model="items.{{ $index }}.product_id" 
                                                wire:change="$set('items.{{ $index }}.price', {{ $this->getProductPrice($item['product_id'] ?? null) }})"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="">Select Product</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }} (Stock: {{ $product->stock }})</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Quantity --}}
                                    <div class="col-span-2">
                                        <input type="number" wire:model="items.{{ $index }}.quantity"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Qty">
                                    </div>

                                    {{-- Price --}}
                                    <div class="col-span-2">
                                        <input type="number" wire:model="items.{{ $index }}.price" step="0.01"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Price">
                                    </div>

                                    {{-- Subtotal --}}
                                    <div class="col-span-3">
                                        <input type="text" value="${{ number_format($item['subtotal'] ?? 0, 2) }}" disabled
                                            class="block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm sm:text-sm">
                                    </div>

                                    {{-- Remove Button --}}
                                    <div class="col-span-1">
                                        <button type="button" wire:click="removeItem({{ $index }})"
                                            class="text-red-600 hover:text-red-900">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                            <div class="mt-4 text-right">
                                <span class="text-lg font-semibold">Total: ${{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea wire:model="notes" id="notes" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                    </div>

                    {{-- Submit Buttons --}}
                    <div class="flex justify-end space-x-3">
                        <a href="{{ url('/orders') }}"
                            class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Update Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Success Message --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif
</div>
