<?php

namespace App\Livewire\Order;

use App\Models\Customer;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;

    public $currentStep = 1;
    public $customerSearch = '';
    public $selectedCustomerId = null;
    public $items = [];
    public $paymentDetails = [];

    // Step validation flags
    public $canProceedToProducts = false;
    public $canProceedToShipping = false;
    public $canProceedToPayment = false;

    public $productSearch = '';
    public $selectedProducts = [];
    public $quantities = [];
    public $customerAddresses = [];

    protected $rules = [
        'selectedProducts' => 'required|array|min:1',
        'quantities.*' => 'required|integer|min:1'
    ];

    public $selectedAddressId = null;
    public $shippingAddress = [
        'type' => 'home',
        'address_line1' => '',
        'address_line2' => '',
        'city' => '',
        'state' => '',
        'postal_code' => '',
        'phone' => ''
    ];
    public function mount()
    {
        $this->resetState();
    }

    public function resetState()
    {
        $this->currentStep = 1;
        $this->customerSearch = '';
        $this->selectedCustomerId = null;
        $this->items = [];
        $this->shippingAddress = [];
        $this->paymentDetails = [];
        $this->canProceedToProducts = false;
        $this->canProceedToShipping = false;
        $this->canProceedToPayment = false;
    }

    public function setStep($step)
    {
        if ($step === 2 && !$this->canProceedToProducts) {
            return;
        }
        if ($step === 3 && !$this->canProceedToShipping) {
            return;
        }
        if ($step === 4 && !$this->canProceedToPayment) {
            return;
        }

        $this->currentStep = $step;
    }

    public function selectCustomer($customerId)
    {
        $this->selectedCustomerId = $customerId;
        $this->canProceedToProducts = true;
        $this->setStep(2);
    }

    public function createNewCustomer()
    {
        // Logic to show customer creation modal or redirect
    }

    public function getCustomersProperty()
    {
        if (empty($this->customerSearch)) {
            return collect();
        }

        return Customer::query()
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->customerSearch}%")
                    ->orWhere('email', 'like', "%{$this->customerSearch}%")
                    ->orWhere('phone', 'like', "%{$this->customerSearch}%");
            })
            ->withCount('orders')
            ->orderBy('name')
            ->take(5)
            ->get();
    }
    public function addProduct($productId)
    {
        if (!in_array($productId, $this->selectedProducts)) {
            $this->selectedProducts[] = $productId;
            $this->quantities[$productId] = 1;
        }
    }

    public function removeProduct($productId)
    {
        $this->selectedProducts = array_values(array_filter(
            $this->selectedProducts,
            fn($id) => $id != $productId
        ));
        unset($this->quantities[$productId]);
    }

    public function updateQuantity($productId, $quantity)
    {
        $this->quantities[$productId] = max(1, intval($quantity));
    }

    public function getProductsProperty()
    {
        if (empty($this->productSearch)) {
            return collect();
        }

        return Product::query()
//            ->where('status', 'active')
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->productSearch}%");
//                    ->orWhere('sku', 'like', "%{$this->productSearch}%");
            })
            ->get();
    }

    public function getSelectedProductDetailsProperty()
    {
        return Product::whereIn('id', $this->selectedProducts)->get();
    }

    public function getOrderTotalProperty()
    {
        return $this->selectedProductDetails->sum(function ($product) {
            return $product->price * ($this->quantities[$product->id] ?? 0);
        });
    }

    public function proceedToShipping()
    {
        // Validate products are selected
        if (empty($this->selectedProducts)) {
            return;
        }

        // Enable shipping step and move to it
        $this->canProceedToShipping = true;
        $this->currentStep = 3;
    }
    public function getCustomerAddressesProperty()
    {
        if (!$this->selectedCustomerId) {
            return collect(); // Return empty collection if no customer selected
        }

        return Customer::find($this->selectedCustomerId)
            ->addresses()
            ->get(); // This returns a collection instead of an array
    }

    public function updatedSelectedAddressId($value)
    {
        if ($value) {
            $address = $this->customerAddresses->find($value);
            $this->shippingAddress = [
                'type' => $address->type,
                'address_line1' => $address->address_line1,
                'address_line2' => $address->address_line2,
                'city' => $address->city,
                'state' => $address->state,
                'postal_code' => $address->postal_code,
                'phone' => $address->phone
            ];
        }
    }
    public function render()
    {
        return view('livewire.order.create', [
            'customers' => $this->customers,
        ]);
    }

}
