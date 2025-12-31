<?php

namespace App\Livewire\Brand;

use Livewire\Component;
use App\Models\Brand;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithoutUrlPagination;

#[Layout('livewire.layout.app')]
#[Title('Brands')]
class BrandList extends Component
{
    use WithPagination,WithoutUrlPagination;

    public string $search = '';
    public string $statusFilter = 'all';

    protected $paginationTheme = 'tailwind';
    protected $queryString = [];
    /* =====================
        RESET PAGE ON FILTER
    ====================== */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    /* =====================
        TOGGLE STATUS
    ====================== */
    public function toggleStatus($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->update([
            'status' => ! $brand->status
        ]);
    }

    /* =====================
        DELETE
    ====================== */
    public function confirmDelete($id)
    {
        Brand::findOrFail($id)->delete();

        session()->flash('success', 'Brand deleted successfully.');
    }

    /* =====================
        RENDER
    ====================== */
    public function render()
    {
        $brands = Brand::query()
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter !== 'all', function ($q) {
                $q->where('status', $this->statusFilter === 'active');
            })
            ->orderBy('sort_order')
            ->paginate(10);

        return view('livewire.brand.brand-list', compact('brands'));
    }
}
