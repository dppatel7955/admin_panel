<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithoutUrlPagination;

#[Layout('livewire.layout.app')]
#[Title('Products')]
class ProductList extends Component
{
    use WithPagination,WithoutUrlPagination;

    public string $search = '';
    public string $statusFilter = 'all';

    protected $paginationTheme = 'tailwind';
    protected $queryString = [];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['status' => ! $product->status]);
    }

    public function confirmDelete($id)
    {
        Product::findOrFail($id)->delete();
        session()->flash('success', 'Product deleted successfully');
    }

    public function render()
    {
        $products = Product::with(['category', 'brand'])
            ->when($this->search, fn ($q) =>
                $q->where('name', 'like', "%{$this->search}%")
                  ->orwhere('sku', 'like', "%{$this->search}%")
            )
            ->when($this->statusFilter !== 'all', fn ($q) =>
                $q->where('status', $this->statusFilter === 'active')
            )
            ->orderBy('sort_order')
            ->paginate(10);

        return view('livewire.product.product-list', compact('products'));
    }
}
