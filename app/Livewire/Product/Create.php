<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $description;
    public $price;
    public $stock;
    public $category_id;
    public $sku;
    public $image;
    public $status = 'active';

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|unique:products,sku|max:50',
            'image' => 'nullable|image|max:1024', // max 1MB
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter a product name.',
            'description.required' => 'Please provide a product description.',
            'price.required' => 'Please enter a price.',
            'price.numeric' => 'Price must be a valid number.',
            'stock.required' => 'Please enter the stock quantity.',
            'stock.integer' => 'Stock must be a whole number.',
            'category_id.required' => 'Please select a category.',
            'sku.required' => 'Please enter a SKU.',
            'sku.unique' => 'This SKU is already in use.',
            'image.image' => 'The file must be an image.',
            'image.max' => 'Image size should not exceed 1MB.',
        ];
    }

    public function generateSku()
    {
        $this->sku = strtoupper(Str::random(8));
    }

    public function save()
    {
        $validatedData = $this->validate();

        // Handle image upload if present
        if ($this->image) {
            $validatedData['image'] = $this->image->store('products', 'public');
        }

        // Create product
        Product::create($validatedData);

        // Show success message
        session()->flash('success', 'Product created successfully!');

        // Reset form
        $this->reset();

        // Redirect to products list
        return $this->redirect('/products', navigate: true);
    }

    public function render()
    {
        return view('livewire.product.create', [
            'categories' => Category::orderBy('name')->get()
        ]);
    }
}
