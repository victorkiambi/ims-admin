<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class Show extends Component
{
    public $products;
    public function render()
    {
        return view('livewire.product.show');
    }

    public function mount()
    {
        $this->products = Product::with('category')->get();
    }
}
