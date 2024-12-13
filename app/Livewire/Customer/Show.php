<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public $customer;

    #[Url]
    public $orderSearch = '';

    public function mount($customerId)
    {
        $this->customer = Customer::findOrFail($customerId);
    }

    public function render()
    {
        $orders = $this->customer->orders()
            ->with('orderItems.product')
            ->withCount('orderItems')
            ->when($this->orderSearch, function($query) {
                $query->where('id', 'like', "%{$this->orderSearch}%");
            })
            ->latest()
            ->paginate(10);

        Log::info($orders);

        return view('livewire.customer.show', [
            'orders' => $orders
        ]);
    }
}
