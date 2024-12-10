<?php

namespace App\Livewire\Product;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $description;

    public $stock;
    public $price;
    public $category_id;

    public $categories;
    public $types;
    public $product_id;

    public function render()
    {
        return view('livewire.product.create');
    }

    public function mount($productId = null)
    {
        $this->categories = Category::all();
        $this->types = ProductType::all();

        if ($productId) {
            $product = Product::find($productId);
            $this->name = $product->name;
            $this->description = $product->description;
            $this->stock = $product->stock;
            $this->price = $product->price;

            Log::info($product);
        } else {
            $this->name = '';
            $this->description = '';
            $this->stock = '';
            $this->price = '';
        }
    }
}
