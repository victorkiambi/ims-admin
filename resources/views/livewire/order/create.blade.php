<div>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900">Create Order</h2>

            <!-- Steps -->
            <div class="mt-8">
                <nav aria-label="Progress" class="mb-8">
                    <ol role="list" class="divide-y divide-gray-300 rounded-md border border-gray-300 md:flex md:divide-y-0">
                        <li class="relative md:flex md:flex-1">
                            <button wire:click="setStep(1)" class="group flex w-full items-center" @class([
                                'px-6 py-4',
                                'bg-blue-50' => $currentStep === 1
                            ])>
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 @if($currentStep >= 1) border-blue-600 bg-blue-600 @else border-gray-300 @endif">
                                    @if($currentStep > 1)
                                        <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                            <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <span class="@if($currentStep >= 1) text-white @else text-gray-500 @endif">01</span>
                                    @endif
                                </span>
                                <span class="ml-4 text-sm font-medium @if($currentStep >= 1) text-blue-600 @else text-gray-500 @endif">Customer</span>
                            </button>

                            <div class="absolute right-0 top-0 hidden h-full w-5 md:block" aria-hidden="true">
                                <svg class="h-full w-full text-gray-300" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
                                    <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </li>

                        <li class="relative md:flex md:flex-1">
                            <button wire:click="setStep(2)" @disabled(!$canProceedToProducts) class="group flex w-full items-center" @class([
                                'px-6 py-4',
                                'bg-blue-50' => $currentStep === 2
                            ])>
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 @if($currentStep >= 2) border-blue-600 bg-blue-600 @else border-gray-300 @endif">
                                    @if($currentStep > 2)
                                        <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                            <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <span class="@if($currentStep >= 2) text-white @else text-gray-500 @endif">02</span>
                                    @endif
                                </span>
                                <span class="ml-4 text-sm font-medium @if($currentStep >= 2) text-blue-600 @else text-gray-500 @endif">Products</span>
                            </button>

                            <div class="absolute right-0 top-0 hidden h-full w-5 md:block" aria-hidden="true">
                                <svg class="h-full w-full text-gray-300" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
                                    <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </li>

                        <li class="relative md:flex md:flex-1">
                            <button wire:click="setStep(3)" @disabled(!$canProceedToShipping) class="group flex w-full items-center" @class([
                                'px-6 py-4',
                                'bg-blue-50' => $currentStep === 3
                            ])>
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 @if($currentStep >= 3) border-blue-600 bg-blue-600 @else border-gray-300 @endif">
                                    @if($currentStep > 3)
                                        <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                            <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <span class="@if($currentStep >= 3) text-white @else text-gray-500 @endif">03</span>
                                    @endif
                                </span>
                                <span class="ml-4 text-sm font-medium @if($currentStep >= 3) text-blue-600 @else text-gray-500 @endif">Shipping</span>
                            </button>

                            <div class="absolute right-0 top-0 hidden h-full w-5 md:block" aria-hidden="true">
                                <svg class="h-full w-full text-gray-300" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
                                    <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </li>

                        <li class="relative md:flex md:flex-1">
                            <button wire:click="setStep(4)" @disabled(!$canProceedToPayment) class="group flex w-full items-center" @class([
                                'px-6 py-4',
                                'bg-blue-50' => $currentStep === 4
                            ])>
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 @if($currentStep >= 4) border-blue-600 bg-blue-600 @else border-gray-300 @endif">
                                    <span class="@if($currentStep >= 4) text-white @else text-gray-500 @endif">04</span>
                                </span>
                                <span class="ml-4 text-sm font-medium @if($currentStep >= 4) text-blue-600 @else text-gray-500 @endif">Payment</span>
                            </button>
                        </li>
                    </ol>
                </nav>

                <!-- Step Content -->
                <div class="mt-8">
                    <!-- Step 1: Customer Selection -->
                    @if($currentStep === 1)
                        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 rounded-lg p-6">
                            <div class="mb-6">
                                <div class="relative">
                                    <input
                                        type="text"
                                        wire:model.live.debounce.300ms="customerSearch"
                                        class="block w-full rounded-lg border border-gray-300 px-4 py-3 pr-10 text-sm placeholder:text-gray-400 focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Search customers by name, email, or phone..."
                                    >
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                                        <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            @if($customers->count() > 0)
                                <ul role="list" class="divide-y divide-gray-100">
                                    @foreach($customers as $customer)
                                        <li class="flex items-center justify-between gap-x-6 py-5">
                                            <div class="min-w-0">
                                                <div class="flex items-center gap-x-3">
                                                    <h2 class="text-sm font-semibold leading-6 text-gray-900">{{ $customer->name }}</h2>
                                                    <div class="rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">
                                                        {{ $customer->orders_count }} orders
                                                    </div>
                                                </div>
                                                <div class="mt-1 flex items-center gap-x-3 text-xs leading-5 text-gray-500">
                                                    <p>{{ $customer->email }}</p>
                                                    <svg viewBox="0 0 2 2" class="h-0.5 w-0.5 fill-current">
                                                        <circle cx="1" cy="1" r="1" />
                                                    </svg>
                                                    <p>{{ $customer->phone }}</p>
                                                </div>
                                            </div>
                                            <button
                                                wire:click="selectCustomer({{ $customer->id }})"
                                                class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                            >
                                                Select
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No customers found</h3>
                                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new customer.</p>
                                    <div class="mt-6">
                                        <button
                                            wire:click="createNewCustomer"
                                            class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                                        >
                                            <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                            </svg>

                                            New Customer
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Other steps will go here -->

                    <!-- Step 2: Product Selection -->
                    @if($currentStep === 2)
                        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 rounded-lg">
                            <!-- Search Products -->
                            <div class="p-6 border-b border-gray-200">
                                <div class="relative">
                                    <input
                                        type="text"
                                        wire:model.live.debounce.300ms="productSearch"
                                        class="block w-full rounded-lg border border-gray-300 px-4 py-3 pr-10 text-sm placeholder:text-gray-400 focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Search products by name or SKU..."
                                    >
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                                        <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>

                                @if($this->products->isNotEmpty())
                                    <ul class="mt-4 divide-y divide-gray-100">
                                        @foreach($this->products as $product)
                                            <li class="flex items-center justify-between gap-x-6 py-5">
                                                <div class="flex gap-x-4">
                                                    <img class="h-12 w-12 flex-none rounded-lg bg-gray-50 object-cover" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                                    <div class="min-w-0 flex-auto">
                                                        <p class="text-sm font-semibold leading-6 text-gray-900">{{ $product->name }}</p>
                                                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">SKU: {{ $product->sku }}</p>
                                                    </div>
                                                    <div class="flex flex-col items-end">
                                                        <p class="text-sm font-medium text-gray-900">${{ number_format($product->price, 2) }}</p>
                                                        <p class="text-xs text-gray-500">{{ $product->quantity }} in stock</p>
                                                    </div>
                                                </div>
                                                <button
                                                    wire:click="addProduct({{ $product->id }})"
                                                    @class([
                                                        'rounded-md px-3 py-2 text-sm font-semibold shadow-sm',
                                                        'bg-blue-600 text-white hover:bg-blue-500' => !in_array($product->id, $selectedProducts),
                                                        'bg-gray-100 text-gray-500 cursor-not-allowed' => in_array($product->id, $selectedProducts),
                                                    ])
                                                    @disabled(in_array($product->id, $selectedProducts))
                                                >
                                                    {{ in_array($product->id, $selectedProducts) ? 'Added' : 'Add' }}
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            <!-- Selected Products -->
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Selected Products</h3>

                                @if(empty($selectedProducts))
                                    <p class="text-sm text-gray-500 text-center py-4">No products selected yet.</p>
                                @else
                                    <div class="divide-y divide-gray-200">
                                        @foreach($this->selectedProductDetails as $product)
                                            <div class="py-4 flex items-center justify-between gap-4">
                                                <div class="flex items-center gap-4">
                                                    <img class="h-10 w-10 rounded-lg object-cover" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                                                        <p class="text-sm text-gray-500">${{ number_format($product->price, 2) }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-4">
                                                    <div class="w-24">
                                                        <input
                                                            type="number"
                                                            wire:model.live="quantities.{{ $product->id }}"
                                                            wire:change="updateQuantity({{ $product->id }}, $event.target.value)"
                                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                                            min="1"
                                                            max="{{ $product->quantity }}"
                                                        >
                                                    </div>
                                                    <button
                                                        wire:click="removeProduct({{ $product->id }})"
                                                        class="text-gray-400 hover:text-gray-500"
                                                    >
                                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach

                                        <!-- Order Total -->
                                        <div class="pt-4 flex justify-between items-center">
                                            <span class="text-base font-medium text-gray-900">Total</span>
                                            <span class="text-lg font-semibold text-gray-900">${{ number_format($this->orderTotal, 2) }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Navigation -->
                            <div class="p-6 bg-gray-50 flex justify-between items-center rounded-b-lg">
                                <button
                                    wire:click="setStep(1)"
                                    class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                >
                                    Back
                                </button>
                                <button
                                    wire:click="proceedToShipping"
                                    @disabled(empty($selectedProducts))
                                    class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    Continue to Shipping
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Step 3: Shipping -->
                    @if($currentStep === 3)
                        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 rounded-lg">
                            <div class="p-6 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Shipping Address</h3>

                                <!-- Customer's Saved Addresses -->
                                @if($customerAddresses && $customerAddresses->count() > 0)
                                    <div class="space-y-4">
                                        <label class="text-sm font-medium text-gray-700">Select a saved address</label>
                                        @foreach($customerAddresses as $address)
                                            <div class="relative flex items-start">
                                                <div class="flex h-6 items-center">
                                                    <input
                                                        type="radio"
                                                        wire:model="selectedAddressId"
                                                        value="{{ $address->id }}"
                                                        class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-600"
                                                    >
                                                </div>
                                                <div class="ml-3">
                                                    <span class="block text-sm font-medium text-gray-900">{{ $address->type }}</span>
                                                    <span class="block text-sm text-gray-500">
                                                        {{ $address->address_line1 }}<br>
                                                        @if($address->address_line2)
                                                            {{ $address->address_line2 }}<br>
                                                        @endif
                                                        {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-4">
                                        <div class="relative">
                                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                                <div class="w-full border-t border-gray-200"></div>
                                            </div>
                                            <div class="relative flex justify-center">
                                                <span class="bg-white px-2 text-sm text-gray-500">or</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- New Address Form -->
                                <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                    <div class="sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Address Type</label>
                                        <select
                                            wire:model="shippingAddress.type"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        >
                                            <option value="home">Home</option>
                                            <option value="office">Office</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Address</label>
                                        <input
                                            type="text"
                                            wire:model="shippingAddress.address_line1"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                            placeholder="Street address"
                                        >
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Apartment, suite, etc.</label>
                                        <input
                                            type="text"
                                            wire:model="shippingAddress.address_line2"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                            placeholder="Apartment, suite, etc. (optional)"
                                        >
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">City</label>
                                        <input
                                            type="text"
                                            wire:model="shippingAddress.city"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        >
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">State</label>
                                        <input
                                            type="text"
                                            wire:model="shippingAddress.state"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        >
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Postal code</label>
                                        <input
                                            type="text"
                                            wire:model="shippingAddress.postal_code"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        >
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                                        <input
                                            type="text"
                                            wire:model="shippingAddress.phone"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Navigation -->
                            <div class="p-6 bg-gray-50 flex justify-between items-center rounded-b-lg">
                                <button
                                    wire:click="setStep(2)"
                                    class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                >
                                    Back to Products
                                </button>
                                <button
                                    wire:click="proceedToPayment"
                                    @disabled(!$canProceedToPayment)
                                    class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    Continue to Payment
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
