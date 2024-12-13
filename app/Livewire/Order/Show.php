<?php

namespace App\Livewire\Order;

use App\Models\Order;


use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Show extends Component
{
    public $order;
    public $showStatusModal = false;
    public $showPaymentModal = false;
    public $newStatus;
    public $newPaymentStatus;
    public $paymentAmount;
    public $paymentNote;

    protected $rules = [
        'newStatus' => 'required|in:pending,processing,completed,cancelled',
        'newPaymentStatus' => 'required|in:paid,unpaid,partial',
        'paymentAmount' => 'required_if:newPaymentStatus,partial|numeric|min:0',
        'paymentNote' => 'nullable|string|max:255'
    ];

    public function mount($orderId)
    {
        $this->order = Order::with([
            'customer',
            'orderItems',
            'orderItems.product' => function($query) {
                $query->select(['id', 'name', 'price']); // Add whatever columns you need
            }
        ])->findOrFail($orderId);
        $this->newStatus = $this->order->status;
        $this->newPaymentStatus = $this->order->payment_status;
        Log::info($this->order);
    }
    public function render()
    {
        return view('livewire.order.show');
    }
    public function updateStatus()
    {
        $this->validate([
            'newStatus' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $this->order->update([
            'status' => $this->newStatus
        ]);

        $this->showStatusModal = false;
        session()->flash('message', 'Order status updated successfully.');
    }

    public function updatePayment()
    {
        $this->validate();

        $this->order->update([
            'payment_status' => $this->newPaymentStatus,
            'amount_paid' => $this->paymentAmount ?? $this->order->total
        ]);

        // Add payment record if you have a payments table
        if ($this->paymentAmount) {
            $this->order->payments()->create([
                'amount' => $this->paymentAmount,
                'note' => $this->paymentNote
            ]);
        }

        $this->showPaymentModal = false;
        session()->flash('message', 'Payment status updated successfully.');
    }

}
