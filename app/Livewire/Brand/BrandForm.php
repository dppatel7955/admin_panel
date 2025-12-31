<?php

namespace App\Livewire\Brand;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Brand;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('livewire.layout.app')]
#[Title('Dashboard')]
class BrandForm extends Component
{
    use WithFileUploads;

    public ?Brand $brand = null;

    public $name, $slug, $image, $sort_order = 0, $status = 1,$existingImage;

    public function mount($id = null)
    {
        if ($id) {
            $this->brand = Brand::findOrFail($id);
            $this->fill($this->brand->toArray());
            $this->existingImage = $this->brand->image;
            $this->image = null;
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|min:2',
            'slug' => 'required|unique:brands,slug,' . $this->brand?->id,
            'image' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|boolean',
        ];
    }

    public function updatedName()
    {
        $this->slug = Str::slug($this->name);
    }

    public function save()
    {
        $this->validate();

        if ($this->image) {
            $this->image = $this->image->store('brands', 'public');
        }

        Brand::updateOrCreate(
            ['id' => $this->brand?->id],
            $this->only('name', 'slug', 'image', 'sort_order', 'status')
        );

        $msg = $this->brand ? 'Brand update successfully' : 'Brand create successfully';
        $this->dispatch('notify', type: 'success', message: $msg);
        return $this->redirectRoute('brands.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.brand.brand-form');
    }
}
