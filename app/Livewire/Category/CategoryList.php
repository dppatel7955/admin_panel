<?php

namespace App\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithoutUrlPagination;

#[Layout('livewire.layout.app')]
#[Title('Categories')]
class CategoryList extends Component
{
    use WithPagination,WithoutUrlPagination;

    public string $search = '';
    public string $statusFilter = 'all';

    protected $paginationTheme = 'tailwind';
    protected $queryString = [];
    /* =====================
        RESET PAGE
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
        $category = Category::findOrFail($id);
        $category->update([
            'status' => ! $category->status
        ]);
    }

    /* =====================
        DELETE
    ====================== */
    public function confirmDelete($id)
    {
        Category::findOrFail($id)->delete();

        session()->flash('success', 'Category deleted successfully.');
    }

    /* =====================
        RENDER
    ====================== */
    public function render()
    {
        $categories = Category::query()
            ->whereNull('parent_id') // ONLY PARENTS
            ->with('children')
            ->when($this->search, fn ($q) =>
                $q->where('name', 'like', '%' . $this->search . '%')
            )
            ->when($this->statusFilter !== 'all', fn ($q) =>
                $q->where('status', $this->statusFilter === 'active')
            )
            ->orderBy('sort_order')
            ->paginate(10);

        return view('livewire.category.category-list', compact('categories'));
    }
}
