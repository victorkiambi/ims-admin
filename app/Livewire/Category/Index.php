<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class Index extends Component
{
    public $categories;

    public $name;
    public $description;

    public function render()
    {
        return view('livewire.category.index');
    }

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        Category::create([
            'name' => $this->name,
            'description' => $this->description,
            'slug' => Str::slug($this->name),
        ]);

        $this->name = '';
        $this->description = '';

        $this->categories = Category::all();
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        $this->categories = Category::all();
    }
}
