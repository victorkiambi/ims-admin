<?php

namespace App\Livewire\Order;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Livewire\Component;
use Illuminate\Support\Collection;

class Edit extends Component
{
    public $order;
    public $customer_id;
    public $status;
    public $payment_method;
    public $notes;
    public $items = [];
    public $total = 0;

    public function mount($order)
    {
        $order = Order::with('orderItems.product')->findOrFail($order);
        $this->order = $order;
        $this->customer_id = $order->customer_id;
        $this->status = $order->status;
        $this->payment_method = $order->payment_method;
        $this->notes = $order->notes;
        
        // Initialize items from order
        foreach ($order->orderItems as $item) {
            $this->items[] = [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'subtotal' => $item->quantity * $item->price,
            ];
        }
        
        $this->calculateTotal();
    }

    public function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'payment_method' => 'required|in:cash,credit_card,bank_transfer',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'Please select a customer.',
            'status.required' => 'Please select an order status.',
            'payment_method.required' => 'Please select a payment method.',
            'items.required' => 'Please add at least one item to the order.',
            'items.*.product_id.required' => 'Please select a product.',
            'items.*.quantity.required' => 'Please enter a quantity.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
            'items.*.price.required' => 'Please enter a price.',
            'items.*.price.min' => 'Price must be greater than 0.',
        ];
    }

    public function addItem()
    {
        $this->items[] = [
            'product_id' => '',
            'quantity' => 1,
            'price' => 0,
            'subtotal' => 0,
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotal();
    }

    public function updatedItems($value, $key)
    {
        $segments = explode('.', $key);
        if (count($segments) === 3) {
            $index = $segments[0];
            if (isset($this->items[$index])) {
                $this->calculateItemSubtotal($index);
                $this->calculateTotal();
            }
        }
    }

    public function calculateItemSubtotal($index)
    {
        if (isset($this->items[$index]['quantity']) && isset($this->items[$index]['price'])) {
            $this->items[$index]['subtotal'] = $this->items[$index]['quantity'] * $this->items[$index]['price'];
        }
    }

    public function calculateTotal()
    {
        $this->total = collect($this->items)->sum('subtotal');
    }

    public function update()
    {
        $validatedData = $this->validate();
        
        $this->order->update([
            'customer_id' => $this->customer_id,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
            'notes' => $this->notes,
            'total' => $this->total,
        ]);

        // Delete existing order items
        $this->order->orderItems()->delete();

        // Create new order items
        foreach ($this->items as $item) {
            $this->order->orderItems()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // Update product stock
            $product = Product::find($item['product_id']);
            $product->decrement('stock', $item['quantity']);
        }

        session()->flash('success', 'Order updated successfully!');

        return $this->redirect('/orders', navigate: true);
    }

    public function getProductPrice($productId)
    {
        if ($product = Product::find($productId)) {
            return $product->price;
        }
        return 0;
    }

    public function render()
    {
        return view('livewire.order.edit', [
            'customers' => Customer::orderBy('name')->get(),
            'products' => Product::where('status', 'active')
                ->where('stock', '>', 0)
                ->orderBy('name')
                ->get(),
        ]);
    }
}