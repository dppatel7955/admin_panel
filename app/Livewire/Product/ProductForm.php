<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('livewire.layout.app')]
#[Title('Product')]
class ProductForm extends Component
{
    use WithFileUploads;

    public ?Product $product = null;

    public $images = [];
    public array $existingImages = [];

    public string $name = '';
    public string $slug = '';
    public string $description = '';
    public int $category_id;
    public int $brand_id;
    public float $price;
    public ?float $sale_price = null;
    public int $stock;
    public string $sku;
    public int $sort_order = 0;
    public bool $status = true;

    public function mount($id = null)
    {
        if ($id) {
            $this->product = Product::findOrFail($id);

            $this->fill($this->product->toArray());
            $this->existingImages = $this->product->images ?? [];
            $this->images = [];
        }
    }

    protected function rules()
    {
        return [
            'name'        => 'required',
            'slug'        => 'required|unique:products,slug,' . ($this->product->id ?? 'null'),
            'category_id' => 'required|exists:categories,id',
            'brand_id'    => 'required|exists:brands,id',
            'price'       => 'required|numeric',
            'sale_price'  => 'nullable|numeric',
            'stock'       => 'required|integer',
            'sku'         => 'required|unique:products,sku,' . ($this->product->id ?? 'null'),
            'images.*'    => 'nullable|image|max:2048',
        ];
    }

    public function updatedName()
    {
        if (! $this->product) {
            $this->slug = Str::slug($this->name);
        }
    }

    public function save()
    {
        $this->validate();

        $imagePaths = $this->existingImages;

        foreach ($this->images as $img) {
            $imagePaths[] = $img->store('products', 'public');
        }

        Product::updateOrCreate(
            ['id' => $this->product?->id],
            array_merge(
                $this->only([
                    'name','slug','description','category_id','brand_id',
                    'price','sale_price','stock','sku','sort_order','status'
                ]),
                ['images' => $imagePaths]
            )
        );

        return redirect()->route('products.index')
            ->with('success', 'Product saved successfully');
    }
    public function removeExistingImage($index)
    {
        if (! isset($this->existingImages[$index])) {
            return;
        }

        $imagePath = $this->existingImages[$index];

        // 1️⃣ Delete file from storage
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        // 2️⃣ Remove from array
        unset($this->existingImages[$index]);
        $this->existingImages = array_values($this->existingImages);

        // 3️⃣ Save immediately to DB (optional but recommended)
        if ($this->product) {
            $this->product->update([
                'images' => $this->existingImages
            ]);
        }
    }
    public function render()
    {
        return view('livewire.product.product-form', [
            'categories' => Category::orderBy('name')->get(),
            'brands' => Brand::orderBy('name')->get(),
        ]);
    }
}
