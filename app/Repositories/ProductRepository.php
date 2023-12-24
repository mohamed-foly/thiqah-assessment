<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductRepository extends Product implements ProductRepositoryInterface
{

    public function create(string $name, string $description, UploadedFile $file, string $price, string $slug, bool $is_active): Product
    {
        $filePath = $file->storeAs('/uploads/images', Str::slug($name) . '_' . time() . '.' . $file->getClientOriginalExtension());

        return parent::create([
            'name' => $name,
            'description' => $description,
            'image' => $filePath,
            'price' => $price,
            'slug' => $slug,
            'is_active' => $is_active,
        ]);
    }

    public function updateImage(UploadedFile $file): Product
    {
        if (Storage::exists($this->image)) {
            Storage::delete($this->image);
        }
        $filePath = $file->storeAs('/uploads/images', Str::slug($this->name) . '_' . time() . '.' . $file->getClientOriginalExtension(), 'public');

        $this->update(['image' => $filePath]);
        return $this;
    }

    public function delete()
    {
        if (Storage::exists($this->image)) {
            Storage::delete($this->image);
        }
        parent::delete();
    }
}
