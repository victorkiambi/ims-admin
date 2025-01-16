<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Create New Order</h2>

                <form wire:submit="save">
                    <!-- Customer Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Customer</label>
                        @if($selectedCustomer)
                            <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                                <div>
                                    <p class="font-medium">{{ $selectedCustomer->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $selectedCustomer->email }}</p>
                                </div>
                                <button type="button" wire:click="$set('selectedCustomer', null)" class="text-sm text-red-600">
                                    Change
                                </button>
                            </div>
                        @else
                            <div class="relative">
                                <input 
                                    type="text"
                                    wire:model.live.debounce.300ms="customerSearch"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Search customers..."
                                >
                                @if(!empty($customers))
                                    <ul class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                        @foreach($customers as $customer)
                                            <li wire:click="selectCustomer({{ $customer->id }})" class="cursor-pointer hover:bg-gray-100 px-4 py-2">
                                                <div class="flex justify-between">
                                                    <div>
                                                        <p class="font-medium">{{ $customer->name }}</p>
                                                        <p class="text-sm text-gray-500">{{ $customer->email }}</p>
                                                    </div>
                                                    <p class="text-sm text-gray-500">{{ $customer->phone }}</p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Order Items -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Order Items</h3>
                            <button type="button" wire:click="addItem" class="text-sm bg-blue-600 text-white px-3 py-2 rounded-md">
                                Add Item
                            </button>
                        </div>

                        <div class="space-y-4">
                            @foreach($orderItems as $index => $item)
                                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                                    <!-- Product Selection -->
                                    <div class="flex-1">
                                        @if($item['product_id'])
                                            <div class="flex justify-between">
                                                <div>
                                                    <p class="font-medium">{{ $item['product_name'] }}</p>
                                                    <p class="text-sm text-gray-500">${{ number_format($item['price'], 2) }}</p>
                                                </div>
                                                <button type="button" wire:click="removeItem({{ $index }})" class="text-sm text-red-600">
                                                    Remove
                                                </button>
                                            </div>
                                        @else
                                            <div class="relative">
                                                <input 
                                                    type="text"
                                                    wire:model.live.debounce.300ms="productSearch"
                                                    wire:keyup="searchProducts({{ $index }})"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                    placeholder="Search products..."
                                                >
                                                @if(!empty($searchResults))
                                                    <ul class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                                        @foreach($searchResults as $product)
                                                            <li wire:click="selectProduct({{ $index }}, {{ $product }})" class="cursor-pointer hover:bg-gray-100 px-4 py-2">
                                                                <div class="flex justify-between">
                                                                    <div>
                                                                        <p class="font-medium">{{ $product->name }}</p>
                                                                        <p class="text-sm text-gray-500">SKU: {{ $product->sku }}</p>
                                                                    </div>
                                                                    <div class="text-right">
                                                                        <p class="font-medium">${{ number_format($product->price, 2) }}</p>
                                                                        <p class="text-sm text-gray-500">Stock: {{ $product->stock }}</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Quantity -->
                                    <div class="w-24">
                                        <input 
                                            type="number" 
                                            wire:model="orderItems.{{ $index }}.quantity"
                                            wire:change="calculateSubtotal({{ $index }})"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            min="1"
                                            max="{{ $item['stock'] }}"
                                            @if(!$item['product_id']) disabled @endif
                                        >
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="w-32 text-right">
                                        ${{ number_format($item['subtotal'], 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Total -->
                        <div class="mt-4 text-right">
                            <p class="text-lg font-semibold">Total: ${{ number_format($total, 2) }}</p>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Shipping Address</h3>
                        
                        @if($selectedCustomer)
                            <div class="mb-4">
                                <div class="flex items-center">
                                    <input type="radio" wire:model="useExistingAddress" id="existing_address" value="1" class="h-4 w-4 text-blue-600">
                                    <label for="existing_address" class="ml-2 text-sm text-gray-700">Use Existing Address</label>
                                </div>
                                
                                @if($useExistingAddress)
                                    <div class="mt-3">
                                        <select wire:model="selectedAddressId" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="">Select an address</option>
                                            @foreach($customerAddresses as $address)
                                                <option value="{{ $address->id }}">
                                                    {{ $address->address_line1 }}, {{ $address->city }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center mb-4">
                                <input type="radio" wire:model="useExistingAddress" id="new_address" value="0" class="h-4 w-4 text-blue-600">
                                <label for="new_address" class="ml-2 text-sm text-gray-700">Add New Address</label>
                            </div>
                        @endif

                        @if(!$useExistingAddress || !$selectedCustomer)
                            <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Address</label>
                                    <input type="text" wire:model="shippingAddress.address_line1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Apartment, suite, etc.</label>
                                    <input type="text" wire:model="shippingAddress.address_line2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">City</label>
                                    <input type="text" wire:model="shippingAddress.city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">State</label>
                                    <input type="text" wire:model="shippingAddress.state" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Postal code</label>
                                    <input type="text" wire:model="shippingAddress.postal_code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                                    <input type="text" wire:model="shippingAddress.phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>
                        @endif

                        <!-- Billing Address -->
                        <div class="mt-6">
                            <div class="flex items-center mb-4">
                                <input type="checkbox" wire:model="useSameForBilling" id="same_billing" class="h-4 w-4 text-blue-600">
                                <label for="same_billing" class="ml-2 text-sm text-gray-700">Use same address for billing</label>
                            </div>

                            @if(!$useSameForBilling)
                                <div class="mt-4">
                                    <h4 class="text-md font-medium text-gray-900 mb-4">Billing Address</h4>
                                    <!-- Repeat the address form fields for billing, using billingAddress.* -->
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                        <select wire:model="payment_method" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="cash">Cash</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                    </div>

                    <!-- Notes -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea 
                            wire:model="notes"
                            rows="3"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        ></textarea>
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ url('/orders') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Create Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session()->has('success'))
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif
</div>