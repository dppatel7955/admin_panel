<?php

namespace App\Livewire\Category;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('livewire.layout.app')]
#[Title('Category')]
class CategoryForm extends Component
{
    use WithFileUploads;

    public ?Category $category = null;

    public string $name = '';
    public string $slug = '';
    public ?int $parent_id = null;

    public $image;                // new upload
    public ?string $existingImage = null;

    public int $sort_order = 0;
    public bool $status = true;

    /* ======================
        MOUNT (EDIT)
    ====================== */
    public function mount($id = null)
    {
        if ($id) {
            $this->category = Category::findOrFail($id);

            $this->name       = $this->category->name;
            $this->slug       = $this->category->slug;
            $this->parent_id  = $this->category->parent_id;
            $this->sort_order = $this->category->sort_order;
            $this->status     = (bool) $this->category->status;

            $this->existingImage = $this->category->image;
            $this->image = null;
        }
    }

    /* ======================
        RULES
    ====================== */
    protected function rules()
    {
        return [
            'name'       => 'required|string|max:255',
            'slug'       => 'required|string|unique:categories,slug,' . ($this->category->id ?? 'null'),
            'parent_id'  => 'nullable|exists:categories,id',
            'image'      => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer',
            'status'     => 'boolean',
        ];
    }

    /* ======================
        AUTO SLUG
    ====================== */
    public function updatedName()
    {
        if (! $this->category) {
            $this->slug = Str::slug($this->name);
        }
    }

    /* ======================
        SAVE
    ====================== */
    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'parent_id' => $this->parent_id,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
        ];
        $imagePath = $this->existingImage;

        if ($this->image) {
            if ($this->category && $this->category->image &&
                Storage::disk('public')->exists($this->category->image)) {

                Storage::disk('public')->delete($this->category->image);
            }

            $data['image'] = $this->image->store('categories', 'public');
            $imagePath = $this->image->store('categories', 'public');
        }

        Category::updateOrCreate(
            ['id' => $this->category?->id],
            [
                'name'       => $this->name,
                'slug'       => $this->slug,
                'parent_id'  => $this->parent_id,
                'image'      => $imagePath,
                'sort_order' => $this->sort_order,
                'status'     => $this->status,
            ]
        );

        $msg = $this->category ? 'Category update successfully' : 'Category create successfully';
        $this->dispatch('notify', type: 'success', message: $msg);
        return $this->redirectRoute('categories.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.category.category-form', [
            'parents' => Category::whereNull('parent_id')
                ->when($this->category, fn ($q) =>
                    $q->where('id', '!=', $this->category->id)
                )
                ->orderBy('name')
                ->get(),
        ]);
    }
}
