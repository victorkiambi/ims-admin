<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    protected $queryString = ['search'];

    public function mount()
    {
        // No need to define products here as we'll use it in render()
    }

    public function render()
    {
        return view('livewire.product.index', [
            'products' => Product::with(['category' => function ($query) {
                $query->select('id', 'name');
            }])
                ->when($this->search, function($query) {
                    $query->where(function($query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('price', 'like', '%' . $this->search . '%')
                            ->orWhereHas('category', function($query) {
                                $query->where('name', 'like', '%' . $this->search . '%');
                            });
                    });
                })
                ->paginate(10) // 10 items per page
        ]);
    }

    public function edit($id)
    {
        return redirect()->to('products/' . $id . '/edit');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

}
