<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Edit extends Component
{
    use WithFileUploads;

    public $productId;
    public $name;
    public $description;
    public $price;
    public $stock;
    public $quantity;
    public $category_id;
    public $sku;
    public $image;
    public $status;
    public $currentImage;

    public function mount($product)
    {
        $product = Product::findOrFail($product);
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->quantity = $product->quantity;
        $this->category_id = $product->category_id;
        $this->sku = $product->sku;
        $this->status = $product->status;
        $this->currentImage = $product->image_url;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|max:50|unique:products,sku,' . $this->productId,
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
            'quantity.required' => 'Please enter the quantity.',
            'quantity.integer' => 'Quantity must be a whole number.',
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

    public function update()
    {
        $validatedData = $this->validate();

        $product = Product::findOrFail($this->productId);

        // Handle image upload if present
        if ($this->image) {
            $validatedData['image_url'] = $this->image->store('products', 'public');
        }

        // Remove image from validated data if no new image was uploaded
        if (!isset($validatedData['image_url'])) {
            unset($validatedData['image']);
        }

        $product->update($validatedData);

        session()->flash('success', 'Product updated successfully!');

        return $this->redirect('/products', navigate: true);
    }

    public function render()
    {
        return view('livewire.product.edit', [
            'categories' => Category::orderBy('name')->get()
        ]);
    }
}
