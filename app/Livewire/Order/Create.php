<?php

namespace App\Livewire\Order;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;

    // Customer Selection
    public $customerSearch = '';
    public $selectedCustomerId = null;
    public $selectedCustomer = null;

    // Order Items
    public $orderItems = [];
    public $productSearch = '';
    public $searchResults = [];

    // Order Details
    public $payment_method = 'cash';
    public $notes;
    public $total = 0;
    public $status = 'pending';

    // Address Details
    public $useExistingAddress = true;
    public $selectedAddressId = null;
    public $shippingAddress = [
        'address_line1' => '',
        'address_line2' => '',
        'city' => '',
        'state' => '',
        'postal_code' => '',
        'phone' => ''
    ];
    public $useSameForBilling = true;
    public $billingAddress = [
        'address_line1' => '',
        'address_line2' => '',
        'city' => '',
        'state' => '',
        'postal_code' => '',
        'phone' => ''
    ];

    protected $listeners = ['productSelected'];

    public function mount()
    {
        $this->orderItems = [
            $this->newOrderItem()
        ];
    }

    private function newOrderItem()
    {
        return [
            'product_id' => '',
            'product_name' => '',
            'quantity' => 1,
            'price' => 0,
            'stock' => 0,
            'subtotal' => 0
        ];
    }

    public function searchCustomers()
    {
        if (strlen($this->customerSearch) >= 2) {
            return Customer::where('name', 'like', "%{$this->customerSearch}%")
                ->orWhere('email', 'like', "%{$this->customerSearch}%")
                ->orWhere('phone', 'like', "%{$this->customerSearch}%")
                ->take(5)
                ->get();
        }
        return [];
    }

    public function selectCustomer($customerId)
    {
        $this->selectedCustomer = Customer::find($customerId);
        $this->selectedCustomerId = $customerId;
        $this->customerSearch = '';
    }

    public function searchProducts($index)
    {
        if (strlen($this->productSearch) >= 2) {
            $this->searchResults = Product::where('status', 'active')
                ->where(function ($query) {
                    $query->where('name', 'like', "%{$this->productSearch}%")
                        ->orWhere('sku', 'like', "%{$this->productSearch}%");
                })
                ->where('stock', '>', 0)
                ->take(5)
                ->get();
        }
    }

    public function selectProduct($index, Product $product)
    {
        $this->orderItems[$index]['product_id'] = $product->id;
        $this->orderItems[$index]['product_name'] = $product->name;
        $this->orderItems[$index]['price'] = $product->price;
        $this->orderItems[$index]['stock'] = $product->stock;
        $this->calculateSubtotal($index);
        $this->productSearch = '';
        $this->searchResults = [];
    }

    public function addItem()
    {
        $this->orderItems[] = $this->newOrderItem();
    }

    public function removeItem($index)
    {
        unset($this->orderItems[$index]);
        $this->orderItems = array_values($this->orderItems);
        $this->calculateTotal();
    }

    public function calculateSubtotal($index)
    {
        $item = $this->orderItems[$index];
        $this->orderItems[$index]['subtotal'] = $item['quantity'] * $item['price'];
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = collect($this->orderItems)->sum('subtotal');
    }

    public function updatedSelectedAddressId()
    {
        if ($this->selectedAddressId && $this->selectedCustomer) {
            $address = $this->selectedCustomer->addresses()->find($this->selectedAddressId);
            if ($address) {
                $this->shippingAddress = [
                    'address_line1' => $address->address_line1,
                    'address_line2' => $address->address_line2,
                    'city' => $address->city,
                    'state' => $address->state,
                    'postal_code' => $address->postal_code,
                    'phone' => $address->phone
                ];

                if ($this->useSameForBilling) {
                    $this->billingAddress = $this->shippingAddress;
                }
            }
        }
    }

    public function updatedUseSameForBilling($value)
    {
        if ($value) {
            $this->billingAddress = $this->shippingAddress;
        }
    }

    public function save()
    {
        $this->validate([
            'selectedCustomerId' => 'required',
            'orderItems.*.product_id' => 'required',
            'orderItems.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,credit_card,bank_transfer',
            'shippingAddress.address_line1' => 'required',
            'shippingAddress.city' => 'required',
            'shippingAddress.state' => 'required',
            'shippingAddress.postal_code' => 'required',
            'shippingAddress.phone' => 'required',
        ]);

        $order = Order::create([
            'customer_id' => $this->selectedCustomerId,
            'total' => $this->total,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
            'shipping_address' => json_encode($this->shippingAddress),
            'billing_address' => json_encode($this->useSameForBilling ? $this->shippingAddress : $this->billingAddress),
            'notes' => $this->notes,
        ]);

        foreach ($this->orderItems as $item) {
            $order->orderItems()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);

            // Update product stock
            Product::find($item['product_id'])->decrement('stock', $item['quantity']);
        }

        session()->flash('success', 'Order created successfully!');
        return $this->redirect('/orders', navigate: true);
    }

    public function render()
    {
        return view('livewire.order.create', [
            'customers' => strlen($this->customerSearch) >= 2 ? $this->searchCustomers() : [],
            'customerAddresses' => $this->selectedCustomer ? $this->selectedCustomer->addresses : collect(),
        ]);
    }
}