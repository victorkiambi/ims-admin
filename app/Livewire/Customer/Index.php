<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Livewire\Component;

class Index extends Component
{

    #[Url]
    public $search = '';

    public function render()
    {
        return view('livewire.customer.index', [
            'customers' => Customer::query()
                ->when($this->search, function($query) {
                    $query->where(function($query) {
                        $query->where('name', 'like', "%{$this->search}%")
                            ->orWhere('email', 'like', "%{$this->search}%")
                            ->orWhere('phone', 'like', "%{$this->search}%");
                    });
                })
                ->withCount('orders')
                ->withSum('orders', 'total')
                ->latest()
                ->paginate(10)
        ]);
    }
}
